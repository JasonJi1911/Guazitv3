<?php
namespace api\helpers;

use common\models\traits\FromChannelInterface;
use common\models\traits\FromChannelTrait;
use common\models\traits\ProductInterface;
use common\models\traits\ProductTrait;
use common\models\traits\SourceInterface;
use common\models\traits\SourceTrait;
use Yii;

class Common implements ProductInterface, FromChannelInterface, SourceInterface
{
    use SourceTrait;
    use ProductTrait;
    use FromChannelTrait;

    const AREA_CHINA = 1;
    const AREA_AUSTRALIA = 2;
    const AREA_CANADA = 3;
    const AREA_NEW_ZEALAND = 4;
    const AREA_OTHER = 5;

    // osType
    const OS_IOS     = 1;
    const OS_ANDROID = 2;
    const OS_TV = 3;
    const OS_OTHER   = 0;

    //终端和产品线映射关系
    public static $fromChannelMap = [
        self::PRODUCT_UNKNOWN => self::FROM_CHANNEL_UNKNOWN,
        self::PRODUCT_APP => [
            self::OS_IOS     => self::FROM_CHANNEL_IOS,
            self::OS_ANDROID => self::FROM_CHANNEL_ANDROID,
            self::OS_OTHER   => self::FROM_CHANNEL_UNKNOWN,
            self::OS_TV => self::OS_TV,

        ],
    ];

    /**
     * 区域映射
     * @var array
     */
    public static $areaTexts = [
        self::AREA_CHINA => '中国大陆',
        self::AREA_AUSTRALIA => '澳大利亚',
        self::AREA_CANADA => '加拿大',
        self::AREA_NEW_ZEALAND => '新西兰',
        self::AREA_OTHER => '其他',
    ];

    /**
     * 来源映射
     * @var array
     */
    public static $sourceMap = [
        self::FROM_CHANNEL_PC      => self::SOURCE_PC,
        self::FROM_CHANNEL_ANDROID => self::SOURCE_ANDROID_APP,
        self::FROM_CHANNEL_IOS     => self::SOURCE_IOS_APP,
        self::FROM_CHANNEL_MP      => self::SOURCE_MP,
    ];

    public static function getSecretKey($product, $os_type)
    {
        // sign签名秘钥
        $secretKey = Yii::$app->params['sign_secret_key'];

        $signSecretKey = [
            self::PRODUCT_APP => [
                self::OS_IOS => [
                    'sign_key'   => $secretKey['product_app']['os_ios']['sign_key'],
                    'secret_key' => $secretKey['product_app']['os_ios']['secret_key'],
                ],
                self::OS_ANDROID => [
                    'sign_key'   => $secretKey['product_app']['os_android']['sign_key'],
                    'secret_key' => $secretKey['product_app']['os_android']['secret_key'],
                ],
                self::OS_TV => [
                    'sign_key'   => $secretKey['product_app']['os_android']['sign_key'],
                    'secret_key' => $secretKey['product_app']['os_android']['secret_key'],
                ],
            ],
            self::PRODUCT_MP => [
                self::OS_IOS => [
                    'sign_key'   => $secretKey['product_mp']['os_ios']['sign_key'],
                    'secret_key' => $secretKey['product_mp']['os_ios']['secret_key'],
                ],
                self::OS_ANDROID => [
                    'sign_key'   => $secretKey['product_mp']['os_android']['sign_key'],
                    'secret_key' => $secretKey['product_mp']['os_android']['secret_key'],
                ],
                self::OS_OTHER => [
                    'sign_key'   => $secretKey['product_mp']['os_other']['sign_key'],
                    'secret_key' => $secretKey['product_mp']['os_other']['secret_key'],
                ],
            ],
	    self::PRODUCT_PC => [
                self::OS_IOS => [
                    'sign_key'   => $secretKey['product_mp']['os_ios']['sign_key'],
                    'secret_key' => $secretKey['product_mp']['os_ios']['secret_key'],
                ],
                self::OS_ANDROID => [
                    'sign_key'   => $secretKey['product_mp']['os_android']['sign_key'],
                    'secret_key' => $secretKey['product_mp']['os_android']['secret_key'],
                ],
                self::OS_OTHER => [
                    'sign_key'   => $secretKey['product_mp']['os_other']['sign_key'],
                    'secret_key' => $secretKey['product_mp']['os_other']['secret_key'],
                ],
            ],
        ];
        return $signSecretKey[$product][$os_type];
    }

}


