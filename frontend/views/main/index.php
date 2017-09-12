<?php
    use yii\helpers\Url;
?>


<div class="container main_content">
    <div class="row">
    
    <div class="alert alert-warning" role="alert">
    <h2>Добро пожаловать! тест</h2>
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
                        <?php $i++; foreach($tasks as $task){ ?>
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
                <a class="main_button" href="<?= Url::toRoute(['main/tasks']);?>"><i class="fa fa-puzzle-piece" aria-hidden="true"></i> Все задачи</a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="new_competisions">
            <div class="col-md-12">
            <h2>Предстоящие соревнования</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Дата начала</th>
                                <th>Дата окончания</th>
                                <th>Тип сорованования</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>1</th>
                                <td><a href="#">Решаем простые задачи</a></td>
                                <td>
                                    25.02.2017 14:00 
                                </td>
                                <td>
                                    25.02.2017 18:00
                                </td>
                                <td>Закрытое</td>
                            </tr>
                            <tr>
                                <th>1</th>
                                <td><a href="#">Решаем сложные задачи</a></td>
                                <td>
                                    03.03.2017 14:00
                                </td>
                                <td>04.03.2017 18:00</td>
                                <td>Открытое</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a class="main_button" href="#"><i class="fa fa-tasks" aria-hidden="true"></i> Все соревнования</a>
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
                                <th>Местонахождение</th>
                                <th>Задачи</th>
                                <th>Решения</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; foreach($users as $user){ ?>
                            <tr>
                                <th><?= $i ;?></th>
                                <td><a href="#"><?= $user->username ;?></a></td>
                                <td>
                                    <?= $user->country;?>
                                </td>
                                <td><?= $user->raiting;?></td>
                                <td><?= $user->tasks_solved ;?></td>
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
