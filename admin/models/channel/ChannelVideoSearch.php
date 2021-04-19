<?php
namespace admin\models\channel;

use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;
use Yii;

class ChannelVideoSearch extends ChannelVideo implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        $osType = Yii::$app->request->get('os_type', ChannelVideo::OS_TYPE_APP);
        $query->andWhere(['os_type' => $osType]);
        $query->orderBy('os_type desc');
        return $query;
    }
}