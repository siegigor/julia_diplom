<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Competition */

$this->title = 'Создать соревнование';
$this->params['breadcrumbs'][] = ['label' => 'Соревнования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competition-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
