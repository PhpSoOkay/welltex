<?php

namespace app\controllers;

use app\models\Food;
use app\models\Order;
use Yii;
use yii\data\ActiveDataProvider;
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

    public function actionOrders()
    {
        $ordersDataProvider = new ActiveDataProvider([
            'query'      => Order::find()->where(['user_id' => Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('orders', [
            'ordersDataProvider' => $ordersDataProvider,
        ]);
    }

    public function actionAdd()
    {
        try {
            if (Yii::$app->user->isGuest) {
                throw new \Exception('User Not Authorized', 403);
            }
            $data = Yii::$app->request->post();
            if (!isset($data['food_id'])) {
                throw new \Exception('Food not Found', 404);
            }
            $order             = new Order();
            $order->user_id    = (int) Yii::$app->user->id;
            $order->food_id    = (int) $data['food_id'];
            $order->food_count = (int) $data['food_count'];
            $order->insert();

            return $this->asJson([
                'success' => true,
            ]);
        } catch (\Exception $exception) {
            return $this->asJson([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}