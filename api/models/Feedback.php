<?php
namespace api\models;

use common\helpers\OssUrlHelper;

class Feedback extends \common\models\Feedback
{
    public function fields()
    {
        return [
            'content' => function(){
                return $this->content;
            },
            'images' => function() {
                if (!$this->images) {
                    return [];
                }
                
                $imgs = json_decode($this->images, true);
                $data = [];
                foreach ($imgs as $img) {
                    $data[] = OssUrlHelper::set($img)->toUrl();
                }
                return $data;
            },
            'reply' => function() {
                return $this->reply;
            },
            'created_at' => function() {
                return date('Y-m-d H:i:s', $this->created_at);
            }
        ];
    }
}
