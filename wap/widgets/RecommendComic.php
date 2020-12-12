<?php

namespace mp\widgets;


use api\models\ComicRecommend;
use api\models\RecommendBook;
use yii\base\Widget;

class RecommendComic extends Widget
{
    /**
     * @var array 推荐位信息
     */
    public $recommend;
    
    public $style;

    /**
     * 渲染
     */
    public function run()
    {
        $this->style = $this->recommend['style'];
        
        switch ($this->style) {
            case ComicRecommend::STYLE_VERTICAL:
                $page = 'vertical';
                break;
            case ComicRecommend::STYLE_HORIZONTAL_VERTICAL:
                $page = 'hori_vert';
                break;
            default:
                $page = 'horizontal';
        }
//        $page = 'horizontal';

        return $this->render("recommend-comic/{$page}.php", ['recommend' => $this->recommend]);
    }
}
