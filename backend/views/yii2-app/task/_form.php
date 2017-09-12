<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\Category;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'input_desc')->textarea(['rows' => 4]) ?>
    
    <?= $form->field($model, 'output_desc')->textarea(['rows' => 4]) ?>
    
    <?= $form->field($model, 'input1')->textarea(['rows' => 4]) ?>
    
    <?= $form->field($model, 'output1')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'num')->textInput() ?>

    <?= $form->field($model, 'category_id')->widget(Select2::className(), [
        'data' => Category::find()->select(['name', 'id'])->indexBy('id')->column(),
        'size' => Select2::MEDIUM,
        'options' => ['placeholder'=>'Выберите категорию'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])   ?>
    
    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="fa fa-check" aria-hidden="true"></i> Тесты</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 20, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelTests[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'input',
                    'output',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelTests as $i => $modelTest): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Создать тест</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelTest->isNewRecord) {
                                echo Html::activeHiddenInput($modelTest, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelTest, "[{$i}]input")->textArea() ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelTest, "[{$i}]output")->textArea() ?>
                            </div>
                        </div><!-- .row -->
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
