<?php
namespace appapi\dao;

use appapi\data\ActiveDataProvider;
use appapi\models\video\Comment;
use appapi\models\video\CommentLike;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use yii\helpers\ArrayHelper;
use Yii;

class CommentDao extends BaseDao
{

}