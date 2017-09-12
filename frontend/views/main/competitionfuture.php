<?php
    use yii\helpers\Url;
    $this->title = "соревнование '$competition->name'";
?>
<div class="container raiting_page">
    <div class="row">
    <div class="col-md-12">
        <h2>Спасибо, что захотели принять участие в соревновании "<?=$competition->name;?>"!</h2>
        <div class="alert alert-info" role="alert">
            <?php
                $time=$competition->time_start - date('U');
                $hours = floor($time / 3600);
                $days = floor($hours/24);
                $hours=$hours-24*$days;
                $minutes = floor(($time % 3600)/60);
                $seconds = ceil(($time % 3600) % 60);
            ?>
            <?php if($time>0){?>
            <span class="sapantimerbutt">
                <h2>
                    До начала: 
                    <span id="timertest">
                        <?=$days.' д. '.$hours.':'.$minutes.':'.$seconds;?>
                    </span>
                </h2>
            </span>
            <?php }?>  
        </div>
        </div>
    </div>
</div>