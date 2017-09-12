<?php
    use yii\helpers\Url;
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
                                <?php if($comp->boards) {?>
                                <a href="<?= Url::toRoute(['main/competition', 'id' => $comp->id]);?>" class="btn btn-warning">Продолжить соревнование</a>
                                <?php } else { ?>
                                <a href="<?= Url::toRoute(['main/competition', 'id' => $comp->id]);?> " class="btn btn-success">Принять участие</a>
                                <?php } ?>
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