<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Соревнования';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competition-index">

    <p>
        <?= Html::a('Создать соревнование', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions'=>function($model){
                if($model->checked==0)
                {
                    return ['class' => 'danger'];
                }   
                else
                {
                    return ['class' => 'success'];
                }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //['class' => 'yii\grid\ActionColumn'],
            
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete} {check}',
            'buttons' => [
                'check' => function ($url,$model) {
                    if($model->checked == 0)
                    return Html::a(
                    '<span class="fa fa-check"></span>', 
                    Url::toRoute(['competition/check', 'id' => $model->id]));
                },
                ],
            ],
            
            //'id',
            'name',
            'task_ids',
            //'time_start',
            [
                'attribute' => 'time_start',
                'value'=>function($data){
                    return date('H:i (d.m.Y)', $data->time_start);
                }
            ],
            //'time_end',
            [
                'attribute' => 'time_end',
                //'format' =>  ['date', 'H:i (d.m.Y)'],
                'value'=>function($data){
                    return date('H:i (d.m.Y)', $data->time_end);
                }
            ],
            // 'user_id',
            //'checked',
            [
                'attribute'=>'checked',
                'format' => 'html',
                'value' => function($data){
                    if($data->checked==1)
                        return '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    else
                        return "-";
                }
            ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
