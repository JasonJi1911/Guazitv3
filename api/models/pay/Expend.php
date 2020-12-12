<?php
namespace api\models\pay;
use Yii;

class Expend extends \common\models\pay\Expend
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            // 消费描述
            'article' => function() {
                return $this->subject;
            },
            'score',
            'desc' => function() {
                $unit = Yii::$app->setting->get('system.currency_unit');
                if (in_array($this->type, [self::TYPE_REMOVE_AD])) { //消费
                    return '-'.$this->score . $unit;
                }
                return '+'.$this->score . $unit;
            },
            'type',
            'title' => function(){
                return self::$expendMap[$this->type];
            },
            'date' => function() {
                if (date('Y') == date('Y', $this->created_at)) {
                    return date('m月d日 H:i', $this->created_at);
                } else {
                    return date('Y年m月d日 H:i', $this->created_at);
                }
            },
            'detail_type' => function() {
                if (in_array($this->type, [self::TYPE_REMOVE_AD])) { //消费
                    return 2;
                } else {
                    return 1;
                }
            }
        ];
    }

}