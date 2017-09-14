<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$url=Url::to('');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

<nav class="navbar navbar-default top_menu">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?= Url::toRoute(['main/index']);?>">Главная</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if (strpos($url, 'task')) {?> class="active" <?php }?>><a href="<?= Url::toRoute(['main/tasks']);?>"><i class="fa fa-code" aria-hidden="true"></i> Задачи <span class="sr-only">(current)</span></a></li>
        <li <?php if (strpos($url, 'competition')) {?> class="active" <?php }?>><a href="<?= Url::toRoute(['main/competitions']);?>"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Соревнования</a></li>
        <li <?php if (strpos($url, 'raiting')) {?> class="active" <?php }?>><a href="<?= Url::toRoute(['main/raiting']);?>"><i class="fa fa-star-o" aria-hidden="true"></i> Рейтинг</a></li>
        <li <?php if (strpos($url, 'contact')) {?> class="active" <?php }?>><a href="<?= Url::toRoute(['site/contact']);?>"><i class="fa fa-envelope-o" aria-hidden="true"></i> Обратная связь</a></li>
        <li <?php if (strpos($url, 'about')) {?> class="active" <?php }?>><a href="<?= Url::toRoute(['site/about']);?>"><i class="fa fa-info" aria-hidden="true"></i> Информация</a></li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
      <?php if(Yii::$app->user->isGuest){?>
        <li <?php if (strpos($url, 'login')) {?> class="active" <?php }?>><a href="<?= Url::toRoute(['site/login']);?>"><i class="fa fa-user-circle" aria-hidden="true"></i> Вход</a></li>
        <li <?php if (strpos($url, 'signup')) {?> class="active" <?php }?>><a href="<?= Url::toRoute(['site/signup']);?>">Регистрация</a></li>
      <?php } else { ?>
          <li class="menu_profile">
            <a href="<?= Url::toRoute(['main/profile']);?>">Личный кабинет  <i class="fa fa-user-circle" aria-hidden="true"></i> <?=Yii::$app->user->identity->username;?></a>
          </li>
          <li><a class="logout" href="<?=Url::toRoute(['site/logout']);?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Выход</a></li>
      <?php } ?>
      </ul>
    </div>
  </div>
</nav>    

    <div>

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">Тренування з програмування &copy; <?= date('Y') ?> Дипломна робота. Грабовська Юлія, КНТ-423</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
