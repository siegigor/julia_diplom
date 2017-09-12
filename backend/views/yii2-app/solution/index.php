<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use common\models\Task;
use common\models\Competition;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SolutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Решения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solution-index">

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '60'],
                'template' => '{view} {link}',
            ],
            //'id',
            [
                'attribute' => 'user_id',
                'filter' => User::find()->select(['username'])->indexBy('id')->column(),
                'value' => 'user.username',
            ],
            [
                'attribute' => 'task_id',
                'filter' => Task::find()->select(['name'])->indexBy('id')->column(),
                'value' => 'task.name',
            ],
            //'code:ntext',
            //'lang',
            // 'test_result:ntext',
            // 'error:ntext',
            [
                'attribute'=>'solved',
                'filter'=>['0'=>'Нет', '1'=> 'Да'],
                'format' => 'html',
                'value'=>function($data){
                    if($data->solved == 0)
                        return '<i class="fa fa-minus" aria-hidden="true"></i>';
                    else if($data->solved == 1)
                        return '<i class="fa fa-check" aria-hidden="true"></i>';
                    
                }
            ],
            [
                'attribute' => 'competition_id',
                'filter' => Competition::find()->select(['name'])->indexBy('id')->column(),
                'value' => 'competitions.name',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
