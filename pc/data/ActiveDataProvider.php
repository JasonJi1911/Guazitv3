<?php

namespace pc\data;

use Yii;
use yii\data\Pagination;

/**
 * ActiveDataProvider
 */
class ActiveDataProvider extends \yii\data\ActiveDataProvider
{
    const PAGE_SIZE = 20;
    /**
     * 设置偏移量
     */
    public function offset($offset)
    {
        $this->query->offset($offset);

        return $this;
    }

    /**
     * 设置limit
     */
    public function limit($limit)
    {
        $this->query->limit($limit);

        return $this;
    }

    /**
     * 取前几条
     */
    public function top($num)
    {
        $this->query->offset(0)->limit($num);

        return $this;
    }

    /**
     * 转成数组
     *
     * @param array $fields 字段列表
     * @return array
     */
    public function toArray(array $fields = [], array $expand = [])
    {
        $data = [];
        foreach ($this->getModels() as $model) {
            $data[] = $model->toArray($fields, $expand);
        }

        // 无分页
        if (!$this->_pagination) {
            return $data;
        }

        // 有分页
        return [
            'total_page'   => $this->_pagination->pageCount,
            'current_page' => $this->_pagination->page + 1,
            'page_size'    => $this->_pagination->pageSize,
            'total_count'  => $this->_pagination->totalCount,
            'list'         => $data,
        ];
    }
    
    public function rawData()
    {
        $data = [];
        foreach ($this->getModels() as $model) {
            $data[] = $model;
        }

        // 无分页
        if (!$this->_pagination) {
            return $data;
        }

        // 有分页
        return [
            'total_page'   => $this->_pagination->pageCount,
            'current_page' => $this->_pagination->page + 1,
            'page_size'    => $this->_pagination->pageSize,
            'total_count'  => $this->_pagination->totalCount,
            'list'         => $data,
        ];
    }

    private $_pagination;

    /**
     * @inheritdoc
     */
    public function getPagination()
    {
        if ($this->_pagination === null) {
            return false;
        }

        return $this->_pagination;
    }

    /**
     * @inheritdoc
     */
    public function setPagination($value = null)
    {
        if ($value === null) {
            $value = Yii::$app->request->get();
        }

        $this->_pagination = new Pagination([
            'params' => [
                'page'     => isset($value['page_num']) ? $value['page_num'] : 1,
                'per-page' => self::PAGE_SIZE,
            ],
        ]);

        return $this;
    }

    private $_fields = [];

    /**
     * 返回要获取的字段列表
     * @return array
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * 设置要获取的字段列表
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->_fields = $fields;

        return $this;
    }
}
