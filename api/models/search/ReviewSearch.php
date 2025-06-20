<?php

namespace api\models\search;

use api\models\Review;
use yii\data\ActiveDataProvider;

class ReviewSearch extends Review
{
    public function rules(): array
    {
        return [
            ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_REJECTED]],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Review::find();
        $dataProvider =  new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        $this->load($params, '');
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->filterWhere(['status' => $this->status]);
        return $dataProvider;
    }
}