<?php
namespace admin\controllers;

use admin\models\Admin;
use admin\models\AdminSearch;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class AdminController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->id != 1) { // 不是总管理员
            throw new ForbiddenHttpException('只有超级管理员才能操作此菜单');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(Yii::$app->request->queryParams)
        ]);
    }

    public function actionCreate()
    {
        $model = new Admin();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->setPassword($model->password_hash); // 设置密码
            if ($model->save()) {
                return $this->redirect('index');
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Admin::findOne($id);
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->password) { // 如果密码有更新
                $model->setPassword($model->password);
            }
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $admin = Admin::findOne($id);
        if ($admin) {
            // 管理员不可以删除
            if ($admin->id == 1) {
                return false;
            }

            $admin->delete();
        }

        return $this->redirect('index');
    }

    public function actionActive($id, $op)
    {
        $model = Admin::findOne($id);
        $op ? $model->enable() : $model->disable();

        return $this->redirect('index');
    }
}
