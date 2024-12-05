<?php

/** @var yii\web\View $this */

/** @var app\models\LoginForm $model */
/** @var array $foodData */

/** @var array $pages */

use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;

$this->title                   = 'Меню';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(
    '@web/js/cart.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>


    <div class="row">
        <?php
        foreach ($foodData as $food): ?>
            <div class="p-2 col-2 ">
                <div class="menu_food_item" style="background-image: url('<?= $food->thumbnail; ?>')">
                    <div class="text-center h4 text-white d-flex flex-column justify-content-between">
                        <span class="opacity-100"><?= $food->title; ?></span>
                        <span class="add_to_cart" onclick="addToCart(<?= $food->id; ?>)">Заказать</span>
                    </div>
                </div>
            </div>
        <?php
        endforeach; ?>
    </div>
<?php
echo LinkPager::widget([
    'pagination' => $pages,
]);
?>