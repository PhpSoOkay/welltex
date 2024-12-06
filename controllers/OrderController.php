<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderData;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class OrderController extends Controller
{

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['orders', 'add', 'delete', 'updateCart'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['updateCart'],
                        'roles'   => ['?'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['orders', 'add', 'delete'],
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionOrders()
    {
        if (Yii::$app->user->isGuest) {
            throw new \Exception('User Not Authorized', 403);
        }

        $ordersDataProvider = new ActiveDataProvider([
            'query'      => Order::find()->with('orderData.food')->where(['user_id' => Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('orders', [
            'ordersDataProvider' => $ordersDataProvider,
        ]);
    }

    public function actionDelete(int $id)
    {
        if (Yii::$app->user->isGuest) {
            throw new \Exception('User Not Authorized', 403);
        }

        $order = Order::findOne($id);
        if (!$order || $order->user_id != Yii::$app->user->id) {
            throw new \Exception('Cant do This', 403);
        }
        $order->delete();

        return $this->redirect(Url::to(['order/orders']));
    }

    public function actionAdd()
    {
        try {
            if (Yii::$app->user->isGuest) {
                throw new \Exception('User Not Authorized', 403);
            }
            $data = Yii::$app->request->post();
            if (!isset($data['cart'])) {
                throw new \Exception('cart is empty', 404);
            }
            $cart = $data['cart'] ?? [];
            if (count($cart) > 0) {
                $order          = new Order();
                $order->user_id = (int) Yii::$app->user->id;
                $order->insert();

                foreach ($cart as $food) {
                    $orderData             = new OrderData();
                    $orderData->food_id    = (int) $food['food_id'];
                    $orderData->food_count = (int) $food['selected_count'];
                    $orderData->order_id   = (int) $order->id;
                    $orderData->insert();
                }
            }
            $session = Yii::$app->session;
            $session->remove('cart_data');

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

    public function actionUpdateCart()
    {
        $data = Yii::$app->request->post();
        $cart = $data['cart'] ?? [];

        $session = Yii::$app->session;
        $session->set('cart_data', $cart);
    }
}