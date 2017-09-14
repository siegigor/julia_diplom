<?php
    use yii\helpers\Url;
?>


<div class="container main_content">
    <div class="row">
    
    <div class="alert alert-warning" role="alert">
    <h2>Добро пожаловать!</h2>
    <p>Приветствуем Вас на ресурсе, который поможет вам восполнить нехватку практических навыков в программировании!</p>
    <p>Невозможно научиться программировать, только лишь читая учебники или статьи, нужно решать задачи и чем больше задач - тем лучше. Однако часто складывается ситуация, когда решив задачу, начинающий программист не уверен, решил ли он её правильно, а проверить правильность решения некому.</p>
    <p>Отправляя решение задачи, автоматически происходит компиляция и решение проходит проверку с помощью тестов. Если все тесты пройдены, значит задача решена правильно.</p>
    </div>
    </div>
    <div class="row">
        <div class="new_tasks">
            <div class="col-md-12">
            <h2>Новые задачи</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Категория</th>
                                <th>Сложность</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach($tasks as $task){ ?>
                            <tr>
                                <th><?= $i ;?></th>
                                <td><a href="<?= Url::toRoute(['main/task', 'id' => $task->id]);?>"><?= $task->name;?></a></a></td>
                                <td><a href="<?= Url::toRoute(['main/tasks', 'category_id' => $task->category->id]);?>"><?= $task->category->name;?></a></td>
                                <td>
                                    <?php for($j = 0; $j<$task->num; $j++){ ?>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <a class="main_button" href="<?= Url::toRoute(['main/tasks']);?>"><i class="fa fa-code" aria-hidden="true"></i> Все задачи</a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="new_competisions">
            <div class="col-md-12">
            <h2>Предстоящие соревнования</h2>
            <?php if($competitions){?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th></th>
                                <th>Дата начала</th>
                                <th>Дата окончания</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($competitions as $comp){?>
                            <tr>
                                <th><?=$i;?></th>
                                <td><a href="<?= Url::toRoute(['main/competition', 'id' => $comp->id]);?>"><?=$comp->name;?></a></td>
                                
                                <td>
                                    <?php if(in_array($comp->id, $get_part)) {?>
                                    <a href="<?= Url::toRoute(['main/competition', 'id' => $comp->id]);?>" class="btn btn-warning">Продолжить соревнование</a>
                                    <?php } else { ?>
                                    <a href="<?= Url::toRoute(['main/competition', 'id' => $comp->id]);?> " class="btn btn-success">Принять участие</a>
                                    <?php } ?>
                                </td>
                                
                                <td>
                                    <?=date('H:i d-m-Y', $comp->time_start);?>
                                </td>
                                <td><?=date('H:i d-m-Y', $comp->time_end);?></td>
                                <td><?php if($comp->start){
                                    echo '<span class="label label-primary">Идет соревнование</span>';
                                } else echo '<span class="label label-warning">Еще не началось</span>';?></td>
                            </tr>
                            <?php $i++;}?>
                        </tbody>
                    </table>
                </div>
                <a class="main_button" href="<?=Url::toRoute(['main/competitions']);?>"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Все соревнования</a>
            <?php } else {?>
            <div class="alert alert-danger" role="alert">Предстоящих соревнований пока что нету</div>
            <?php }?>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="new_competisions">
            <div class="col-md-12">
            <h2>Лучшие участники</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Место</th>
                                <th>Пользователь</th>
                                <th>ФИО</th>
                                <th>Рейтинг</th>
                                <th>Задачи</th>
                                <th>Местонахождение</th>
                                <th>Университет</th>
                                <th>Группа</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; foreach($users as $user){ ?>
                            <tr>
                                <th><?= $i ;?></th>
                                <td><a href="#"><?= $user->username ;?></a></td>
                                <td><?=$user->name;?></td>
                                <td><?= $user->raiting;?></td>
                                <td><?= $user->tasks_solved ;?></td>
                                <td><?= $user->country;?></td>
                                <td><?= $user->university;?></td>
                                <td><?= $user->group;?></td>
                            </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <a class="main_button" href="<?= Url::toRoute(['main/raiting']);?>"><i class="fa fa-trophy" aria-hidden="true"></i> Рейтинг</a>
            </div>
        </div>
    </div>
</div>
