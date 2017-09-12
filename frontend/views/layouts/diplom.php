<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
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
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?= Url::toRoute(['main/index']);?>">Главная</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?= Url::toRoute(['main/tasks']);?>">Задачи <span class="sr-only">(current)</span></a></li>
        <li><a href="<?= Url::toRoute(['main/competitions']);?>">Соревнования</a></li>
        <li><a href="<?= Url::toRoute(['main/raiting']);?>">Рейтинг</a></li>
        <li><a href="<?= Url::toRoute(['main/about']);?>">О нас</a></li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
      <?php if(Yii::$app->user->isGuest){?>
        <li><a href="<?= Url::toRoute(['site/login']);?>"><i class="fa fa-user-circle" aria-hidden="true"></i> Вход</a></li>
        <li><a href="<?= Url::toRoute(['site/signup']);?>">Регистрация</a></li>
      <?php } else { ?>
          <li class="menu_profile">
          Добро пожаловать, <a href="<?= Url::toRoute(['main/profile']);?>"><i class="fa fa-user-circle" aria-hidden="true"></i> <?=Yii::$app->user->identity->username;?></a>
          </li>
          <li><a class="logout" href="<?=Url::toRoute(['site/logout']);?>">Выход</a></li>
          <style>
            .top_menu .menu_profile a
            {
                display: inline-block;
                text-decoration: underline;  
            }
          </style>
      <?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
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
