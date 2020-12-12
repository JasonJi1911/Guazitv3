<?php
namespace api\dao;

use api\data\ActiveDataProvider;
use api\models\video\Comment;
use api\models\video\CommentLike;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use yii\helpers\ArrayHelper;
use Yii;

class CommentDao extends BaseDao
{

}