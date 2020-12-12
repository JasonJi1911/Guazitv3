<?php
namespace admin\models\permission;

use common\helpers\Icon;

class Permission extends \common\models\permission\Permission
{
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->orderBy(['display_order' => SORT_ASC]);
    }

    /**
     * 关联父权限
     */
    public function getParent()
    {
        return $this->hasOne(static::className(), ['id' => 'pid']);
    }

    /**
     * 关联祖父权限
     */
    public function getGrandParent()
    {
        return $this->hasOne(static::className(), ['id' => 'ppid']);
    }

    /**
     * 获取图标名称
     *
     * @return string
     */
    public function getIconText()
    {
        return Icon::simpleLines()[$this->icon] ?? '';
    }

    /**
     * 是否是一级权限
     *
     * @return boolean
     */
    public function getIsFirst()
    {
        return $this->pid == 0;
    }

    /**
     * 是否是二级权限
     *
     * @return boolean
     */
    public function getIsSecond()
    {
        return ($this->pid != 0) && ($this->ppid == 0);
    }

    /**
     * 是否是三级权限
     *
     * @return boolean
     */
    public function getIsThird()
    {
        return ($this->pid != 0) && ($this->ppid != 0);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'ppid', 'is_menu', 'display_order', 'icon', 'pnode'], 'integer'],
            [['name'], 'string', 'max' => 16],
            [['route'], 'string', 'max' => 64],
            [['params'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '权限ID',
            'pid' => '父ID',
            'ppid' => '上上级权限ID',
            'name' => '权限名称',
            'is_menu' => '是否是菜单项',
            'display_order' => '排序值',
            'route' => '路由',
            'params' => '参数',
            'icon' => '图标',
            'pnode' => '父节点',
        ];
    }
}
