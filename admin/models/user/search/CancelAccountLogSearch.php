<?php
namespace admin\models\user\search;

use admin\models\user\CancelAccountLog;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class CancelAccountLogSearch extends CancelAccountLog implements SearchInterface
{
    use SearchTrait;
}