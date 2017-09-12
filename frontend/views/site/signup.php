<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="container">
    <div class="site-signup">
        <h1><?= Html::encode($this->title) ?></h1>
    
        <p>Пожалуйста, заполните следующие поля для регистрации:</p>
    
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
    
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>
    
                    <?= $form->field($model, 'email')->label('E-mail') ?>
    
                    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
    
                    <div class="form-group">
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'tb_button', 'name' => 'signup-button']) ?>
                    </div>
    
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>