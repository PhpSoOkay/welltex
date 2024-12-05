<?php

namespace app\controllers;

use app\models\activeRecords\Food;
use yii\data\Pagination;
use yii\web\Controller;

class FoodController extends Controller
{
    public function actionIndex(): string
    {
        $query      = Food::find();
        $countQuery = clone $query;
        $pages      = new Pagination(['totalCount' => $countQuery->count()]);
        $foodData   = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('menu', [
            'foodData' => $foodData,
            'pages'    => $pages,
        ]);
    }
}