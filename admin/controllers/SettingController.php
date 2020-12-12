<?php
namespace admin\controllers;

use admin\models\apps\AppsAlipay;
use admin\models\apps\AppsInfo;
use admin\models\apps\AppsMessage;
use admin\models\apps\AppsTencentInfo;
use admin\models\apps\AppsWechatPay;
use admin\models\setting\SettingAliyun;
use admin\models\setting\SettingOss;
use admin\models\setting\SettingRules;
use admin\models\setting\SettingServiceInfo;
use admin\models\setting\SettingSystem;
use admin\models\user\Sign;
use common\helpers\Tool;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use yii\data\ActiveDataProvider;

/**
 * setting基础配置类 save时已经清理了缓存, 如无特殊情况不需要在 model下清理缓存了
 * Class SettingController
 * @package admin\controllers
 */
class SettingController extends Controller
{

    private $groupKey = [
        'service-info'     => 'serviceInfo',
        'app-tencent-info' => 'tencentInfo',
        'wx-pay'           => 'wechatPay'
    ];

    /**
     * 权限验证
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (Yii::$app->user->id != 1) {  //不是总管理员
            echo  '此配置项只有总管理员可修改';
            return false;
        }
        return parent::beforeAction($action);
    }

    /**
     * @param $group
     * @param $type
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($group, $type)
    {
        if (Yii::$app->user->id != 1) {  //不是总管理员
            echo  '此配置项只有总管理员可修改';
            exit;
        }

        $modelClass = 'admin\models\setting\Setting' . ucfirst($group);
        if (!class_exists($modelClass)) { //判断类是否存在
            throw new NotFoundHttpException;
        }

        $model = call_user_func([$modelClass, 'findOne'], 1);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if (!$model->save()) { //保存失败打印日志
                Yii::warning($model->errors);
            } else {
                //写入缓存
                $key = RedisKey::getSettingKey($group);
                $redis = new RedisStore();
                $data = $model->toArray(); //转成数组
                unset($data['id']); //去掉多余的id
                $redis->set($key, json_encode($data, JSON_UNESCAPED_UNICODE));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'tags'  => Yii::$app->params['setting'][$type],
            'group' => $group
        ]);
    }

    /**
     * 基础设置
     * @return string
     */
    public function actionSystem()
    {
        $model = SettingSystem::findOne(1);
        $group = 'system';
        $this->_save($model, $group);
        return $this->render('update', [
            'model' => $model,
            'tags' => Yii::$app->params['setting']['system'],
            'group' => $group
        ]);
    }

    /**
     * 签到设置
     * @return string|\yii\web\Response
     */
    public function actionUpdateSign()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('SignGold');
            $day = $data['day'];
            $gold = $data['award'];
            foreach ($day as $k => $v) {
                Sign::updateAll(['score' => $gold[$k]], ['day' => $v]);
            }
            Yii::$app->session->setFlash('updated', 1);
            return $this->redirect('update-sign');
        }

        $model = Sign::find()->select('day, score')->all();

        return $this->render('update-sign', [
            'model' => $model,
            'tags' => YIi::$app->params['setting']['system']
        ]);
    }

    /**
     * 客服信息
     */
    public function actionServiceInfo()
    {
        $model = SettingServiceInfo::findOne(1);
        $group = 'service-info';
        $this->_save($model, $group);
        return $this->render('update', [
            'model' => $model,
            'tags'  => Yii::$app->params['setting']['system'],
            'group' => $group
        ]);
    }

    /**
     * 规则说明
     */
    public function actionRule()
    {
        $model = SettingRules::findOne(1);
        $group = 'rules';
        $this->_save($model, $group);
        return $this->render('update', [
            'model' => $model,
            'tags'  => Yii::$app->params['setting']['system'],
            'group' => $group
        ]);
    }

    /**
     * APP设置
     */
    public function actionAppInfo()
    {
        /**
         * @var $model AppsInfo
         */
        $model = AppsInfo::findOne(1);
        $group = 'info';
        $params = ['app_id' => $model->app_id];
        $this->_save($model, $group, $params);
        return $this->render('update', [
            'model' => $model,
            'tags'  => Yii::$app->params['setting']['app'],
            'group' => $group,
        ]);
    }

    /**
     * 微信支付设置
     */
    public function actionWxPay()
    {
        /**
         * @var $model AppsWechatPay
         */
        $model = AppsWechatPay::findOne(1);
        $group = 'wx-pay';
        $params = ['app_id' => $model->app_id];
        $this->_save($model, $group, $params);
        return $this->render('update', [
            'model' => $model,
            'tags'  => Yii::$app->params['setting']['app'],
            'group' => $group,
        ]);
    }

    /**
     * 支付宝
     */
    public function actionAlipay()
    {
        /**
         * @var $model AppsAlipay
         */
        $model = AppsAlipay::findOne(1);
        $group = 'alipay';
        $params = ['app_id' => $model->app_id];
        $this->_save($model, $group, $params);
        return $this->render('update', [
            'model' => $model,
            'tags'  => Yii::$app->params['setting']['app'],
            'group' => $group
        ]);
    }

    /**
     * 短信服务
     */
    public function actionMessage()
    {
        /**
         * @var $model AppsMessage
         */
        $model = AppsMessage::findOne(1);
        $group = 'message';
        $params = ['app_id' => $model->app_id];
        $this->_save($model, $group, $params);
        return $this->render('update', [
            'model' => $model,
            'tags'  => Yii::$app->params['setting']['app'],
            'group' => $group,
        ]);
    }

    /**
     * 微信信息设置表
     */
    public function actionAppTencentInfo()
    {
        /**
         * @var $model AppsTencentInfo
         */
        $model = AppsTencentInfo::findOne(1);
        $group = 'app-tencent-info';
        $params = ['app_id' => $model->app_id];
        $this->_save($model, $group, $params);
        return $this->render('update', [
            'model' => $model,
            'tags'  => Yii::$app->params['setting']['app'],
            'group' => $group,
        ]);
    }

    /**
     * 阿里云基础设置
     */
    public function actionAliyun()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SettingAliyun::find()
        ]);

        return $this->render('aliyun', [
            'dataProvider' => $dataProvider,
            'tags' => Yii::$app->params['setting']['app']]
        );
    }

    /**
     * 阿里云配置更新
     * @return string|\yii\web\Response
     */
    public function actionAliyunUpdate()
    {
        $id = Yii::$app->request->get('id');
        /**
         * @var $model SettingAliyun
         */
        $model = SettingAliyun::findOne($id);
        if (Yii::$app->request->isPost) {
            $this->_save($model, 'aliyun', ['type' => $model->type]);

            return $this->redirect('/setting/aliyun');
        }
        return $this->render('aliyun_form', ['model' => $model, 'tags' => Yii::$app->params['setting']['app']]);
    }

    /**
     * 阿里云oss配置
     * @return string
     */
    public function actionOss()
    {
        $model = SettingOss::findOne(1);
        $group = 'oss';
        $this->_save($model, $group);
        return $this->render('update', [
            'model' => $model,
            'tags'  => Yii::$app->params['setting']['app'],
            'group' => $group,
        ]);
    }

    /**
     * 更新model
     * @param object $model
     * @param string $group model组名称
     * @param array $params 扩展参数
     */
    private function _save($model, $group, $params=[])
    {
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->save();
            Yii::$app->session->setFlash('updated', 1);
            $key = !empty($this->groupKey[$group]) ? $this->groupKey[$group] : $group;
            //清理缓存
            Tool::clearCache(RedisKey::getSettingKey($key, $params));
        }
    }
}
