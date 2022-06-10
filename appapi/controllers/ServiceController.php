<?php
namespace appapi\controllers;

use appapi\dao\CommonDao;
use appapi\helpers\Common;
use appapi\logic\CommonLogic;
use appapi\models\advert\StartPage;
use appapi\models\Announcement;
use appapi\models\apps\AppsCheckSwitch;
use appapi\models\Domain;
use common\helpers\Tool;
use common\models\apps\AppsVersion;
use common\models\IpAddress;
use Yii;
use yii\helpers\ArrayHelper;

class ServiceController extends BaseController
{
    /**
     * 初始检测
     * @return array
     */
    public function actionCheckSetting()
    {
        $commonLogic = new CommonLogic();
        // 帮助等页面链接
        $helpLink = [
            'screen'             => $commonLogic->getDomain(Domain::TYPE_PAGE) . '/site/screen-helper',
            'notify'             => $commonLogic->getDomain(Domain::TYPE_PAGE) . '/site/notify',
            'privacy_policy'     => $commonLogic->getDomain(Domain::TYPE_PAGE) . '/site/privacy-policy',
            'vip_policy'         => $commonLogic->getDomain(Domain::TYPE_PAGE) . '/site/vip-policy',
            'user_agreement'     => $commonLogic->getDomain(Domain::TYPE_PAGE) . '/site/user-agreement',
            'logoff_protocol'    => $commonLogic->getDomain(Domain::TYPE_PAGE) . '/site/logoff-protocol',
            'membership_service' => $commonLogic->getDomain(Domain::TYPE_PAGE) . '/site/membership-service',
        ];

        $commonDao = new CommonDao();
        return [
            'version_update' => $this->_buildUpdateInfo(),
            'push_passageway' => $commonDao->pushPassageway(), // 安卓推送
            'start_page' => (object)StartPage::find()->where(['status' => StartPage::STATUS_ENABLED])->orderBy('id desc')->one(),
            'system_setting' => [
                'currency_unit' => Yii::$app->setting->get('system.currency_unit')
            ],
            'wechat_api_url' => WECHAT_OAUTH2 . '?',
            'help_link' => $helpLink,
            'area_check' => $this->_buildAreaCheckInfo(),
        ];
    }

    /**
     * 检测ip是否可访问
     * @return array
     */
    public function actionCheckIp() {
        $ip = $this->getParam('ip');

        return $this->_buildAreaCheckInfo($ip);
    }

    /**
     * ip检测
     * @param $ip
     * @return array
     */
    private function _buildAreaCheckInfo($ip=null) {
        if (empty($ip)) {
            $ip = Tool::getIp();
        }
        $checkInfo = [
            'status' => 0,
            'title' => '',
            'msg' => '',
            'detail' => [],
        ];
        if (empty($ip) || $ip == '127.0.0.1') {
            return $checkInfo;
        }

        $ipAddress = IpAddress::find()
            ->where(['ip' => $ip])
            ->asArray()
            ->one();

        //查询ip所属区域
        if (empty($ipAddress)) {
            $ipAddress = Tool::getIpAddress($ip);

            if (empty($ipAddress)) {
                return $checkInfo;
            }

            // $objIpAddress = new IpAddress();
            // $objIpAddress->ip = $ip;
            // $objIpAddress->area = $ipAddress['area'];
            // $objIpAddress->province = $ipAddress['province'];
            // $objIpAddress->city = $ipAddress['city'];
            // $objIpAddress->created_at = time();
            // $objIpAddress->save();
        }

        //为了区分 大陆和香港台湾,做一下特殊处理
        if ($ipAddress['area'] == '中国') {
            if (in_array($ipAddress['province'], ['香港', '台湾'])) {
                $ipAddress['area'] = $ipAddress['province'];
            } else {
                $ipAddress['area'] = Common::$areaTexts[Common::AREA_CHINA];
            }
        }

        //未定义的区域 归到 其他
        if (!in_array($ipAddress['area'], Common::$areaTexts)) {
            $ipAddress['area'] = Common::$areaTexts[Common::AREA_OTHER];
        }

        //检测区域是否支持播放
        $areaLimit = Yii::$app->setting->get('system.area_limit');
        $areaIds = explode(',', $areaLimit);
        //允许的区域
        $allowAreas = ArrayHelper::filter(Common::$areaTexts, $areaIds);

        if (!in_array($ipAddress['area'], $allowAreas)) {
            $checkInfo = [
                'status' => 1,
                'title' => '提示',
                'msg' => '暂不支持所在地区的用户访问',
                'detail' => [
                    'IP地址：'. $ip,
                    'IP来源：'. $ipAddress['area'],
                    '该站点目前只针对'. implode('、', $allowAreas).'开放。',
                    '若您在以上国家或地区不能正常访问，请联系客服。'
                ],
            ];
        }

        return $checkInfo;
    }

    /**
     * 构建更新信息
     * @return array
     */
    private function _buildUpdateInfo() {
        
        $versionUpdate = [
            'status' => 0,  // 更新状态 0-不更新，1-更新，2-强制更新
            'msg'    => '',    // 更新信息
            'url'    => '',    // 下载地址
        ];

        /**
         * 
         * os_type  端类型 1-iOS 2-Android    
         * is_release 是否发布 1-发布 0-未发布  
         * ver_sn    版本号
         * marketChannel  渠道来源
         * 
         */

        // 获取系统版本为发布状态且大于当前版本的版本记录  IOS版本控制处理逻辑 todo
        $versionList = AppsVersion::find()
            ->andWhere(['os_type' => $this->osType, 'is_release' => AppsVersion::RELEASE_ON])
            ->andWhere(['>', 'ver_sn', $this->ver])
            ->orderBy('ver_sn desc')->all();

        if (empty($versionList)) {
            return $versionUpdate;
        }
     
        //iOS端传的 是 AppStore
        // if($this->marketChannel == 'AppStore'){
        //     $channel='ios';
        // }else{
        //     $channel=($this->marketChannel == "tv")?"tv":$this->marketChannel;
        // }
        $marketChannel=strtolower($this->marketChannel);
        $channel=isset(AppsVersion::$channelType[$marketChannel]) ? AppsVersion::$channelType[$marketChannel]:$this->marketChannel;
    
        foreach ($versionList as $version) {
            //查询版本对应的 渠道的审核状态
            $checkSwitch = AppsCheckSwitch::find()
                ->andWhere(['version_id' => $version->id, 'channel' => $channel])
                ->one();
            if ($checkSwitch->status == AppsCheckSwitch::STATUS_OFF && $checkSwitch->file_path) {
                $versionUpdate['status'] = $version->force_update == AppsVersion::FORCE_UPDATE_YES ? 2 : 1;
                $versionUpdate['msg'] = $version->content;
                $versionUpdate['url'] = $checkSwitch->file_path;
                break;
            }
        }

        return $versionUpdate;
    }

    /**
     * 联系客户
     * @return array
     */
    public function actionAbout()
    {
        $commonLogic = new CommonLogic();
        $about = [
            [
                'title' => '软件许可及服务协议',
                'content' => $commonLogic->getDomain() . '/site/notify?' . http_build_query(['id' => Yii::$app->common->appId]),
                'action' => 'url'
            ],
            [
                'title' => '隐私政策',
                'content' => $commonLogic->getDomain() . '/site/privacy-policy?' . http_build_query(['id' => Yii::$app->common->appId]),
                'action' => 'url'
            ],
            [
                'title' => 'Email',
                'content' => Yii::$app->setting->get('serviceInfo.email'),
                'action' => 'email'
            ],
            [
                'title' => '客服电话',
                'content' => Yii::$app->setting->get('serviceInfo.telphone'),
                'action' => 'telphone'
            ],
            [
                'title' => 'QQ',
                'content' => Yii::$app->setting->get('serviceInfo.qq'),
                'action' => 'qq'
            ],
            [
                'title' => '微信',
                'content' => Yii::$app->setting->get('serviceInfo.wechat'),
                'action' => 'wechat'
            ]
        ];

        $data = ['about' => $about];
        // 版权信息
        $company = Yii::$app->setting->get('serviceInfo.company');
        if ($company) {
            $data['company'] = 'Copyright © '.date('Y').' ' . $company . '版权所有';
        }

        return $data;
    }


    /**
     * 返回可用域名
     */
    public function actionDomain()
    {
        $commonLogic = new CommonLogic();
        return $commonLogic->getDomain(Domain::TYPE_API);
    }

    /**
     * 探测接口
     */
    public function actionDetect()
    {
        return 'success';
    }

    /**
     * 广告
     * @return Announcement|null
     */
    public function actionAnnouncement()
    {
        $announcement = Announcement::findOne(['status' => Announcement::STATUS_ENABLED]);
        return $announcement ? $announcement->toArray() : ['title' => '', 'content' => ''];
    }
}
