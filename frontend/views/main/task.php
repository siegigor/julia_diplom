<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
use yii\widgets\Pjax;
?>
<?php Pjax::begin(['id'=>'task_pjax', 'timeout'=>60000, 'scrollTo'=>100]);?>
<div class="container main_content">
    <?php if($result){ ?>
    <div class="row test_res">
        <div class="col-md-12">
        <h1>Результаты проверки задачи "<?= $task->name ;?>"</h1>
        <?php if($error == "OK"){ ?>
            <?php $i=0; foreach($task->test as $test){ ?>
                <ul>
                    <li>
                        Тест №<?=$i+1;?>: 
                        <?php if(trim($result[$i]['run_status']['output']) == trim($test->output)) 
                        {
                            echo 
                            "
                            <div class='alert alert-success' role='alert'> 
                                    <i class='fa fa-check' aria-hidden='true'></i> Засчитано
                            </div>";
                                    
                        }
                        else 
                        {
                            echo 
                            "
                            <div class='alert alert-danger' role='alert'>
                            <i class='fa fa-times' aria-hidden='true'></i> Не засчитано
                            </div>";
                        }
                            
                        ?>
                    </li>
                </ul>
                <?php $i++; } ?>
                <?php if($isSolved!==false) { ?>
                <h3 class="task_solved">Задача решена!</h3>   
                <?php } else {?>
                <h3 class="task_not_solved">Задача не решена!</h3> 
                <p class="task_not_solved_p">Вы можете отправить решение еще раз.</p>
                <?php } ?>
                
            <?php } else { ?>
            <h3 class="task_not_solved">Ошибка!</h3> 
            <p class="task_not_solved_p"><?= $error ;?></p>
            <?php } ?>
        </div>
    </div>
    
    <?php } ?>

    <div class="row one_task">
        <div class="col-md-12">
        <h1><?= $task->name ;?></h1>
            <p><?= $task->text;?></p>

            <p class="ot_title">Входные данные</p>            
            <p><?= $task->input_desc;?></p>
            <p class="ot_title">Выходные данные</p>  
            <p><?= $task->output_desc;?></p>

            <div class="well">
                <div class="row">
                    <div class="col-md-6">
                    <span>Входные данные #1</span> <br />
                    <pre>
<?= trim($task->input1);?>
                    </pre>
                    
                    </div>
                    <div class="col-md-6">
                    <span>Выходные данные #1</span> <br />
                    <pre>
<?= trim($task->output1);?>
                    </pre>
                     
                    </div>
                </div>
            
            </div>
            </div>
        </div>
        
        <div class="row send_solve">
            <div class="col-md-12">
            
            <?php if($close_task){ ?>
                <h3 class="task_solved">Задача решена!</h3>
                <p class="task_not_solved_p">Вы можете отправить задачу еще раз, но она не будет повторно учитываться в рейтинге.</p>
            <?php } ?>
            
                <?php $form = ActiveForm::begin(['id'=>'codesendform','options' => ['data-pjax' => true]]); ?>
                <?= $form->field($solution, 'lang')->dropDownList(['CPP'=>'C/C++', 'JAVA' => 'Java', 'CSHARP' => 'C#'])->label('Выберите язык') ?>
                <?= $form->field($solution, 'code')->widget(
                    'trntv\aceeditor\AceEditor',
                    [
                        'mode'=>'c_cpp', // programing language mode. Default "html"
                        'theme'=>'textmate', // editor theme. Default "github"
                        'containerOptions' => ['style' => 'width: 80%; min-height: 300px; font-size: 14px;'],
                        //'readOnly'=>'true' // Read-only mode on/off = true/false. Default "false"
                    ]
                )->label('Текст программы');?>
                
                <?= Html::submitButton('Отправить' ,['class' => 'solve_button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end();?>