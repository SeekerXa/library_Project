<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $user = Yii::$app->user->identity;
    $menu = [];
    if ($user)
    {
        if ($user->isAdmin())
        {
            $menu = array_merge($menu, [
                ['label' => 'Użytkownicy', 'url' => ['/user/index']],
            ]);
        }

        if ($user->isAdmin() || $user->isLibrarian())
        {
            $menu = array_merge($menu, [
                ['label' => 'Zamówienia', 'url' => ['/order/index']],
                ['label' => 'Kategorie', 'url' => ['/category/index']],
                ['label' => 'Książki', 'url' => ['/book/index']],
            ]);
        }
    }


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $menu
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Zamówienia', 'url' => ['/order/index']],
            ['label' => 'Książki', 'url' => ['/site/index']],
            ['label' => 'O bibliotece', 'url' => ['/site/about']],
            ['label' => 'Kontakt', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Logowanie', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Bibiloteka <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
