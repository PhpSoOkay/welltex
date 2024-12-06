<?php

namespace app\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public function getOrderData(): \yii\db\ActiveQuery
    {
        return $this->hasMany(OrderData::class, ['order_id' => 'id']);
    }
}