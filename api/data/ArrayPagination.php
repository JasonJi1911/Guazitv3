<?php
namespace api\data;

use Yii;

/**
 * 数组手动分页
 * Class ArrayPagination
 * @package api\data
 */
class ArrayPagination
{
    public static function setPagination($data)
    {
        $page     = Yii::$app->request->post('page_num', 1);
        $pageSize = Yii::$app->request->post('page_size', 10);

        $offSet = ($page - 1) * $pageSize;

        return [
            'total_page'   => ceil(count($data) / $pageSize),
            'current_page' => $page,
            'page_size'    => $pageSize,
            'total_count'  => count($data),
            'list'         => array_slice($data, $offSet, $pageSize),
        ];
    }
}
