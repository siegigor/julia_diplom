<?php
    use yii\helpers\Url;
    use yii\widgets\LinkPager;
    use yii\widgets\Pjax;
?>
<div class="container raiting_page">
    <div class="row">
    <div class="col-md-12">
        <h2>Предстоящие соревнования</h2>
        <a href="<?= Url::toRoute(['main/newcompetition']);?>" class="tb_button">Создать соревнование</a>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Название</th>
                            <th></th>
                            <th>Дата начала</th>
                            <th>Дата окончания</th>
                            <th></th>
                            <th>Статус</th>
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
                                <?php if(in_array($comp->id, $get_part)) {?>
                                <a href="<?= Url::toRoute(['main/competition', 'id' => $comp->id]);?>" class="btn btn-warning">Продолжить соревнование</a>
                                <?php } else { ?>
                                <a href="<?= Url::toRoute(['main/competition', 'id' => $comp->id]);?> " class="btn btn-success">Принять участие</a>
                                <?php } ?>
                            </td>
                            <td>
                                <?= date('H:i (d.m.Y)', $comp->time_start);?>
                            </td>
                            <td><?= date('H:i (d.m.Y)', $comp->time_end);?></td>
                            <td><a href="<?=Url::toRoute(['main/board', 'comp_id'=>$comp->id]);?>" class="btn btn-primary">Рейтинг</a></td>
                            <td><?php if($comp->start){
                                    echo '<span class="label label-primary">Идет соревнование</span>';
                                } else echo '<span class="label label-warning">Еще не началось</span>';?>
                            </td>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php Pjax::begin(['id'=>'competitions_pjax', 'timeout'=>5000]);?>
<div class="container raiting_page">    
    <div class="row">
    <div class="col-md-12">
        <h2>Завершенные соревнования</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Название</th>
                            <th>Дата начала</th>
                            <th>Дата окончания</th>
                            <th></th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1 + ($page ? 5*($page-1) : 0); foreach($old_competitions as $comp){ ?>
                        <tr>
                            <th><?= $i ;?></th>
                            <td><?= $comp->name ;?>
                            </td>
                            <td>
                                <?= date('H:i (d.m.Y)', $comp->time_start);?>
                            </td>
                            <td><?= date('H:i (d.m.Y)', $comp->time_end);?></td>
                            <td><a href="<?=Url::toRoute(['main/board', 'comp_id'=>$comp->id]);?>" class="btn btn-primary">Рейтинг</a></td>
                            <td>
                                <span class="label label-danger">Cоревнование завершено</span>
                                
                            </td>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
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
    
</div>
<?php Pjax::end();?>