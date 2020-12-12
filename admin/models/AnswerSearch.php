<?php
namespace admin\models;

use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class AnswerSearch extends Answer implements SearchInterface
{
    use SearchTrait;
}
