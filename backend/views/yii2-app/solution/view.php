<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Solution */

$this->title = "Решение № ".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Решения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solution-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => $model->user->username,
            ],
            [
                'attribute' => 'task_id',
                'value' => $model->task->name,
            ],
            'code:ntext',
            'lang',
            //'test_result:ntext',
            'error:ntext',
            [
                'attribute' => 'solved',
                'format' => 'html',
                'value' => function($model)
                {
                    if($model->solved == 0)
                         return '<i class="fa fa-minus" aria-hidden="true"></i>';
                    else if($model->solved == 1)
                        return '<i class="fa fa-check" aria-hidden="true"></i>';
                }
            ],
            [
                'attribute' => 'competition_id',
                'value' => $model->competitions->name,
            ]
        ],
    ]) ?>

</div>
