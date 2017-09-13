<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Competition */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Соревнования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competition-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'task_ids',
            [
                'attribute' => 'time_start',
                'value' =>  function($data){
                    return date('H:i (d.m.Y)', $data->time_start);
                }
            ],
            [
                'attribute' => 'time_end',
                'value' =>  function($data){
                    return date('H:i (d.m.Y)', $data->time_start);
                }
            ],
            [
                'attribute' => 'user_id',
                'value' => $model->users->username,
            ],
            [
                'attribute' => 'checked',
                'format' => 'html',
                'value' => function($model)
                {
                    if($model->checked == 0)
                         return '<i class="fa fa-minus" aria-hidden="true"></i>';
                    else if($model->checked == 1)
                        return '<i class="fa fa-check" aria-hidden="true"></i>';
                }
            ],
        ],
    ]) ?>

</div>
