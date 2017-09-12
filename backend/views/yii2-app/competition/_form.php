<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Task;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\Competition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="competition-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'task_ids')->widget(Select2::className(), [
                'data' => Task::find()->select(['name', 'id'])->indexBy('id')->column(),
                'size' => Select2::MEDIUM,
                'options' => ['multiple' => true, 'placeholder'=>'Выберите задачи'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])   ?>

    <?= $form->field($model, 'time_start')->input('datetime-local') ?>

    <?= $form->field($model, 'time_end')->input('datetime-local') ?>

    <?php if(Yii::$app->controller->route == 'competition/update'){ ?>
    <?= $form->field($model, 'checked')->widget(Select2::className(), [
                'data' => [0 => 'Отклонить', 1 => 'Разрешить соревнование'],
                'size' => Select2::MEDIUM,
                'options' => ['multiple' => false, 'placeholder'=>'Модерировать'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])   ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
