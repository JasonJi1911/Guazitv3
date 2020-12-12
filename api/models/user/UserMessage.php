<?php
namespace api\models\user;

use common\helpers\Tool;
use yii\helpers\ArrayHelper;

class UserMessage extends \common\models\user\UserMessage
{
    public function fields()
    {
        return [
//            'type' => function () {
//                return ArrayHelper::getValue(\common\models\user\UserMessage::$messageMap, 'type');
//            },
            'type',
            'content',
            'created_at' => function($model) {
                return date('m-d', $model->created_at);
            }
        ];
    }
}