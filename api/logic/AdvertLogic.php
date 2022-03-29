<?php
namespace api\logic;

use api\dao\AdvertDao;
use api\dao\VideoDao;
use api\exceptions\ApiException;
use api\helpers\ErrorCode;
use api\models\advert\AdvertPosition;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use common\models\IpAddress;
use common\models\pay\Expend;
use common\models\traits\PositionInterface;
use common\services\PayService;
use common\services\Setting;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * 广告逻辑类
 * Class AdvertLogic
 * @package api\logic
 */
class AdvertLogic
{
    /**
     * 获取对应位置的广告
     * @param $position
     * @return array
     */
    public function advertByPosition($position, $city='')
    {
        if (Yii::$app->setting->get('system.ad_switch') == Setting::SWITCH_OFF) { // 如果广告已关闭返回空
            return [];
        }
        $userLogic = new UserLogic();
        if ($userLogic->vipStatus()) { // 会员不显示广告
            return [];
        }
        
        $advertDao = new AdvertDao();
        // $advertId = $advertDao->advertIdByPosition($position); // 根据位置获取广告
        $advertId = $advertDao->advertIdByPosition($position, $city); // 根据位置获取广告

        if (empty($advertId)) {
            return [];
        }
        // 如果是首页和发现页，获取全部广告，其他位置随机获取一条广告
        // 首页和类目页广告，获取全部广告
         if ($position == AdvertPosition::POSITION_VIDEO_INDEX
            || $position == AdvertPosition::POSITION_VIDEO_INDEX_PC
            || $position == AdvertPosition::POSITION_VIDEO_TOPIC
             || $position == AdvertPosition::POSITION_VIDEO_CHANNEL_PC1) {
            $advert = [];
            foreach ($advertId as $id) {
                // 添加PV
                $this->increasePv($id);
                $advert[] = $advertDao->advertInfo($id);
            }
        } else {
            // 随机获取一个获取广告信息
            $advertId = $advertId[array_rand($advertId, 1)];
            $advert   = $advertDao->advertInfo($advertId);
            // 添加PV
            $this->increasePv($advertId);

            // 播放前广告添加展示时间，以及描述
            if ($position == AdvertPosition::POSITION_PLAY_BEFORE) {
                $advert['time'] = Yii::$app->setting->get('system.play_ad_time');
                $advert['desc'] = Yii::$app->setting->get('system.remove_ad_score') . Yii::$app->setting->get('system.currency_unit') . '去广告';
            }
        }

        return $advert;
    }


    /**
     * 增加广告pv
     * @param $advertId
     */
    public function increasePv($advertId)
    {
        //更新redis信息
        $redis = new RedisStore();
        //入库脚本添加观看次数
        $scriptKey = RedisKey::scriptAdvertPv();
        $redis->hmIncrBy($scriptKey, $advertId);
    }

    /**
     * 点击广告
     * @param $advertId
     * @return array
     */
    public function click($advertId)
    {
        // 获取广告信息
        $advertDao = new AdvertDao();
        $advert = $advertDao->advertInfo($advertId);
        if (!$advert) { // 没有广告信息直接返回
            return [];
        }
        
        // 写入库脚本信息,便于后面入库
        $redis = new RedisStore();
        $scriptKey = RedisKey::scriptAdvertClick();
        $redis->hmIncrBy($scriptKey, $advertId);

        return [];
    }

    /**
     * 去广告
     * @return bool
     * @throws ApiException
     */
    public function removeAd()
    {
        // 并发锁限制
        $lockKey = RedisKey::getApiLockKey('advert/remove-ad', ['uid' => Yii::$app->user->id]);
        $redis = new RedisStore();
        if ($redis->checkLock($lockKey)) {
            throw new ApiException(ErrorCode::EC_SYSTEM_OPERATING);
        }

        $uid = Yii::$app->user->id;;
        $score = Yii::$app->setting->get('system.remove_ad_score'); // 去广告的积分
        
        $userLogic = new UserLogic();
        $assets = $userLogic->assets();
        if (!$assets || $assets->score_remain < $score) {
            $redis->releaseLock($lockKey);
            throw new ApiException(ErrorCode::EC_SCORE_NOT_ENOUGH);
        }
        $payService = new PayService();

        list($tradeNo, $num) = $payService->interfacePay($uid, Expend::TYPE_REMOVE_AD, $score);  // 扣除积分
        if (!$tradeNo) {
            $redis->releaseLock($lockKey);
            throw new ApiException(ErrorCode::EC_REMOVE_AD_FAIL);
        }

        $redis->releaseLock($lockKey);
        return true;
    }

    /*
     * 瓜子tv展示亿忆分类信息帖子广告接口
     */
    public function getThreadAdInfo($citycode){
        $videodao = new VideoDao();
        $citys = $videodao->findcity($citycode);
        $city = $citys['city_name'];
        $url = "http://apwep.zhayieye.com/interface.php?app=guazitv&act=getThreadAdInfo";//post
        $data = [];
        $data['cityId'] = $this->getCityId($city);

        //需求城市id固定=2-悉尼
        if($data['cityId']==2){
            $result = Tool::httpPost($url,$data);
            $result['data'] = json_decode($result['data'],true);
        }else{
            $result['data'] = [];
        }
        return $result;
    }
    public function getCityId($city){
        $cityId = 0;
        switch ($city) {
            case "墨尔本":
                $cityId = 1;break;
            case "悉尼":
                $cityId = 2;break;
            case "黄金海岸":
                $cityId = 3;break;
            case "布里斯班":
                $cityId = 4;break;
            case "阿德莱德":
                $cityId = 5;break;
            case "堪培拉":
                $cityId = 6;break;
            case "珀斯":
                $cityId = 7;break;
            case "达尔文":
                $cityId = 8;break;
            case "霍巴特":
                $cityId = 10;break;
            case "卧龙岗":
                $cityId = 12;break;
            case "中央海岸":
                $cityId = 13;break;
            case "吉朗":
                $cityId = 14;break;
            case "巴拉瑞特":
                $cityId = 15;break;
            default :   // 其他
                $cityId = 11;
        }
        return $cityId;
    }
}
