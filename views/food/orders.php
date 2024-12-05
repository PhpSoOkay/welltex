<?php

/** @var ActiveDataProvider $ordersDataProvider */


use yii\data\ActiveDataProvider;
use yii\grid\GridView;

$this->title                   = 'Меню';
$this->params['breadcrumbs'][] = $this->title;

$foods = \app\models\Food::find()->indexBy('id')->all();
echo GridView::widget([
    'dataProvider' => $ordersDataProvider,
    'columns'      => [
        'id',
        [
            'label' => 'Блюдо',
            'value' => function ($data) use ($foods) {
                return $foods[$data->food_id]?->title ?? 'empty';
            },
        ],
        [
            'label' => 'Кол-во',
            'value' => function ($data) use ($foods) {
                return $data->food_count;
            },
        ],
    ],
]);
?>