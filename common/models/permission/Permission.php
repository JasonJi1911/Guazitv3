<?php

namespace common\models\permission;

use Yii;

/**
 * This is the model class for table "{{%permission}}".
 *
 * @property int $id 权限ID
 * @property int $pid 父ID
 * @property int $ppid 上上级权限ID
 * @property string $name 权限名称
 * @property int $is_menu 是否是菜单项
 * @property int $display_order 排序值
 * @property string $route 路由
 * @property string $params 参数
 * @property int $icon 图标
 * @property int $pnode 图标
 */
class Permission extends \yii\db\ActiveRecord
{

    /**
     * @var array 是否是菜单
     */
    public static $isMenus = [1 => '是', 0 => '否'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%permission}}';
    }
}
