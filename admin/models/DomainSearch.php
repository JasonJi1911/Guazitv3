<?php
namespace admin\models;

use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class DomainSearch extends Domain implements SearchInterface
{
    use SearchTrait;
}