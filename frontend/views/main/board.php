<?php
    use yii\helpers\Url;
    $tasks_num = count(explode(', ', $competition->task_ids));
?>
<div class="container raiting_page">
    <div class="row">
    <div class="col-md-12">
        <h2><?= $competition->name;?></h2>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Пользователь</th>
                            <th>Количество решенных задач</th>
                            <th>Сумма баллов</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; foreach($board as $b){ ?>
                        <tr>
                            <th><?= $i ;?></th>
                            <th><?= $b->user->username;?></th>
                            <th><?= $b->tasks;?></th>
                            <th><?= $b->score;?></th>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>