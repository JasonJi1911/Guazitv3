<?php

namespace yii\helpers;

use Yii;
use yii\helpers\Url;
use yii\web\Request;

class Html extends BaseHtml
{
    public static function activeLabel($model, $attribute, $options = [])
    {
        $for = ArrayHelper::remove($options, 'for', static::getInputId($model, $attribute));
        $attribute = static::getAttributeName($attribute);

        $labelContent = static::encode($model->getAttributeLabel($attribute));
        if ($model->isAttributeRequired($attribute)) {
            $labelContent .= static::tag('span', ' * ', ['class' => 'required', 'aria-required' => 'true']);
        }
        $label = ArrayHelper::remove($options, 'label', $labelContent);

        return static::label($label, $for, $options);
    }

    public static function createButton($text, $url = ['create'], $options = [])
    {
        if (empty($options)) {
            static::addCssClass($options, 'btn green');
        }

        $options['check-permission'] = true;

        return static::a($text, $url, $options);
    }

    public static function actionButton($text, $url, $icon, $color, $options = [])
    {
        $icon = static::tag('i', ' ' . $text, ['class' => 'fa fa-' . $icon]);

        static::addCssClass($options, 'btn btn-outline btn-circle btn-xs ' . $color);
        if (!isset($options['title'])) {
            $options['title'] = $text;
        }
        $options['check-permission'] = true;

        return static::a($icon, $url, $options);
    }

    public static function updateActionButton($url)
    {
        return static::actionButton('更新', $url, 'edit', 'purple');
    }

    public static function deleteActionButton($url, $confirm = null)
    {
        if (!$confirm) {
            $confirm = '您确定要删除此项吗？';
        }

        return static::actionButton('删除', $url, 'trash-o', 'dark', ['data-confirm' => $confirm, 'data-method' => 'delete']);
    }

    public static function a($text, $url = null, $options = [])
    {
        if (!isset($options['check-permission'])) {
            return parent::a($text, $url, $options);
        }

        $checkedUrl = is_string($options['check-permission']) ? $options['check-permission'] : $url;
        unset($options['check-permission']);

        if (is_array($checkedUrl)) {
            $route  = Url::normalizeRoute($checkedUrl[0]);
            $params = [];
        } else {
            $request = new Request;
            $request->pathInfo = $checkedUrl;
            list($route, $params) = Yii::$app->getUrlManager()->parseRequest($request);
        }
        
        if (Yii::$app->user->identity->role->can($route, $params)) {
            return parent::a($text, $url, $options);
        }
    }

    /**
     * 日期范围选择器
     * @return string
     */
    public static function dateRangePicker($name1, $name2, $value1, $value2, array $options = [])
    {
        static::addCssClass($options, 'daterange-picker');

        if (!$value1 && !$value2) {
            $value = '';
        } elseif ($value1 && !$value2) {
            $value = "{$value1} 到 {$value1}";
        } elseif (!$value1 && $value2) {
            $value = "{$value2} 到 {$value2}";
        } else {
            $value = "{$value1} 到 {$value2}";
        }

        $html  = static::textInput(null, $value, ['class' => 'form-control']);
        $html .= static::hiddenInput($name1, $value1);
        $html .= static::hiddenInput($name2, $value2);

        return Html::tag('div', $html, $options);
    }

    /**
     * 模型日期范围选择器
     * @return string
     */
    public static function activeDateRangePicker($model, $attribute1, $attribute2, array $options = [])
    {
        return static::dateRangePicker($attribute1, $attribute2, $model->$attribute1, $model->$attribute2, $options);
    }
}
