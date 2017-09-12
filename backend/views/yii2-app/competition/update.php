<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Competition */

$this->title = 'Редактировать соревнование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Соревнования', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="competition-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
