<?php

/**
 * @var \yii\web\View $this
 */

?>

<section class="section-site-index">
    <?= \yii\helpers\Html::beginForm('', 'post', [
        'id'           => 'parse-request-form',
        'autocomplete' => 'off',
    ]); ?>

    <?= \yii\helpers\Html::input('url', 'url', null, [
        'autocomplete' => 'off',
        'required'     => true,
    ]); ?>

    <?= \yii\helpers\Html::submitButton('Добавить ссылку'); ?>

    <?= \yii\helpers\Html::endForm(); ?>
</section>
