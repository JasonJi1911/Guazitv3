<?php
namespace  admin\models\setting;

class SettingRules extends \common\models\setting\SettingRules
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coupon_intro', 'task_intro', 'score_intro'], 'string', 'max' => 4096],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coupon_intro' => \Yii::$app->setting->get('system.currency_coupon') . '说明',
            'task_intro' => '任务说明',
            'score_intro' => '积分说明',
        ];
    }
}