<?php
namespace common\models\traits;

/**
 * 支付渠道接口
 */
interface PayChannelInterface
{
    // 支付渠道
    const PAY_CHANNEL_APPLEPAY  = 1;
    const PAY_CHANNEL_ALIPAY    = 2;
    const PAY_CHANNEL_WXPAY     = 3;
    const PAY_CHANNEL_UNKNOWN   = 4;
    const PAY_CHANNEL_GOOGLE    = 5;
    const PAY_CHANNEL_THIRD     = 6;
    const PAT_SIGN              = 7;
    const PAY_SYSTEM_GIVE       = 8;

    /**
     * 获取支付渠道名称
     * @return string
     */
    public function getPayChannelName();
}
