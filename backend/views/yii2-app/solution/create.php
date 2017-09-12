<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Solution */

$this->title = 'Create Solution';
$this->params['breadcrumbs'][] = ['label' => 'Solutions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solution-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
