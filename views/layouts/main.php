<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php
$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php
    $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php
$this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'Welltex Test Task',
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items'   => [
            ['label' => 'Меню', 'url' => ['/food/index']],
            !Yii::$app->user->isGuest ? ['label' => 'Мои Заказы', 'url' => ['/order/orders']] : '',
            Yii::$app->user->isGuest
                ? ['label' => 'Войти', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>',
        ],
    ]);
    NavBar::end();

    $this->registerJsFile(
        '@web/js/cart.js',
        ['depends' => [\yii\web\JqueryAsset::class]]
    );

    $session = Yii::$app->session;
    ?>
</header>

<script src="//unpkg.com/alpinejs" defer></script>
<main id="main" class="flex-shrink-0" role="main"
      x-data='{ cart_open:false,cart:<?= json_encode($session->get('cart_data') ?? [], JSON_UNESCAPED_UNICODE) ?>}'>
    <div x-show="cart.length > 0" class="d-flex flex-column" id="cart">
        <h1>Корзина</h1>
        <template x-for="(food, foodKey) in cart">
            <div>
                <span x-text="food.title"></span>
                <span x-text="food.selected_count"></span>
                <button
                        x-on:click="
                        cart = cart.filter((food, foodOnForKey) => foodOnForKey !== foodKey);
                        "
                        class="px-1 rounded-3 border border-danger"
                >-
                </button>
            </div>
        </template>
        <button x-show="cart.length" class="btn btn-success mt-2" x-on:click="addToCart(cart); cart.length = 0;">Создать
            заказ
        </button>
    </div>
    <div x-disable="cart.length > 0" class="container">
        <?php
        if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php
        endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php
$this->endBody() ?>
</body>
</html>
<?php
$this->endPage() ?>
