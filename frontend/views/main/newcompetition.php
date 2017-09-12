<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
use kartik\select2\Select2;
use common\models\Task;

echo  date('Y-m-d\TH:i:sP',  $competition->time_start);
?>

<div class="container main_content">
    <div class="row">
    <h1>Новое соревнование</h1>
        <?php if($thanks){?>
        <div class="alert alert-success" role="alert"><?= $thanks;?></div>
        <?php } ?>
        
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-6">
            <?= $form->field($competition, 'name')->textInput(); ?>
            <?= $form->field($competition, 'task_ids')->widget(Select2::className(), [
                'data' => Task::find()->select(['name', 'id'])->indexBy('id')->column(),
                'size' => Select2::MEDIUM,
                'options' => ['multiple' => true, 'placeholder'=>'Выберите задачи'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])   ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($competition, 'time_start')->input('datetime-local'); ?>
            <?= $form->field($competition, 'time_end')->input('datetime-local'); ?>
       </div> 
       <?= Html::submitButton($competition->isNewRecord ? 'Создать соревнование' : 'Редактировать соревнование', ['class' => 'tb_button']) ?>
       <?php ActiveForm::end(); ?>
        
    </div>
</div>

