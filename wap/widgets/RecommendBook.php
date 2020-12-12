<?php

namespace mp\widgets;

use common\models\Recommend;
use Yii;
use yii\base\Widget;

/**
 * 推荐位作品部件
 *
 * @since 1.0
 */
class RecommendBook extends Widget
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
            case Recommend::STYLE_VERTICAL_THREE:
                $page = 'vertical_three';
                break;
            case Recommend::STYLE_VERTICAL_SIX:
                $page = 'vertical_six';
                break;
            case Recommend::STYLE_HORIZONTAL_ONE_VERTICAL_THREE:
                $page = 'horizontal_one_vertical_three';
                break;
            case Recommend::STYLE_VERTICAL_THREE_HORIZONTAL_THREE:
                $page = 'vertical_three_horizontal_three';
                break;
            default:
                $page = 'vertical_three';
        }
//        $page = 'horizontal_one_vertical_three';
        
        return $this->render("recommend-book/{$page}.php", ['recommend' => $this->recommend]);
    }
}
