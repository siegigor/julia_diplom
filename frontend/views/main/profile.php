<?php 
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Url;
    use yii\widgets\Pjax;
    use yii\widgets\LinkPager;
    use frontend\models\Product;
    $this->title = "Личный кабинет";
?>
<div class="container acc_block">
    <div class="row">
        
        <div class="col-md-12">
          <ul class="nav nav-tabs account-tab" role="tablist">
            <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Данные пользователя</a></li>
            <li role="presentation"><a href="#mysolutions" aria-controls="mysolutions" role="tab" data-toggle="tab">Мои решения</a></li>
            <li role="presentation"><a href="#mycompetitions" aria-controls="mysolutions" role="tab" data-toggle="tab">Соревнования</a></li>
          </ul>

          <div class="tab-content profile">
            <div role="tabpanel" class="tab-pane active" id="profile">
                <?php Pjax::begin(['id'=>'account_pjax', 'timeout'=>5000]);?>
        
                        <h1 class="pagetoscroll">Добро пожаловать, <?=Yii::$app->user->identity->username;?>!</h1>
                        <?php if($edit!=1){?>
                        <div class="profile_data">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul>
                                        <li>Логин: <span><?=$user->username;?></span></li>
                                        <li>E-mail: <span><?=$user->email;?></span></li>
                                        <li>Страна: <span><?=$user->country;?></span></li>
                                        <li>Университет: <span><?=$user->university;?></span></li>
                                        <li>Группа: <span><?=$user->group;?></span></li>
                                        <li>ФИО: <span><?=$user->name;?></span></li>
                                        <li>Решено задач: <span><?=$user->tasks_solved;?></span></li>
                                        <li>Рейтинг: <span><?=$user->raiting;?></span></li>
                                    </ul>
                                </div>
                            </div>    
                            <a href="<?=Url::toRoute(['main/profile', 'edit'=>1]);?>" class="tb_button">Редактировать</a>
                        </div>
                         <?php }?>
                   
                    <?php if($edit==1){?>
                        <?php $form = ActiveForm::begin(['id' => 'form-profile', 'options'=>['data-pjax'=>1]]); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($user, 'name')->textInput() ?>           
                                    <?= $form->field($user, 'university')->textInput() ?>  
                                    <?= $form->field($user, 'country')->textInput() ?>  
                                    <?= $form->field($user, 'group')->textInput() ?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <?= Html::submitButton('Сохранить', ['class' => 'tb_button', 'name' => 'signup-button']) ?>
                            </div>
                            <div style="color:#999;">
                                Для изменения пароля перейдите по ссылке:  <?= Html::a('Изменить пароль', ['site/request-password-reset']) ?>.
                            </div>
                        <?php ActiveForm::end(); ?>
                    <?php }?>
                    <?php Pjax::end();?>
            </div>
                       
            <div role="tabpanel" class="tab-pane" id="mysolutions">
                <div class="row">
                <?php Pjax::begin(['id'=>'competitions_pjax', 'timeout'=>5000]);?> 
                   <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Задача</th>
                                    <th>Решено</th>
                                    <th>Код</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1+ ($page ? 5*($page-1) : 0); foreach($solutions as $sol){ ?>
                                <tr class="<?php if($sol->solved == 1) echo "success"; else echo "danger"; ?>">
                                    <th><?= $i ;?></th>
                                    <td><a href="<?= Url::toRoute(['main/task', 'id' => $sol->task->id]);?>"><?= $sol->task->name ;?></a></td>
                                    <td >
                                    <?php if($sol->solved == 1) echo "Засчитано";
                                    else echo "Не засчитано"; ?>
                                    </td>
                                    
                                    <td>
                                        <button data-id="<?=$sol->id;?>" class="show_code btn btn-primary">
                                            Показать код решения
                                        </button>
                                        <div class="sol_code sol_code<?=$sol->id;?>">
                                            <pre><?= Html::encode($sol->code);?></pre>
                                        </div>
                                    </td>
                                </tr>
                            <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                 <div class="pags">
                    <?php if($pagination) {?>
                        <div id="" >
                            <?=LinkPager::widget([
                                'pagination'=>$pagination,
                                'prevPageLabel'=>'<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
                                'nextPageLabel' => '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                                'maxButtonCount'=>4
                            ]);?>
                        </div>
                    <?php }?>
                </div>
                <?php Pjax::end();?> 
                 </div>
                  
            </div>
            
            <div role="tabpanel" class="tab-pane" id="mycompetitions">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>1</th>
                                    <th>Название</th>
                                    <th></th>
                                    <th>Дата начала</th>
                                    <th>Дата окончания</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; foreach($competitions as $comp){ ?>
                                <tr>
                                    <th><?= $i ;?></th>
                                    <td><?= $comp->name ;?>
                                    <?php if($comp->user_id === Yii::$app->user->identity->id){ ?>
                                        <a class="edit_comp" href="<?= Url::toRoute(['main/editcompetition', 'id' => $comp->id]);?>"><span>Редактировать</span> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <?php } ?>
                                    </td>
                                    <td>
                                    <?php if($comp->time_end > date('U')){ ?>
                                        <a href="<?= Url::toRoute(['main/competition', 'id' => $comp->id]);?>" class="btn btn-warning">Продолжить соревнование</a>
                                    <?php } else {?>
                                        <a href="<?= Url::toRoute(['main/board', 'comp_id' => $comp->id]);?>" class="btn btn-danger">Посмотреть результаты</a>
                                    <?php }?>
                                    </td>
                                    <td>
                                        <?= date('H:i (d.m.Y)', $comp->time_start);?>
                                    </td>
                                    <td><?= date('H:i (d.m.Y)', $comp->time_end);?></td>
                                </tr>
                            <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                 </div>
            </div>
            
          </div>
        
        </div>
    </div>
</div>