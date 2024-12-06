<?php

namespace app\models;

use yii\db\ActiveRecord;

class OrderData extends ActiveRecord
{
    public function getFood(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Food::class, ['id' => 'food_id']);
    }
}