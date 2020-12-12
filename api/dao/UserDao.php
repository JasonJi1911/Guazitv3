<?php
namespace api\dao;

use api\data\ActiveDataProvider;
use api\models\Expend;
use api\models\user\TaskInfo;
use api\models\user\User;
use api\models\user\UserAssets;
use api\models\user\UserCoupon;
use api\models\user\UserAuthApp;
use api\models\user\UserVip;
use api\models\video\Video;
use api\models\video\VideoFavorite;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use common\models\SettingRules;
use yii\helpers\ArrayHelper;
use Yii;

class UserDao extends BaseDao
{
    /**
     * 获取用户信息
     * @return array|bool
     */
    public function userInfo()
    {
        $uid = Yii::$app->user->id;
        if (!$uid) {
            return [];
        }
        return Yii::$app->user->toArray();
    }
    
    /**
     * 获取用户收藏记录,返回只有影片id的数组
     * @param $uid
     * @return mixed
     */
    public function favoriteId($uid)
    {
        if (!$uid) { // 非法的用户uid
            return [];
        }
        
        $key = RedisKey::videoUserFavorite($uid);
        $redis = new RedisStore();
        $data = $redis->get($key);
        if ($data) {
            return json_decode($data, true);
        }

        //查询用户的收藏记录,只查id
        $data = VideoFavorite::find()
            ->select('video_id')
            ->where(['uid' => $uid, 'status' => VideoFavorite::STATUS_YES])
            ->column();
        $redis->setEx($key, json_encode($data));
        return $data;
    }

    /**
     * 批量获取用户信息
     * @param array $uid
     * @return array
     */
    public function batchGetUser(array $uid)
    {
        $userDataProvider = new ActiveDataProvider([
            'query' => User::find()
                ->where(['uid' => $uid])
        ]);
        $users = $userDataProvider->toArray();
        $data = ArrayHelper::index($users, 'uid'); //重建索引

        return $data;
    }

    /**
     * 会员信息
     */
    public function vipInfo()
    {
        $uid = Yii::$app->user->id;
        if (!$uid) {
            return [];
        }

        $userVip = UserVip::findOne($uid);
        if (!$userVip) {
            return [];
        }

        return $userVip->toArray();
    }

    /**
     * 绑定列表
     */
    public function bindList()
    {
        $uid = Yii::$app->user->id;
        if (!$uid) {
            return [];
        }

        // 微信和qq绑定情况
        $wechatBind = UserAuthApp::findOne(['uid' => $uid, 'type' => UserAuthApp::TYPE_WECHAT]);
        $qqBind = UserAuthApp::findOne(['uid' => $uid, 'type' => UserAuthApp::TYPE_QQ]);

        return [
            [
                'label' => '手机号', //绑定类型
                'action' => 'bindPhone', //绑定操作
                'status' => Yii::$app->user->mobile ? User::BIND_STATUS_YES : User::BIND_STATUS_NO, //绑定状态 0-未绑定 1-已绑定
                'display' => Yii::$app->user->mobile ? substr_replace(Yii::$app->user->mobile, '****', 3, 4) : '未绑定'
            ],
            [
                'label' => '微信', //绑定类型
                'action' => 'bindWechat', //绑定操作
                'status' => $wechatBind ? User::BIND_STATUS_YES : User::BIND_STATUS_NO,
                'display' => $wechatBind ? $wechatBind->name : '未绑定'
            ],
            [
                'label' => 'QQ', //绑定类型
                'action' => 'bindQq', //绑定操作
                'status' => $qqBind ? User::BIND_STATUS_YES : User::BIND_STATUS_NO,
                'display' => $qqBind ? $qqBind->name : '未绑定'
            ],
        ];
    }


    /**
     * 使用观影券
     */
    public function userCoupon()
    {
        $uid = Yii::$app->user->id;
        $videoName = Video::tableName();
        $userName  = UserCoupon::tableName();

        //连表查询video_id
        $dataProvider = new ActiveDataProvider([
            'query' => UserCoupon::find()
                ->leftJoin($videoName, $userName.'.video_id='.$videoName.'.id')
                ->where(['uid' => $uid])
                ->andWhere([$videoName.'.status' => Video::STATUS_ENABLED])

        ]);

        $data = $dataProvider->setPagination()->toArray();
        $videoId = array_column($data['list'], 'video_id');
        // 根据video id批量视频信息
        $video = new VideoDao();
        $videoList = $video->batchGetVideo($videoId,['video_id', 'video_name', 'cover', 'horizontal_cover'], true);


        foreach ($data['list'] as &$v) {
            $v['video_name'] = $videoList[$v['video_id']]['video_name'];
            $v['cover']      = $videoList[$v['video_id']]['horizontal_cover'];
            $v['expire_at']  = '有效期至：' . $v['expire_time'];
            $v['cost']       = $v['num'];
            unset($v['uid'],$v['recv_time'],$v['use_time'],$v['expire_time'],$v['type'],$v['num']); // 去掉多余信息
        }

        //观影券使用
        $total = UserAssets::findOne(['uid' => $uid]);
        $num = $total['total_coupon'] - $total['coupon_remain'];

        $data['unused_num'] = intval($total['coupon_remain']);
        $data['used_num']   = $num;

        return $data;
    }

    /**
     * 我的观影券
     */
    public function userList()
    {
        $uid = Yii::$app->user->id;
        // 查询用券的video_id
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()
                ->where(['play_limit' => Video::PLAY_LIMIT_COUPON])
        ]);
        $data = $dataProvider->setPagination()->toArray(['video_name', 'video_id', 'flag', 'cover', 'horizontal_cover', 'tag']);

        //观影券使用
        $total = UserAssets::getUserAssets(['uid' => $uid]);
        $num = $total['total_coupon'] - $total['coupon_remain'];
        $desc = Yii::$app->setting->get('rules.coupon_intro');

        $data['unused_num'] = $total['coupon_remain'];
        $data['used_num']   = $num;
        $data['desc']       = '全场付费内容用券随便看';
        $data['intro']      = $desc;

        return $data;
    }
}
