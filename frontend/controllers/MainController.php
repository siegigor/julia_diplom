<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use common\models\Task;
use common\models\Category;
use common\models\Solution;
use common\models\User;
use common\models\Competition;
use common\models\Board;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use frontend\models\CheckApi;

class MainController extends \yii\web\Controller
{
    public $layout = 'diplom';
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['task'],
                'rules' => [
                    [
                        'actions' => ['task'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $users = User::getShortRaiting();
        $tasks = Task::getNewTasks();
        $competitions = Competition::getNewCompetitions();
        return $this->render('index', [
            'users' => $users,
            'tasks' => $tasks,
            'competitions' => $competitions,
        ]);

    }
    
    public function actionTasks($category = false)
    {
        
        if($category)
        {
            $tasks_pag = Task::getTaskByCategory($category);
            $tasks = $tasks_pag['tasks'];
            $pagination = $tasks_pag['pagination'];
        }
        else
        {
            $tasks_pag = Task::getAll();
            $tasks = $tasks_pag['tasks'];
            $pagination = $tasks_pag['pagination'];
        }
            
        $categories = Category::getAll();
        return $this->render('tasks', [
            'tasks' => $tasks,
            'categories' => $categories,
            'category' => $category,
            'pagination' => $pagination,
        ]);
    }

    public function actionTask($id, $cid = false)
    {
        $task = Task::getTask($id);
        if(!$task)
            throw new BadRequestHttpException('Задача не найдена. Возможно она была удалена');
            
        $solution = new Solution();
        $solution->code=$task->sovedCode ? $task->sovedCode : '';
        
        if ($solution->load(Yii::$app->request->post())) 
        {   
            $checkapi = new CheckApi();
            $result=$checkapi->getResult($task->test, $solution);
             
            $error = $result[0]['compile_status'];

            $success=$checkapi->getSuccessCount($task->test);
            
            $isSolved = $solution->checkAndSave($task, $error, $success, $cid);
        }
        
        if(User::isHasRez(Yii::$app->user->identity->id, $task->id) === true)
            $close_task = 1;
        
        return $this->render('task',[
            'task' => $task,
            'solution' => $solution,
            'result' => $result,
            'isSolved' => $isSolved,
            'error' => $error,
            'close_task' => $cid ? false : $close_task,
        ]);
    }
    

    
    public function actionProfile($edit = false)
    {
        
        if (Yii::$app->user->isGuest) 
        {
            $this->redirect(['/site/login']);
        }
         else
         {
            $user=User::findByUsername(Yii::$app->user->identity->username);
            $solutions = Solution::getUserSolution(Yii::$app->user->identity->id);
            $competitions = Board::getUserCompetition();
            if ($user->load(Yii::$app->request->post()) && $user->validate()) 
            {
                $user->save();   
                $edit=0;
            }
            /*echo "<pre>";
            print_r($competitions);
            echo "</pre>";*/
            return $this->render('profile', [
                'user' => $user,
                'edit' => $edit,
                'solutions' => $solutions,
                'competitions' => $competitions,
            ]);
        }
    }
    
    public function actionRaiting()
    {
        $users = User::getRaiting();
        
        return $this->render('raiting', [
                'users' => $users,
            ]);
    }
    
    public function actionCompetitions()
    {
        $competitions = Competition::getCompetitions();
        $get_part = Board::getUserCompetition();
        
        return $this->render('competitions', [
                'competitions' => $competitions,
                'get_part' => $get_part,
            ]);
    }
    
    public function actionCompetition($id)
    {
        $competition = Competition::getCompetition($id);
        $comp_tasks = Competition::getCompTasks($id);
        Board::UserToCompetition($id);
        $solved_tasks = Solution::solvedFromCompetition($id);

        return $this->render('competition', [
                'competition' => $competition,
                'comp_tasks' => $comp_tasks,
                'solved_tasks' => $solved_tasks,
            ]);
    }
    
    public function actionBoard($comp_id)
    {
        $board = Board::getBoard($comp_id);
        
        return $this->render('board', [
            'board' => $board,
            ]);
    }
    
    public function actionNewcompetition()
    {
        $competition = new Competition();
        
        if ($competition->load(Yii::$app->request->post())) 
        {
            $competition->task_ids = implode(", ", $competition->task_ids);
            $competition->time_start = strtotime($competition->time_start);
            $competition->time_end = strtotime($competition->time_end); 
            $competition->user_id = Yii::$app->user->identity->id;
            //Board::UserToCompetition()
            
            if($competition->save())
            {        
                $thanks = "Ваше соревнования было успешно создано. Оно появиться на сайте после модерации.";
                $competition = new Competition();
            }
        }
        
        return $this->render('newcompetition', [
                'competition' => $competition,
                'thanks' => $thanks,
            ]);
    }
    
    public function actionEditcompetition($id)
    {
        $competition = Competition::findOne($id);
        $competition->task_ids = explode(", ", $competition->task_ids);
        $competition->time_start = date('Y-m-d\TH:i', $competition->time_start);
        $competition->time_end = date('Y-m-d\TH:i',  $competition->time_end);
        
        if ($competition->load(Yii::$app->request->post())) 
        {
            $competition->task_ids = implode(", ", $competition->task_ids);
            $competition->time_start = strtotime($competition->time_start);
            $competition->time_end = strtotime($competition->time_end); 
            $competition->user_id = Yii::$app->user->identity->id;
            if($competition->save())
            {        
                $thanks = "Ваше соревнования было успешно отредактированно.";
                return $this->redirect('competitions');
            }
        }
        
        return $this->render('newcompetition', [
                'competition' => $competition,
                'thanks' => $thanks,
            ]);
    }
}
