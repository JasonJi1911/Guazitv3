<?php
namespace api\services;

use Yii;
use yii\base\Arrayable;
use yii\base\Component;

/**
 * 服务基类
 */
abstract class Service extends Component implements Arrayable
{
    /**
     * @var array 参数配置
     */
    public $params;
    /**
     * @var object 模型实例
     */
    public $model;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        foreach ((array) $this->params as $key => $val) {
            if (is_int($key)) {
                $key = $val;
            }

            $this->$key = Yii::$app->request->post($val);
        }
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (\Exception $e) {
            return $this->model->$name;
        }
    }

    /**
     * 获取模型ID
     * @return int
     */
    public function getId()
    {
        if ($this->model) {
            return $this->model->getPrimaryKey();
        }
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return $this->model ? $this->model->fields() : [];
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return $this->model ? $this->model->extraFields() : [];
    }

    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return $this->model ? $this->model->toArray($fields, $expand, $recursive) : [];
    }
}
