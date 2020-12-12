<?php
namespace console\controllers;

use Yii;
use admin\models\user\User;
use yii\console\Controller;

class InsertUserController extends Controller
{

    public function actionRun()
    {
        ini_set('memory_limit','3072M');
        set_time_limit(0);
        echo "\n " . date('Y/m/d H:i:s') . " start \n";

        $mob_arr = array(
            '130','131','132','133','134','135','136','137','138','139','144','147','150','151','152','153','155','156','157','158','159','176','177','178','180','181','182','183','184','185','186','187','188','189',
        );

        $data = [];
        for ($a = 1; $a<=100; $a++) {
            for ($i = 1; $i<=40; $i++) {
                $data[] = [
                    'nickname' => '游客'.$mob_arr[array_rand($mob_arr)].mt_rand(1,9).mt_rand(1,9),
                    'user_token' => md5(uniqid(mt_rand(), true)),
                    'status' => 1,
                    'mobile' => $mob_arr[array_rand($mob_arr)].mt_rand(1000,9999).mt_rand(1000,9999),
                    'reg_type' => 1,
                    'user_type' => 1
                ];
            }
        }

        Yii::$app->db->createCommand()
            ->batchInsert(User::tableName(), ['nickname', 'user_token', 'status', 'mobile',  'reg_type', 'user_type'], $data)
            ->execute();
        echo "\n " . date('Y/m/d H:i:s') . " end \n";

    }
}