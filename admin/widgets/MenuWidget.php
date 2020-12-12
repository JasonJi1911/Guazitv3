<?php

namespace admin\widgets;

use admin\models\permission\Permission;
use Yii;
use yii\base\Widget;

/**
 * 菜单部件
 *
 */
class MenuWidget extends Widget
{

    /**
     * Executes the widget.
     */
    public function run()
    {
        return $this->render('menu', ['menus' => $this->getMenus()]);
    }

    private function getMenus()
    {
        $menus = [];

        $role = Yii::$app->user->identity->role;

        if ($role->id != 1) {
            // 已分配的权限
            $granted = [];
            foreach ($role->permissions as $_permission) {
                $granted[$_permission->id]   = 1;
                $granted[$_permission->pid]  = 1;
                $granted[$_permission->ppid] = 1;
            }
        }

        foreach (Permission::find()->all() as $permission) {

            if ($role->id != 1 && !isset($granted[$permission->id])) {
                continue;
            }

            if ($permission->is_menu) {
                $menu = $permission->attributes;
                $menu['icon'] = $permission->iconText;
                
                $params = [];
                if ($menu['params']) {
                    foreach (explode('&', $menu['params']) as $item) {
                        list($key, $val) = explode('=', $item);
                        $params[$key] = $val;
                    }
                }
                $menu['params'] = $params;

                if (!$menu['pid']) {
                    $menu['children'] = [];
                    $menus[$menu['id']] = $menu;
                } else if (isset($menus[$menu['pid']])) {
                    $menu['children'] = [];
                    $menu['class'] = '';
                    $menus[$menu['pid']]['children'][$menu['id']] = $menu;
                } else if (isset($menus[$menu['ppid']])) {
                    $menu['class'] = '';
                    $menus[$menu['ppid']]['children'][$menu['pid']]['children'][$menu['id']] = $menu;
                }
            }


            if (Yii::$app->requestedRoute && $permission->route == Yii::$app->requestedRoute) {
                $ok = 1;
                if ($permission->params) {
                    foreach (explode('&', $permission->params) as $item) {
                        list($key, $val) = explode('=', $item);
                        if ($val != trim(Yii::$app->request->get($key))) {
                            $ok = 0;
                            break;
                        }
                    }
                }

                if ($ok) {

                    if (isset($menus[$permission->ppid])) {

                        $menus[$permission->ppid]['children'][$permission->pid]['class'] = 'active open';
                        if (isset($menus[$permission->ppid]['children'][$permission->pid]['children'][$permission->id])) {
                            $menus[$permission->ppid]['children'][$permission->pid]['children'][$permission->id]['class'] = 'active open';
                        } else if ((!$permission->is_menu && $permission->pnode)) {
                            $menus[$permission->ppid]['children'][$permission->pid]['children'][$permission->pnode]['class'] = 'active open';
                        }
                        
                    } else if (isset($menus[$permission->pid])) {
                        $menus[$permission->pid]['children'][$permission->id]['class'] = 'active open';
                    }
                    
                }
            }
        }

        return $menus;
    }
}
