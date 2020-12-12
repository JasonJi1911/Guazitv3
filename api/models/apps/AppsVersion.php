<?php
namespace api\models\apps;

use Yii;

class AppsVersion extends \common\models\apps\AppsVersion
{
    public static function find()
    {
        return parent::find()->andWhere([self::tableName() . '.app_id' => Yii::$app->common->appId]);
    }
}
