<?php
namespace api\models\apps;

class Apps extends \common\models\apps\Apps
{
    const API_ICON_WIDTH    = 100;
    const API_ICON_HEIGHT   = 100;

    public function fields()
    {
        return [
            'app_id',
            'name',
            'package_name',
            'icon' => function() {
                return $this->icon->resize(self::API_ICON_WIDTH, self::API_ICON_HEIGHT)->toUrl();
            },
            'share_link',
            'description'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(['status' => self::STATUS_ENABLED]);
    }
}
