<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Admin Login';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="login-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        <?= Html::a('Register', ['admin/register'], ['class' => 'btn btn-link']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
