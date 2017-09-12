<?php
    
?>
<div class="container raiting_page">
    <div class="row">
    <div class="col-md-12">
        <h2>Рейтинг участников</h2>
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
                            <td><?=$user->university;?></td>
                            <td><?=$user->group;?></td>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>