<?php

namespace admin\modules\manager\models;
use common\helpers\Icon;
class Permission extends \common\models\Permission
{
    /**
     * @var integer 优先级
     */
    public $priority;
    /**
     * @var integer 最大优先级
     */
    public $maxPriority;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'is_menu', 'priority'], 'required'],
            [['pid', 'ppid', 'is_menu', 'priority', 'icon'], 'filter', 'filter' => 'intval'],
            [['name', 'route', 'params'], 'trim'],

            ['priority', 'integer', 'min' => 1, 'max' => 99],
            ['name', 'string', 'max' => 15],
            ['route', 'string', 'max' => 50],
            ['params', 'string', 'max' => 60],
        ];
    }

    /**
     * 获取权限下拉列表选项
     *
     * @return array
     */
    public static function getPermissionOptions()
    {
        $permissions = [];
        foreach (static::findAll(['ppid' => 0]) as $permission) {
            $permissions[$permission->id] = ($permission->pid ? "---- " : "") . $permission->name;
        }

        return $permissions;
    }

    /**
     * 初始化优先级
     */
    public function initPriority()
    {
        $this->maxPriority = static::find()
                                    ->andWhere(['pid' => intval($this->pid)])
                                    ->orderBy(['display_order' => SORT_DESC])
                                    ->count();

        if (!$this->id) {
            $this->maxPriority++;
            $this->priority = $this->maxPriority;
        } else {
            if ($this->isFirst) {
                $this->priority = ($this->display_order / 10000);
            } else if ($this->isSecond) {
                $this->priority = ($this->display_order % 10000 / 100);
            } else {
                $this->priority = ($this->display_order % 100);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->initPriority();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isFirst) {
            $this->display_order = $this->priority * 10000;
        } else if ($this->isSecond) {
            $this->display_order = $this->parent->display_order + $this->priority * 100;
        } else {
            $this->display_order = $this->parent->display_order + $this->priority;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        // 只有排序值修改了才需要执行后续操作
        if (!$insert && !isset($changedAttributes['display_order'])) {
            return;
        }

        if (!$insert) {
            $changed = $this->display_order - $changedAttributes['display_order'];

            // 旧排序值之后的权限排序值递减
            static::updateAfterDisplayOrders($this->id, $changedAttributes['display_order'], false, $changed > 0);
        }

        // 新排序值之后的权限排序值递增
        static::updateAfterDisplayOrders($this->id, $this->display_order, true);

        if (!$insert) {
            // 更新子权限和孙子权限的排序值
            static::updateChildrenDisplayOrders($this->id, $changed);
        }
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        // 被删除的权限排序值之后的权限排序值递减
        static::updateAfterDisplayOrders($this->id, $this->display_order, false);
    }

    /**
     * 更新子权限和孙子权限的排序值
     *
     * @param integer $pid      父权限ID
     * @param integer $changed  排序值的变化量，可以是正数，也可以是负数
     * @return boolean
     */
    public static function updateChildrenDisplayOrders($pid, $changed)
    {
        return static::updateAllCounters(['display_order' => $changed], ['OR', ['pid' => $pid], ['ppid' => $pid]]);
    }

    /**
     * 更新后继权限的排序值
     *
     * @param integer $id             当前权限ID，这个权限的排序值不修改，要排除
     * @param integer $display_order  排序值
     * @param boolean $increment      修改后的排序值增加还是减少
     * @return boolean 
     */
    public static function updateAfterDisplayOrders($id, $display_order, $increment, $dummy = false)
    {
        if ($display_order % 10000 == 0) {
            $changed = 10000;
        } else if ($display_order % 100 == 0) {
            $changed = 100;
        } else {
            $changed = 1;
        }

        return static::updateAllCounters(
                    ['display_order' => $increment ? $changed : -$changed],
                    ['AND',
                        ['>=', 'display_order', $display_order + ($dummy ? $changed : 0)],
                        ['<=', 'display_order', $display_order + 99 * $changed],
                        ['!=', 'id', $id]
                    ]);
    }


    /**
     * 关联父权限
     */
    public function getParent()
    {
        return $this->hasOne(static::className(), ['id' => 'pid']);
    }

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

}
