<?php

namespace api\controllers;

use api\components\ParamsTrait;
use api\logic\AdvertLogic;
use api\logic\CommonLogic;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\helpers\Tool;
use api\helpers\Common;
use api\exceptions\InvalidParamException;
use api\exceptions\InvalidSignException;

/**
 * Base基类
 */
class BaseController extends Controller
{
    use ParamsTrait;

    /**
     * {@inheritdoc}
     */
    public $enableCsrfValidation = false;
    /**
     * @var string|array the configuration for creating the serializer that formats the response data.
     */
    public $serializer = 'api\data\Serializer';

    // 记录接口请求时长
    public $startTime;
    public $endTime;

    // 接口通用参数
    public $packageName = ''; //包名
    public $marketChannel = ''; //市场渠道
    public $marketId = 0; //市场渠道id

    public $reqJson     = ''; // 请求体,用于记录日志

    /**
     * @var string 请求的uri
     */
    public $apiUri;

    /**
     * @var array 必传参数
     */
    protected $mustParams = ['ver', 'time', 'osType', 'sign', 'product'];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => ['*' => ['POST']],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        //执行开始时间
        $this->startTime = microtime(true) * 1000;

        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($this->checkWhiteApi()) {
            return true;
        }

        $this->initBody();
        $this->checkParams();
        $this->checkSignature();

        //接口级缓存读取
         if (in_array($this->route, Yii::$app->params['cache_route'])) {
            //缓存key
            $key = $this->_getKey();
            $redis = new RedisStore();
            if ($result = $redis->get($key)) {
                Yii::$app->response->data = json_decode($result, true);
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        $data = Yii::createObject($this->serializer)->serialize($result);

        //计算结束时间，打印日志
        $this->endTime = microtime(true) * 1000;

        $intTimeUsed = $this->endTime - $this->startTime;

        Yii::warning("req cost: " . $intTimeUsed);

        //缓存指定接口 5分钟
        if (in_array($this->route, Yii::$app->params['cache_route'])) {
            //缓存key
            $key = $this->_getKey();
            $redis = new RedisStore();
            $redis->setex($key, json_encode($data), 120);
        }

        //写入redis缓存,用于统计
       /* if (API_STATISTICS_SWITCH) {  //开启了接口统计
            $url = Yii::$app->request->url; //请求接口
            $key = RedisKey::listApiRequest();
            $redis = new RedisStore();
            $list = [
                'url'       => $url,
                'body'      => strlen($this->reqJson) > 4096 ? '请求体大于可显示最大长度' : $this->reqJson,
                'cost'      => intval($intTimeUsed),
                'time'      => time()
            ];
            $redis->rPush($key, json_encode($list, JSON_UNESCAPED_UNICODE)); //右进数据
        }*/

        return $data;
    }

    /**
     * 初始化body参数
     */
    protected function initBody()
    {
        $request = Yii::$app->request;

        // 检查请求体
        if (!$request->rawBody) {
            throw new InvalidParamException('', '请求体不能为空');
        }

        // 把参数赋值到自生变量上
        $this->initRequest($request);

        $this->reqJson = $request->rawBody;
        Yii::warning("req: " . trim($this->reqJson));

        // 增加日活记录
        if ($this->token) {
            $redis = new RedisStore();
            $key = RedisKey::userStat(date('Ymd'));
            $redis->sadd($key, $this->token);
            $redis->expireAt($key, 127800); //设置过期时间
        }
    }


    /**
     * 仅检查参数是否为null, 必传参数不能为空
     * @param array $params
     * @throws InvalidParamException
     */
    protected function checkParams($params = [])
    {
        // // 校验osType值
        // if (!in_array($this->osType, $this->allowOs)) {
        //     throw new InvalidParamException('osType');
        // }

        // 检测必传参数,不能为空
        $params = array_merge($params, $this->mustParams);
        foreach ($params as $param) {
            $this->getParamOrFail($param);
        }
    }

    /**
     * 校验是否白名单api 白名单接口不需要验签
     * @return bool
     */
    protected function checkWhiteApi()
    {
        // 判断是否白名单接口
        $apiUri = Yii::$app->request->getUrl();
        $apiArr = explode('?', $apiUri);
        $this->apiUri = $apiArr[0];
        $apiWhiteList = Yii::$app->params['apiWhiteList'];

        if (in_array($this->apiUri, $apiWhiteList)) {
            return true;
        }

        return false;
    }

    /**
     * 检查请求数据签名
     * @return bool
     * @throws InvalidSignException
     */
    protected function checkSignature()
    {
        // // debug模式
         if (YII_ENV_DEV) {
             return true;
         }

        $params = Yii::$app->request->post();

        // sign本身不参与签名
        unset($params['sign']);
        
        $config = Common::getSecretKey($this->product, $this->osType);
        list($sign, $signStr) = Tool::getSign($config['sign_key'], $params, $config['secret_key']);
        //var_dump($config);exit;
        // 检验签名
        if ($sign != $this->sign) {
            //签名二次校验,对于字段进行encode
            list($sign_en, $signStr_en) = Tool::getSign($config['sign_key'], $params, $config['secret_key'], true);
            if ($sign_en == $this->sign) {
                return true;
            }

            Yii::warning('sign error,sign['.$sign.'] signStr[' . $signStr.']');
            if (YII_DEBUG) {
                throw new InvalidSignException(sprintf('sign: %s, passed sign: %s', $sign, $this->sign));
            } else {
                throw new InvalidSignException();
            }
            
        }
        return true;
    }


    /**
     * 获取全部请求参数
     *
     * @return array
     */
    protected function getParams()
    {
        return Yii::$app->request->post();
    }

    /**
     * 获取请求参数
     *
     * @param string $name         参数名
     * @param mixed  $defaultValue 默认值
     * @return array|mixed
     */
    protected function getParam($name = null, $defaultValue = null)
    {
        return Yii::$app->request->post($name, $defaultValue);
    }


    /**
     * 获取请求参数或抛出异常
     * @param string $name 参数名
     * @return array|mixed
     * @throws InvalidParamException
     */
    protected function getParamOrFail($name)
    {
        if (($value = $this->getParam($name)) !== null) {
            return $value;
        }

        throw new InvalidParamException($name);
    }

    private function _getKey()
    {
        $key = '';
        //通用参数
        $key .= $this->route; //路由
        $key .= $this->product; //产品线
        $key .= $this->ver; //版本号

        $params = Yii::$app->request->post(); //所有参数

        //清除掉通用参数
        unset(
//            $params['product'],
            $params['ver'],
            $params['marketChannel'],
            $params['sign'],
            $params['sysVer'],
            $params['token'],
            $params['osType'],
            $params['time'],
            $params['packageName'],
            $params['udid'],
            $params['fromChannel'],
            $params['source'],
            $params['marketId'],
            $params['appId']
        );
        foreach ($params as $name => $param) {
            $key .= $name . $param;
        }

        return RedisKey::getApiCacheKey(md5($key));
    }
    
}
