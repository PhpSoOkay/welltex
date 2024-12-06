<?php

/** @var ActiveDataProvider $ordersDataProvider */


use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

$this->title                   = 'Меню';
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'dataProvider' => $ordersDataProvider,
    'columns'      => [
        'id',
        [
            'label' => 'Блюда',
            'value' => function ($data) {
                $foodString = '';
                foreach ($data->orderData as $orderData) {
                    $foodString .= $orderData->food->title . ' (' . $orderData->food_count . ')' . PHP_EOL;
                }

                return $foodString ?? 'empty';
            },
        ],
        [
            'class'  => 'yii\grid\ActionColumn',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return '';
                },
                'view' => function ($url, $model, $key) {
                    return '';
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('Remove', $url);
                },
            ],
            'visibleButtons' => ['delete']
        ],
    ],
]);
?>