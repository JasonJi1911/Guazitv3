<?php
namespace admin\controllers;

use admin\models\LoginForm;
use admin\models\UpdatePasswordForm;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class'  => 'yii\web\ErrorAction',
                'layout' => false,
            ],

            'captcha' => [
                'class' => 'admin\components\CaptchaAction', // 自定义为数字
                'maxLength' => 4,
                'minLength' => 4,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index', [
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->cache->set('login_flag', '1');
            return $this->goBack();
        } else {
            $model->password = '';

            $this->layout = false;
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Update Password action.
     *
     * @return string
     */
    public function actionPassword()
    {
        $model = new UpdatePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->updatePassword()) {
            return $this->redirect(['site/logout']);
        }

        return $this->render('password', ['model' => $model]);
    }

}
