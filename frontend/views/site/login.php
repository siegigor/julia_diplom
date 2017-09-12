<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход на сайт';
?>
<div class="container">
    <div class="site-signup">
        <h1><?= Html::encode($this->title) ?></h1>
    
        <p>Пожалуйста, заполните следующие поля, что бы зайти:</p>
    
        <div class="row">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>
    
                    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
    
                    <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>
    
                    <div style="color:#999;margin:1em 0">
                        <?= Html::a('Забыли пароль?', ['site/request-password-reset']) ?>
                    </div>
    
                    <div class="form-group">
                        <?= Html::submitButton('Войти', ['class' => 'tb_button', 'name' => 'login-button']) ?>
                    </div>
    
                <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>