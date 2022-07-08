<?php
/**
 * Created by PhpStorm.
 * Date: 19/12/9
 * Time: 15:01
 */

namespace api\logic;

use api\dao\UserDao;
use api\exceptions\ApiException;
use api\helpers\Aop;
use api\helpers\ErrorCode;
use api\models\pay\AppleTrade;
use api\models\pay\Goods;
use api\models\pay\Order;
use api\dao\PayChannelDao;
use api\dao\PayDao;
use api\models\pay\PayChannel;
use api\helpers\Common;
use api\models\pay\PayErrorLog;
use api\models\user\UserAssets;
use api\models\user\UserCoupon;
use api\services\PayService;
use common\helpers\Tool;
use api\helpers\Wxpay;
use common\models\setting\SettingSystem;
use Yii;
use yii\db\Exception;

class PayLogic
{
    /**
     * 会员中心
     */
    public function vipCenter()
    {
        $userLogic = new UserLogic();
        $commonLogic = new CommonLogic();
        return [
            'user_info'  => $userLogic->vipInfo(),
            'third_on'   => Yii::$app->setting->get('system.third_pay') == SettingSystem::THIRD_PAY_ON ? 1 : 0, //第三方支付开关
            'goods_list' => $this->goodsList(Goods::TYPE_VIP),
            'icon'       => [
                [
                    'title' => '广告特权',
                    'img'  => API_HOST_PATH . '/img/08.png'
                ],
                [
                    'title' => '院线新片',
                    'img'  => API_HOST_PATH . '/img/01.png'
                ],
                [
                    'title' => '热剧抢先看',
                    'img'  => API_HOST_PATH . '/img/02.png'
                ],
                [
                    'title' => '海量大片',
                    'img'  => API_HOST_PATH . '/img/03.png'
                ],
                [
                    'title' => '会员折扣',
                    'img'  => API_HOST_PATH . '/img/06.png'
                ],
                [
                    'title' => '尊贵标识',
                    'img'  => API_HOST_PATH . '/img/04.png'
                ],
                [
                    'title' => '边下边播',
                    'img'  => API_HOST_PATH . '/img/07.png'
                ],
                [
                    'title' => '会员福利',
                    'img'  => API_HOST_PATH . '/img/05.png'
                ]

            ],
            'server_protocol' => $commonLogic->getDomain() . '/site/membership-service?' . http_build_query(['id' => Yii::$app->common->appId])
        ];
    }

    /**
     * 卡券中心
     */
    public function couponCenter()
    {
        $userLogic = new UserLogic();

        return [
            'user_info'   => $userLogic->vipInfo(),
            'third_on' => Yii::$app->setting->get('system.third_pay') == SettingSystem::THIRD_PAY_ON ? 1 : 0, //第三方支付开关
            'coupon_desc' => [
                'desc'  => '电影电视等付费视频可以免费观看，查看'. Yii::$app->setting->get('system.currency_coupon') .'说明',
                'intro' => Yii::$app->setting->get('rules.coupon_intro')
            ],
            'goods_list' => $this->goodsList(Goods::TYPE_COUPON)
        ];
    }


    /**
     * 获取商品列表
     * @param $type
     * @return array
     */
    public function goodsList($type)
    {
        $uid = Yii::$app->user->id;

        $payDao = new PayDao();
        $goodsList = $payDao->goodsList($type);

        $appleProduct = false;
        if (Yii::$app->common->osType == Common::OS_IOS && Yii::$app->common->product == Common::PRODUCT_APP) {
            $appleProduct = true;
        }

        $data = [];
        // 过滤不符合要求的商品
        foreach ($goodsList as $goods) {
            // 取苹果产品 过滤苹果id未填写的商品,非苹果产品过滤有apple id
            if (($appleProduct && empty($goods['apple_id'])) || ((!$appleProduct && $goods['apple_id']))) {
                continue;
            }
            
            if ($goods['limit_num'] > 0 && $uid) { // 根据限购次数过滤商品
                $orderCount = Order::find()
                    ->andWhere(['uid' => $uid, 'goods_id' => $goods['goods_id'], 'status' => Order::STATUS_SUCCESS])
                    ->count();
                if ($orderCount >= $goods['limit_num']) {
                    continue;
                }
            }
            // 格式数据
            if ($type == Goods::TYPE_COUPON) { // 卡券补充一下说明
                $goods['desc'] = $goods['desc'];
            }
            $goods['pal_channel']    = $this->_getPayChannel($goods['current_price']);

            $goods['current_price']  = MONEY_UNIT . ($goods['current_price'] / 100);
            $goods['original_price'] = MONEY_UNIT . ($goods['original_price'] / 100);

            $data[] = $goods;
        }

        return $data;
    }

    /**
     * 根据金额取可用支付渠道
     * @param $price
     * @return array
     */
    private function _getPayChannel($price) {

        //查询所有开启的支付通道
        $payChannelDao = new PayChannelDao();

        $channelList = $payChannelDao->getPayChannel($price);

        if (empty($channelList)) {
            return [];
        }

        $data = [];

        foreach ($channelList as $k => &$channel) {
            if ($channel['status'] == PayChannel::STATUS_DISABLED) {
                unset($channelList[$k]);
                continue;
            }

            //iOS端 屏蔽掉支付宝和微信的原生支付
            if (Yii::$app->common->osType == Common::OS_IOS && $channel['pay_type'] == PayChannel::CHANNEL_TYPE_NATIVE) {
                unset($channelList[$k]);
                continue;
            }

            if ($channel['gateway']) {
                $channel['gateway'] = $channel['gateway'].'?pal_id='.$channel['channel_id'];
            }

            unset($channel['min_price']);
            unset($channel['max_price']);
            unset($channel['status']);

            $data[] = $channel;
        }

        return $data;
    }

    /**
     * 支付宝下单
     * @param $goodsId
     * @return array
     */
    public function alipay($goodsId)
    {
        // 查询商品信息
        $payDao = new PayDao();
        $goodsInfo = $payDao->goodsInfo($goodsId);
        $objPayService = new PayService();

        //购买商品下单
        list($tradeNo, $tradeBody) = $objPayService->createOrder($goodsInfo, Order::PAY_CHANNEL_ALIPAY, Yii::$app->user, $this->fromChannel);

        //将商品ID透传过去
        $passback = ['goods_id' => $goodsId];

        $strPassback = addslashes(json_encode($passback));

        $price = $goodsInfo['current_price'] ? $goodsInfo['current_price']/100 : 1;

        $aop = new Aop();
        $orderStr = $aop->getOrderString($tradeNo, $price, $tradeBody, $tradeBody, $strPassback);

        $data = [];
        $data['order_str'] = $orderStr;

        return $data;
    }

    /**
     * 支付宝回调
     * @param $input
     * @return string
     * @throws \api\exceptions\ApiException
     */
    public function alipayNotify($input) {
        $aop = new Aop();
        $flag = $aop->checkNotify($input);

        $time = time();
        $date = date('Ymd', $time);

        //内部订单号
        $tradeNo = $input['out_trade_no'];
        //外部订单号
        $outTradeNo = $input['trade_no'];

        $arrErrData = [
            'date'          => $date,
            'trade_no'      => $tradeNo,
            'out_trade_no'  => $outTradeNo,
            'created_at'    => $time,
        ];

        $echoResult = 'failure';

        do {
            if (!$flag) {
                //验签失败
                $arrErrData['type'] = PayErrorLog::TYPE_VERIFY_FAILED;
                $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_VERIFY_FAILED];

                Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} alipay - verify failed. req_json: " . json_encode($input),
                    'ALIPAY_NOTIFY_FAILED');
                break;
            }

            //根据透传的商品id信息判断回调处理操作
            $arrPassbackParams = json_decode(trim($input['passback_params'], '.'), true);

            $payDao = new PayDao();
            $arrGoodsInfo = $payDao->goodsInfo($arrPassbackParams['goods_id']);
            if (!$arrGoodsInfo) { // 商品无效
                throw new ApiException(ErrorCode::EC_GOODS_INVALID);
            }

            // 没有找到对应商品信息时默认为充值 两个表结构关键字段需一致
            $objTradeInfo = Order::findOne(['trade_no' => $tradeNo]);

            if (!$objTradeInfo) {
                //验签失败
                $arrErrData['type'] = PayErrorLog::TYPE_ORDER_NOT_EXIST;
                $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_ORDER_NOT_EXIST];

                Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} alipay - order not find. req_json: " . json_encode($input),
                    'ALIPAY_NOTIFY_FAILED');
                break;
            }

            $arrErrData['uid'] = $objTradeInfo->uid;

            if (($objTradeInfo->total_fee != $input['total_amount'] * 100) || (Aop::getAppId() != $input['app_id'])) {
                //验证订单信息
                $arrErrData['type'] = PayErrorLog::TYPE_ORDER_INCORRECT;
                $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_ORDER_INCORRECT];

                Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} alipay - order info incorrect. req_json: " . json_encode($input),
                    'ALIPAY_NOTIFY_FAILED');
                break;
            }

            // 查询订单是否已经处理
            if ($objTradeInfo->status == Order::STATUS_SUCCESS) {
                $echoResult = 'success';
                break;
            }

            // 未支付时不处理直接返回
            if ($input['trade_status'] != 'TRADE_SUCCESS' && $input['trade_status'] != 'TRADE_FINISHED') {
                $echoResult = 'success';
                break;
            }
            // 开始处理订单信息
            $payService = new PayService();
            if ($arrGoodsInfo['type'] == Goods::TYPE_VIP) {
                $result = $payService->confirmBuyVip($objTradeInfo, $outTradeNo);
            } else {
                $result = $payService->confirmPayResult($objTradeInfo, $outTradeNo);
            }

            if (!$result) {
                $arrErrData['type'] = PayErrorLog::TYPE_CONFIRM_TRADE_FAILED;
                $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_CONFIRM_TRADE_FAILED];

                Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} alipay - order confirm failed. req_json: " . json_encode($input),
                    'ALIPAY_NOTIFY_FAILED');
                break;
            }
            $echoResult = 'success';
            break;

        } while (0);

        if (isset($arrErrData)) {
            $payService = new PayService();
            $payService->recordPayError($arrErrData);
        }
        return $echoResult;
    }

    /**
     * 微信支付
     * @param $goodsId
     * @return array
     * @throws \api\exceptions\ApiException
     */
    public function wxpay($goodsId)
    {
        // 查询商品信息
        $payDao = new PayDao();
        $arrGoodsInfo = $payDao->goodsInfo($goodsId);
        if (empty($arrGoodsInfo)) {
            throw new ApiException(ErrorCode::EC_GOODS_INVALID);
        }

        $ip = Tool::getIp();

        $objPayService = new PayService();
        //购买商品下单
        list($tradeNo, $tradeBody) = $objPayService->createOrder($arrGoodsInfo, Order::PAY_CHANNEL_WXPAY, Yii::$app->user, Yii::$app->common->fromChannel);

        $wxPay = new Wxpay();

        //将商品id透传过去
        $attach = ['goods_id' => $goodsId];
        $attachStr = json_encode($attach);
        $arrOrderData = $wxPay->createOrder($tradeNo, $arrGoodsInfo['current_price'], $tradeBody, $ip, $attachStr);

        if (empty($arrOrderData)) {
            throw new ApiException(ErrorCode::EC_DB_ERROR);
        }

        $data = [
            'appid'     => $arrOrderData['appid'],
            'partnerid' => $arrOrderData['mch_id'],
            'prepayid'  => $arrOrderData['prepay_id'],
            'package'   => 'Sign=WXPay',
            'noncestr'  => Tool::getRandKey(),
            'timestamp' => time(),
        ];

        $paySign = $wxPay->getSign($data);

        $data['paySign'] = $paySign;
        //兼容旧版app支付
        $data['prepay_id'] = $arrOrderData['prepay_id'];

        return $data;
    }

    /**
     * 微信支付回调
     * @return array
     * @throws \api\exceptions\ApiException
     */
    public function wxpayNotify()
    {
        $arrNotifyData = Wxpay::post_xml_receive();
        
        $data = [
            'return_code' => 'FAIL',
            'return_msg' => '',
        ];
        if (empty($arrNotifyData)) {
            $data['return_msg'] = '解析数据失败';
            return $data;
        }
        //校验数据
        $wxPay = new Wxpay();

        $objPayService = new PayService();
        return $objPayService->wxpayNotify($wxPay, $arrNotifyData);
    }

    public function applepay($receipt)
    {
        if (strpos($receipt, '{')) {
            $receipt = base64_encode($receipt);
        }
        $isSandbox = false;
        $time = time();

        $payService = new PayService();

        //校验凭证
        $list = $payService->validateReceipt($receipt, $isSandbox);

        //未验证通过情况下直接返回错误
        if (empty($list)) {
            throw new ApiException(ErrorCode::EC_INVALID_RECEIPT);
        }
        //返回的效果
        $return = false;
        foreach ($list as $info) {
            //苹果商品id
            $product_id = $info["product_id"];
            //苹果交易号
            $original_transaction_id = $info['original_transaction_id'] ? $info['original_transaction_id'] : $info ['transaction_id'];

            // 根据苹果商品id获取对应的自有商品信息
            $goodsInfo = Goods::findOne(['apple_id' => $product_id]);
            if (empty($goodsInfo)) {
                Yii::warning("apple pay error - product invalid. req_json: " . $this->reqJson, 'SIGN_IN_FAILED');
//                throw new ApiException(ErrorCode::EC_GOODS_INVALID);
                continue;
            }
            $goodsInfo = $goodsInfo->toArray();
            /**
             * 查询苹果交易记录
             */
            $appleTrade = AppleTrade::findOne(['apple_trade_id' => $original_transaction_id]);

            //凭证已使用过的话 直接返回成功
            if ($appleTrade && $appleTrade->is_used == AppleTrade::IS_USED_YES) {
                continue;
            }

            try {
                //如果没有苹果记录,先将苹果订单信息写到库里
                if (empty($appleTrade)) {
                    $trade_no                   = Tool::makeOrderNo(Yii::$app->user->uid);
                    $appleTrade                 = new AppleTrade();
                    $appleTrade->uid            = Yii::$app->user->uid;
                    $appleTrade->trade_no       = $trade_no;
                    $appleTrade->product_id     = $product_id;
                    $appleTrade->apple_trade_id = $original_transaction_id;
                    $appleTrade->price          = $goodsInfo['current_price'];
                    $appleTrade->is_used        = AppleTrade::IS_USED_NO;
                    $appleTrade->updated_at     = $time;
                    $appleTrade->created_at     = $time;
                    $appleTrade->ip             = Tool::getIp();

                    if (!$appleTrade->save()) {
                        throw new \Exception(json_encode($appleTrade->errors, JSON_UNESCAPED_UNICODE));
                    }
                }

                // 根据商品类型判断是 购买卡券还是直接开通vip服务 处理逻辑不同
                if ($goodsInfo['type'] == Goods::TYPE_COUPON) {
                    // 购买卡券的逻辑处理
                    $result = $payService->confirmAppleTrade($appleTrade, $goodsInfo, Yii::$app->user, Yii::$app->common->fromChannel);
                } else {
                    $result = $payService->confirmAppleBuyVip($appleTrade, $goodsInfo, Yii::$app->user, Yii::$app->common->fromChannel);
                }

                if (!$result) {
                    throw new ApiException(ErrorCode::EC_PRODUCT_BUY_FAILED);
                }

                $return = $result;
            } catch (\Exception $e) {
                Yii::warning("uid:" . Yii::$app->user->uid . " apple pay - exception: " . $e->getMessage() . " req_json: " . $this->reqJson,
                    'APPLE_PAY_FAILED');
//                throw new ApiException(ErrorCode::EC_DB_ERROR);
            }
        }

        if (!$return) {
            throw new ApiException(ErrorCode::EC_DB_ERROR);
        }
        return [];
    }

    /**
     * @param $uid 用户
     * @param $num 数量
     * @param $videoId 视频
     * @return bool
     * @throws \api\exceptions\ApiException
     */
    public function consumeCoupon($uid, $num, $videoId)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // 判断剩余卡券是否足够
            $userAsset = UserAssets::getUserAssets($uid);
            if (!$userAsset || $userAsset->coupon_remain < $num) {
                throw new ApiException(ErrorCode::EC_COUPON_NOT_ENOUGH);
            }

            // 消耗卡券
            $userAsset->coupon_remain -= $num;
            $userAsset->save();
            // 写入消费记录
            $userCoupon              = new UserCoupon();
            $userCoupon->uid         = $uid;
            $userCoupon->num         = $num;
            $userCoupon->use_time    = time();
            $userCoupon->video_id    = $videoId;
            $userCoupon->expire_time = time() + 86400 * Yii::$app->setting->get('system.coupon_expire_time');
            $userCoupon->type        = UserCoupon::TYPE_USE;
            $userCoupon->save();
            // 提交事务
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return  false;
        }
    }

    /*
     * 彩虹易支付异步回调
     * @return string
     */
    public function newNotifyurl($param){
        if(empty($param)) {//判断POST来的数组是否为空
            return false;
        }
        else {
            $flag = false;
            //生成签名结果
            $isSign = $this->getSignVeryfy($param, $param["pay_sign"]);
            //验证
            //isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
            if($param['trade_status']=='TRADE_SUCCESS' && $isSign){
                $flag = true;
            }

            $time = time();
            $date = date('Ymd', $time);

            //内部订单号
            $tradeNo = $param['out_trade_no'];
            //外部订单号
            $outTradeNo = $param['trade_no'];

            $arrErrData = [
                'date'          => $date,
                'trade_no'      => $tradeNo,
                'out_trade_no'  => $outTradeNo,
                'created_at'    => $time,
            ];
            $echoResult = 'failure';

            $objTradeInfo = Order::findOne(['trade_no' => $tradeNo]);

            do{
                //签名验证失败
                if (!$flag) {
                    $arrErrData['type'] = PayErrorLog::TYPE_VERIFY_FAILED;
                    $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_VERIFY_FAILED];

                    Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} alipay - verify failed. req_json: " . json_encode($param),
                        'ALIPAY_NOTIFY_FAILED');
                    break;
                }
                //订单查询失败
                if (!$objTradeInfo) {
                    $arrErrData['type'] = \appapi\models\pay\PayErrorLog::TYPE_ORDER_NOT_EXIST;
                    $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_ORDER_NOT_EXIST];

                    Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} alipay - order not find. req_json: " . json_encode($param),
                        'ALIPAY_NOTIFY_FAILED');
                    break;
                }
                $arrErrData['uid'] = $objTradeInfo->uid;

                //验证订单信息
                if (($objTradeInfo->total_fee != intval($param['money'] * 100) ) || (PAY_PID != $param['pid'])) {
                    $arrErrData['type'] = PayErrorLog::TYPE_ORDER_INCORRECT;
                    $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_ORDER_INCORRECT];

                    Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} alipay - order info incorrect. req_json: " . json_encode($param),
                        'ALIPAY_NOTIFY_FAILED');
                    break;
                }

                // 查询订单是否已经处理
                if ($objTradeInfo->status == Order::STATUS_SUCCESS) {
                    $echoResult = 'success';
                    break;
                }

                // 未支付时不处理直接返回
                if ($param['trade_status'] != 'TRADE_SUCCESS') {
                    $echoResult = 'success';
                    break;
                }

                //开始处理订单信息,会员延期
                $payService = new PayService();
                $result = $payService->confirmBuyVip($objTradeInfo, $outTradeNo);

                if (!$result) {
                    $arrErrData['type'] = PayErrorLog::TYPE_CONFIRM_TRADE_FAILED;
                    $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_CONFIRM_TRADE_FAILED];

                    Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} alipay - order confirm failed. req_json: " . json_encode($param),
                        'ALIPAY_NOTIFY_FAILED');
                    break;
                }

                //系统消息通知
                $userdao = new UserDao();
                $mResult = $userdao->addMessagePC($arrErrData['uid'],$param['name']);

                if (!$mResult) {
                    $arrErrData['type'] = PayErrorLog::TYPE_SYSTEM_MESSAGE_FAILED;
                    $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_SYSTEM_MESSAGE_FAILED];

                    Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} alipay - user_message confirm failed. req_json: " . json_encode($param),
                        'ALIPAY_NOTIFY_FAILED');
                    break;
                }

                $echoResult = 'success';
                break;
            } while (0);

            if ($arrErrData['type'] > 0) {
                $payService = new PayService();
                $payService->recordPayError($arrErrData);
            }
            return $echoResult;
        }
    }
    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
    public function getSignVeryfy($para_temp, $sign) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = $this->paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = $this->argSort($para_filter);

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = $this->createLinkstring($para_sort);

        $isSgin = false;
        $isSgin = $this->md5Verify($prestr, $sign, PAY_KEY);

        return $isSgin;
    }
    /**
     * 除去数组中的空值和签名参数
     * @param $para 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     */
    public function paraFilter($para) {
        $para_filter = array();
        foreach ($para as $key=>$val) {
            if($key == "pay_sign" || $key == "sign_type" || $val == "")continue;
            else $para_filter[$key] = $para[$key];
        }
        return $para_filter;
    }
    /**
     * 对数组排序
     * @param $para 排序前的数组
     * return 排序后的数组
     */
    public function argSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }
    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    public function createLinkstring($para) {
        $arg  = "";
        foreach ($para as $key=>$val) {
            $arg.=$key."=".$val."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,-1);

        return $arg;
    }
    /**
     * 验证签名
     * @param $prestr 需要签名的字符串
     * @param $sign 签名结果
     * @param $key 私钥
     * return 签名结果
     */
    public function md5Verify($prestr, $sign, $key) {
        $prestr = $prestr . $key;
        $mysgin = md5($prestr);

        if($mysgin == $sign) {
            return true;
        }
        else {
            return false;
        }
    }


    /*
     * 下单
     */
    public function commitOrder($param)
    {
        // 查询商品信息
        $payDao = new PayDao();
        $goodsInfo = $payDao->goodsInfo($param['goodsId']);

        //购买商品下单
        $paydao = new PayDao();
        $param['from_channel'] = Yii::$app->common->fromChannel;
        $data = $paydao->createorder($goodsInfo,$param);

        return $data;
    }

    //商品套餐信息PC
    public function goodsListPC($type,$uid,$product)
    {
        $payDao = new PayDao();
        $goodsList = $payDao->goodsList($type,$product);

        $appleProduct = false;
        if (Yii::$app->common->osType == Common::OS_IOS && Yii::$app->common->product == Common::PRODUCT_APP) {
            $appleProduct = true;
        }

        $data = [];
        // 过滤不符合要求的商品
        foreach ($goodsList as $goods) {
            if ($goods['limit_num'] > 0 && $uid) { // 根据限购次数过滤商品
                $orderCount = Order::find()
                    ->andWhere(['uid' => $uid, 'goods_id' => $goods['goods_id'], 'status' => Order::STATUS_SUCCESS])
                    ->count();
                if ($orderCount >= $goods['limit_num']) {
                    continue;
                }
            }
            // 格式数据
            if ($type == Goods::TYPE_COUPON) { // 卡券补充一下说明
                $goods['desc'] = $goods['desc'];
            }
            $goods['pay_channel']    = $this->_getPayChannel($goods['current_price']);

            $goods['current_price']  = MONEY_UNIT . ($goods['current_price'] / 100);
            $goods['original_price'] = MONEY_UNIT . ($goods['original_price'] / 100);

            $data[] = $goods;
        }

        return $data;
    }


    // 计算签名
    public function getSign($param){
        ksort($param);
        reset($param);
        $signstr = '';

        foreach($param as $k => $v){
            if($k != "sign" && $k != "sign_type" && $v!=''){
                $signstr .= $k.'='.$v.'&';
            }
        }
        $signstr = substr($signstr,0,-1);
        $signstr .= $this->key;
        $sign = md5($signstr);
        return $sign;
    }
}
