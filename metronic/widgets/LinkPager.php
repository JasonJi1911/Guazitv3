<?php
namespace metronic\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * {pageButtons} {customPage} {pageSize}
     */
    public $template = '<div class="form-inline">{pageButtons}{customPage}
     <button class="btn go-page" id="go-page"  style="border: solid 1px #2bb8c4; padding: 0px; height: 34px; width: 50px; line-height: 34px; margin-top: -46px;color: #fff; background-color: #2bb8c4">确定</button>
</div>';

    /**
     * pageSize list
     */
    public $pageSizeList = [10, 20, 30, 50];

    /**
     *
     * Margin style for the  pageSize control
     */
    public $pageSizeMargin = [
        'margin-left' => '5px',
        'margin-right' => '5px',
    ];

    /**
     * customPage width
     */
    public $customPageWidth = 50;

    /**
     * Margin style for the  customPage control
     */
    public $customPageMargin = [
        'margin-left' => '5px',
        'margin-right' => '5px',
    ];

    /**
     * Jump
     */
    public $customPageBefore = '';
    /**
     * Page
     */
    public $customPageAfter = '';

    /**
     * pageSize style
     */
    public $pageSizeOptions = [
        'class' => 'form-control',
        'style' => [
            'display' => 'inline-block',
            'width' => 'auto',
            'margin-top' => '0px',
        ],
    ];

    /**
     * customPage style
     */
    public $customPageOptions = [
        'class' => 'form-control',
        'id'    => 'form-control',
        'style' => [
            'display' => 'inline-block',
            'margin-top' => '-46px',
        ],
    ];


    public function init()
    {
        parent::init();
        if ($this->pageSizeMargin) {
            Html::addCssStyle($this->pageSizeOptions, $this->pageSizeMargin);
        }
        if ($this->customPageWidth) {
            Html::addCssStyle($this->customPageOptions, 'width:' . $this->customPageWidth . 'px;');
        }
        if ($this->customPageMargin) {
            Html::addCssStyle($this->customPageOptions, $this->customPageMargin);
        }
    }


    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo $this->renderPageContent();
    }

    protected function renderPageContent()
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
            $name = $matches[1];
            if ('customPage' == $name) {
                return $this->renderCustomPage();
            } else if ('pageSize' == $name) {
                return $this->renderPageSize();
            } else if ('pageButtons' == $name) {
                return $this->renderPageButtons();
            }
            return '';
        }, $this->template);
    }


    protected function renderPageSize()
    {
        $pageSizeList = [];
        foreach ($this->pageSizeList as $value) {
            $pageSizeList[$value] = $value;
        }
        //$linkurl =  $this->pagination->createUrl($page);
        return Html::dropDownList($this->pagination->pageSizeParam, $this->pagination->getPageSize(), $pageSizeList, $this->pageSizeOptions);
    }

    protected function renderCustomPage()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }
        $page = 1;
        $params = Yii::$app->getRequest()->queryParams;
        if (isset($params[$this->pagination->pageParam])) {
            $page = intval($params[$this->pagination->pageParam]);
            if ($page < 1) {
                $page = 1;
            } else if ($page > $pageCount) {
                $page = $pageCount;
            }
        }
        return $this->customPageBefore . Html::textInput($this->pagination->pageParam, $page, $this->customPageOptions) . $this->customPageAfter;
    }
}
