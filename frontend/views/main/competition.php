<?php
    use yii\helpers\Url;
    
?>
<div class="container raiting_page">
    <div class="row">
    <div class="col-md-12">
        <h2><?= $competition->name;?></h2>
                <a href="<?= Url::toRoute(['main/board', 'comp_id' => $competition->id]);?>" class="tb_button">Посмотреть результаты</a>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Задача</th>
                            <th>Решено</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; foreach($comp_tasks as $task){ 
                    $solved=false; $error=false;    
                    ?>
                        <tr>
                            <th><?= $i ;?></th>
                            <td><a href="<?= Url::toRoute(['main/task', 'id' => $task->id, 'cid' => $competition->id]);?>"><?= $task->name ;?></a></td>
                            <td>
                            <?php foreach($solved_tasks as $sol){ ?>
                            <?php if($sol->task_id == $task->id && $sol->solved == 1) {
                                echo "Решено"; 
                                $solved = true;
                                break;
                             }
                             if($sol->task_id == $task->id && $sol->error)
                                $error = true;
                             }
                             if($error && !$solved) echo "Ошибка при решении"; 
                             if(!$solved && !$error) echo "Не решено";
                              ?>
                            </td>

                        </tr>
                    <?php $i++;} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>