<?php
namespace apinew\dao;

use apinew\data\ActiveDataProvider;
use apinew\models\video\Comment;
use apinew\models\video\CommentLike;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use yii\helpers\ArrayHelper;
use Yii;

class CommentDao extends BaseDao
{

}