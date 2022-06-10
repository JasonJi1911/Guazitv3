<?php
namespace appapi\models;

class Answer extends \common\models\Answer
{
    public function fields()
    {
        return [
            'title',
            'type',
            'answer'
        ];
    }
}
