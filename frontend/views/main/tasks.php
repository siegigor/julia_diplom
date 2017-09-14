<?php 
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(['id'=>'tasks_pjax', 'timeout'=>5000]);?>
<div class="container main_content">
    <div class="row">
        <div class="col-md-3">
            <h3>Категории</h3>
            <div class="list-group">
            <a  class="list-group-item <?php if(!$category){echo 'active';} ?>" href="<?= Url::toRoute(['main/tasks']) ;?>">Все задачи</a>
             <?php foreach ($categories as $cat) { ?>
             <a class="list-group-item <?php if($cat->id == $category){echo 'active';} ?>" href="<?= Url::toRoute(['main/tasks', 'category' => $cat->id]) ;?>">
                        <?= $cat->name ;?>
             </a>
                <?php } ?>
            </div>
        </div>
        

        
        <div class="col-md-9">
        <h1>Задачи</h1>
            <div class="row">
            <?php foreach($tasks as $task){ ?>
                <div class="col-md-4">
                    <a data-pjax="0" class="task_block_link" href="<?= Url::toRoute(['main/task', 'id' => $task->id]) ;?>">
                    <div class="task_block">
                        <p data-toggle="tooltip" data-placement="right" title="<?=$task->name;?>" class="tb_title"><?= mb_substr($task->name, 0, 25);?><?php if(mb_strlen($task->name) > 25){?>...<?php } ?></p>
                        <?php if(in_array($task->id, $solutions)){?>
                        <p class="tb_label"><span class="label label-success">Решена</span></p>
                        <?php } else if(in_array($task->id, $error_solutions)) {?>
                        <p class="tb_label"><span class="label label-danger">Ошибка</span></p>
                        <?php } ?>
                        <p class="tb_dif">Сложность </p>
                        <p class="tb_stars">
                            <?php for($i = 0; $i < $task->num; $i++){ ?>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <?php } ?>    
                        </p>
                    </div>
                    </a>
                </div>
            <?php } ?>
            </div>
            
        </div>
        
    <?php if($pagination) {?>
    <nav aria-label="Page navigation" class="catalog_pag">
        <?=LinkPager::widget([
            'pagination'=>$pagination,
            'prevPageLabel'=>'&laquo;',
            'maxButtonCount'=>4,
        ]);?>
    </nav>
    <?php }?>
    </div>
</div>
<?php Pjax::end();?>