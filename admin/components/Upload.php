<?php
namespace admin\components;
use common\helpers\Tool;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use common\helpers\OssHelper;

/**
 * 文件上传处理
 */
class Upload extends Model
{
    private $file;

    /**
     * 上传图片
     * @param int $comicId 漫画ID
     * @return array
     */
    public function upImages($comicId=0)
    {
        $model = new static;
        $model->file = UploadedFile::getInstanceByName('file');
        if (!$model->file) {
            return false;
        }

        $imgRealmName = Yii::$app->setting->get('oss.outside_server') . '/';

        if ($model->validate()) {
            //文件名
            $filename = md5(time() . rand(10000, 99999)) . '.' . $model->file->extension;
            //目录
            $dir = Tool::getComicImgDir($comicId);
            if (Yii::$app->setting->get('oss.upload_file_type') == 'local') {  // 本地上传
                $relativePath = getcwd() . '/../../uploads/';

                $filename = md5(time() . rand(10000, 99999)) . '.' . $model->file->extension;
                if (!is_dir($relativePath.$dir)) {
                    FileHelper::createDirectory($relativePath.$dir);
                }

                $model->file->saveAs($relativePath . $dir . $filename);

                return [
                    'code' => 0,
                    'url' => $imgRealmName . $dir . $filename,
                    'attachment' => $dir . $filename
                ];
            } else {
                $oss = new OssHelper();

                $imgPath = $dir.$filename;
                $oss->uploadFile($model->file->tempName, $imgPath);

                return [
                    'code' => 0,
                    'url' => $imgRealmName . $imgPath,
                    'attachment' => $imgPath
                ];
            }
        } else {
            $errors = $model->errors;
            return [
                'code' => 1,
                'msg' => current($errors)[0]
            ];
        }
    }
}
