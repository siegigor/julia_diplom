<?php 
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

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
                    <a class="task_block_link" href="<?= Url::toRoute(['main/task', 'id' => $task->id]) ;?>">
                    <div class="task_block">
                        <p class="tb_title"><?= $task->name;?></p>
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