<?php

/** @var yii\web\View $this */

/** @var app\models\LoginForm $model */
/** @var array $foodData */

/** @var array $pages */

use yii\bootstrap5\LinkPager;
use yii\helpers\Url;

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
                        <?php
                        if (Yii::$app->user->isGuest): ?>
                            <a class="add_to_cart" href="<?= Url::to(['/site/login']) ?>">Войти</a>
                        <?php
                        else: ?>
                            <div x-data="{selectedCount: 1, isStartSelect:false}" class="add_to_cart_wrap">

                                <span x-show="!isStartSelect" x-on:click="isStartSelect=true" class="add_to_cart">Заказать</span>
                                <div x-show="isStartSelect">
                                    <span x-show="selectedCount > 1" class="add_to_cart"
                                          x-on:click="selectedCount--">-</span>
                                    <span x-text="selectedCount">-</span>
                                    <span class="add_to_cart" x-on:click="selectedCount++">+</span>
                                    <div class="add_to_cart"  x-on:click="addToCart(<?= $food->id; ?>, selectedCount); isStartSelect = false">Добавить</div>
                                </div>
                            </div>
                        <?php
                        endif; ?>
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