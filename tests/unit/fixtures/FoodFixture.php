<?php

namespace tests\unit\fixtures;

use app\models\Food;
use yii\test\ActiveFixture;

class FoodFixture extends ActiveFixture
{
    public $modelClass = Food::class;
    public $dataFile = __DIR__ . '/data/food.php';
}