<?php
namespace pc\data;

use Yii;
use yii\base\Arrayable;
use yii\base\Component;
use yii\data\DataProviderInterface;

/**
 * 序列化
 */
class Serializer extends Component
{
    /**
     * Serializes the given data into a format that can be easily turned into other formats.
     * This method mainly converts the objects of recognized types into array representation.
     * It will not do conversion for unknown object types or non-object data.
     * The default implementation will handle [[Model]] and [[DataProviderInterface]].
     * You may override this method to support more object types.
     * @param mixed $data the data to be serialized.
     * @return mixed the converted data.
     */
    public function serialize($data)
    {
        if (is_array($data)) {
            return $this->serializeArray($data);
        } elseif ($data instanceof Arrayable) {
            return $this->serializeModel($data);
        } elseif ($data instanceof DataProviderInterface) {
            return $this->serializeDataProvider($data);
        }

        return $data;
    }

    protected function serializeArray(array $data)
    {
        return array_map(function($value) { return $this->serialize($value); }, $data);
    }

    protected function serializeModel($model, array $fields = [])
    {
        return $model->toArray($fields);
    }

    protected function serializeDataProvider($dataProvider)
    {
        $models = array_values($dataProvider->getModels());
        foreach ($models as $i => $model) {
            $models[$i] = $model->toArray($dataProvider->getFields());
        }

        // 无分页
        if (($pagination = $dataProvider->getPagination()) === false) {
            return $models;
        }

        // 有分页
        return [
            'total_page'   => $pagination->pageCount,
            'current_page' => $pagination->page + 1,
            'page_size'    => $pagination->pageSize,
            'total_count'  => $pagination->totalCount,
            'list'         => $models,
        ];
    }
}
