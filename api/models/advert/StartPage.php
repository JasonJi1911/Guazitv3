<?php
namespace api\models\advert;

class StartPage extends \common\models\advert\StartPage
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'skip_type' => function () {
                return $this->skip_type;
            },
            'image' => function () {
                return $this->image->resize(1242, 2208)->toUrl();
            },
            'title' => function () {
                return $this->title;
            },
            'content' => function () {
                return $this->content;
            },
            'ad_key' => function () {
                return $this->ad_key;
            },
            'ad_android_key' => function () {
                return $this->ad_android_key;
            },
        ];
    }
}
