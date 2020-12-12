<?php
namespace api\components;

use api\exceptions\InvalidParamException;
use api\helpers\Common;
use api\logic\CommonLogic;
use Yii;

trait ParamsTrait
{
    // 接口通用参数
    public $udid        = ''; // 设备号
    public $ver         = ''; // 客户端版本 1.0
    public $sign        = ''; // 签名
    public $time        = ''; // 请求时间戳
    public $token       = ''; // 请求token
    public $osType      = 0;  // 系统类型 安卓、ios
    public $sysVer      = ''; // 系统版本 ios 12.0 安卓 8.0
    public $product     = 0;  // 产品类型
    public $fromChannel = 0;  // 终端 产品类型的细分型,ios、安卓、公众号、h5等等  客户端未传,系统自己算
    public $appId       = 1;  // 马甲包的appId
    public $source      = 0;

    public $packageName     = ''; // 包名
    public $marketChannel   = ''; // 市场渠道
    public $marketId        = 0; // 市场渠道id

    /**
     * 格式化request参数
     * @param $request
     */
    protected function initRequest($request)
    {
        // 通用参数初始化
        $this->udid          = $request->post('udid') ? $request->post('udid') : '';
        $this->ver           = $request->post('ver');
        $this->sign          = strtolower($request->post('sign'));
        $this->token         = $request->post('token');
        $this->time          = $request->post('time');
        $this->osType        = intval($request->post('osType'));
        $this->sysVer        = $request->post('sysVer') ? $request->post('sysVer') : '';
        $this->product       = $request->post('product');
        $this->fromChannel   = $this->getFromChannel();
        $this->appId         = $request->post('appId') ? $request->post('appId') : 1;
        $this->packageName   = $request->post('packageName');
        $this->marketChannel = $request->post('marketChannel');
        $this->marketId      = $this->getMarketId();
        $this->source        = $this->getSource();
    }

    /**
     * 获取来源 iOS Android pc等
     * @return int
     */
    protected function getFromChannel() {
        //app产品线 区分 Android和iOS端
        if ($this->product == Common::PRODUCT_APP){
            $from =  Common::$fromChannelMap[Common::PRODUCT_APP][$this->osType];
        } else {
            $from = Yii::$app->request->post('from_channel'); // 从参数中获取
        }

        return intval($from);
    }

    /**
     * 获取市场渠道,小米、华为等
     * @return int
     */
    protected function getMarketId()
    {
        //根据渠道名获取渠道ID
        $commonLogic = new CommonLogic();
        return $commonLogic->getMarketChannel($this->marketChannel);
    }

    /**
     * @return mixed
     */
    protected function getSource() {
        //根据渠道名获取渠道ID
        if (isset(Common::$sourceMap[$this->fromChannel])) {
            return Common::$sourceMap[$this->fromChannel];
        }

        return 0;
    }
}
