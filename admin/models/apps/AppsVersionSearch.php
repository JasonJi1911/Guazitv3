<?php
namespace admin\models\apps;

use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;
use Yii;

class AppsVersionSearch extends AppsVersion implements SearchInterface
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
        $osType = Yii::$app->request->get('os_type', AppsVersion::OS_TYPE_IOS);
        $query->andWhere(['os_type' => $osType]);
        $query->orderBy('ver_sn desc');
        return $query;
    }
}