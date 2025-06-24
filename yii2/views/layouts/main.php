<?php

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;
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
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>
            body { background-color: #f8f9fa; }
            .navbar-brand { font-weight: bold; }
            .main-content { margin-top: 20px; }
            .footer { margin-top: 50px; padding: 20px 0; background-color: #343a40; color: white; }
        </style>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
        <div class="alert alert-<?= $type ?> alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?= \yii\helpers\Html::encode($message) ?>
        </div>
    <?php endforeach; ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Főoldal', 'url' => ['/site/index']],
                ['label' => 'Igény beküldése', 'url' => ['/site/request']],
                ['label' => 'Admin - online lista', 'url' => ['/admin/index']],
                ['label' => 'Admin - exportálás', 'url' => ['/admin/export']],
            ],
        ]);
        NavBar::end();
        ?>

        <div class="container main-content">
            <?php echo $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="text-center">&copy; <?= date('Y') ?> Építőipari Igénykezelő Rendszer
            <?php if (!Yii::$app->user->isGuest): ?>
                | Bejelentkezve mint: <?= Html::encode(Yii::$app->user->identity->username) ?>
                | <?= Html::a('Kijelentkezés', ['/admin/logout'], ['data-method' => 'post']) ?>
            <?php else: ?>
                | <?= Html::a('Bejelentkezés', ['/admin/login']) ?>
                | <?= Html::a('Regisztráció', ['/admin/register']) ?>
            <?php endif; ?>
            </p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
