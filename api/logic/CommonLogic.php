<?php
namespace api\logic;

use api\dao\BookRecommendDao;
use api\dao\ComicRecommendDao;
use api\dao\CommonDao;
use api\models\Domain;
use common\helpers\Tool;
use common\models\ProjectType;
use yii\helpers\ArrayHelper;

/**
 * 公共逻辑类
 * Class CommonLogic
 * @package api\logic
 */
class CommonLogic
{
    public function getMarketChannel($key)
    {
        $commonDao = new CommonDao();
        $data = $commonDao->marketChannelId();
        
        return ArrayHelper::getValue($data, $key, 0);
    }


    /**
     * 获取APP信息
     * @param $appId
     * @return mixed
     */
    public function getAppsInfo($appId) 
    {
        $commonDao = new CommonDao();
        return ArrayHelper::getValue($commonDao->allAppsInfo(), $appId, []);
    }

    /**
     * 根据类型获取域名
     * @param $type
     * @return array|mixed
     */
    public function getDomain($type = Domain::TYPE_PAGE)
    {
        $commonDao = new CommonDao();
        if ($type == Domain::TYPE_PAGE) { // 网页域名随机一个弹出出去
            $domain = $commonDao->domain($type);
            shuffle($domain);
            return array_pop($domain);
        }
        
        // api类型全返
        return $commonDao->domain($type);
    }
}
