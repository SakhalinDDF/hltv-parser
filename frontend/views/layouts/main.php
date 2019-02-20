<?php

/**
 * @var \yii\web\View $this
 * @var string        $content
 */

\frontend\assets\Layout::register($this);

?>
<?= $this->beginPage(); ?>
<!doctype html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?= $this->head(); ?>

    <title><?= \yii\helpers\Html::encode($this->title ? : Yii::$app->name); ?></title>
</head>
<body>
<?= $this->beginBody(); ?>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navigation" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?= \yii\helpers\Html::encode(Yii::$app->name); ?></a>
        </div>

        <div class="collapse navbar-collapse" id="header-navigation">
            <?= \yii\bootstrap\Nav::widget([
                'items'   => [
                    [
                        'url'   => ['/site/index'],
                        'label' => 'Регистрация ссылки',
                    ],
                ],
                'options' => [
                    'class' => 'nav navbar-nav navbar-right',
                ],
            ]) ?>
        </div>
    </div>
</nav>

<div class="page-wrapper">
    <div class="container">
        <?= $content; ?>
    </div>
</div>

<?= $this->endBody(); ?>
</body>
</html>
<?= $this->endPage(); ?>
