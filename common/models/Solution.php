<?php

namespace common\models;

use Yii;
use common\models\User;

class Solution extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'solution';
    }

    public function rules()
    {
        return [
            [['user_id', 'task_id', 'solved', 'competition_id'], 'integer'],
            [['code', 'lang', 'solved'], 'required'],
            [['code', 'test_result', 'error'], 'string'],
            [['lang'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Решение №',
            'user_id' => 'Пользователь',
            'task_id' => 'Задача',
            'code' => 'Код задачи',
            'lang' => 'Язык',
            'test_result' => 'Результат тестов',
            'error' => 'Текст ошибки',
            'solved' => 'Решено',
            'competition_id' => 'Из соревнования',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getCompetitions()
    {
        return $this->hasOne(Competition::className(), ['id' => 'competition_id']);
    }


    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
    
    public function newSolution($user_id, $task_id, $solved, $cid, $error = false)
    {
        $this->user_id = $user_id;
        $this->task_id = $task_id;
        if($cid)
            $this->competition_id = $cid;
        if($error)
            $this->error = $error;
        $this->solved = $solved;        
    }
    
    public static function getUserSolution($id)
    {
        return self::find()->where(['user_id' => $id])->orderBy('id DESC')->all();
    }
    
    public function checkAndSave($task, $error, $success, $cid)
    {
        $user_id=Yii::$app->user->identity->id;
        if($success == count($task->test))
        {
            if(!$cid)
                User::resolveTask($task->num, $user_id, $task->id);
            else 
                User::resolveTaskComp($task->num, $user_id, $task_id, $cid);
            
            $this->newSolution($user_id, $task->id, 1, $cid);
            $isSolved = 1;
        }    
        else
            $this->newSolution($user_id, $task->id, 0, $cid, $error);
            
        $this->save();
        
        return $isSolved;
    }

    public static function solvedFromCompetition($comp_id)
    {
        return self::find()->where(['competition_id' => $comp_id, 'user_id' => Yii::$app->user->identity->id])->all();
    }
    
    public static function isTaskSolved($task_id)
    {
        return self::find()->select(['id', 'code', 'solved'])->where(['user_id' => Yii::$app->user->identity->id, 'task_id' => $task_id, 'solved' => 1])->orderBy('id DESC')->limit(1)->one();
    }
    
     public static function isTaskError($task_id)
     {
        return self::find()->select(['id', 'code', 'error'])->where(['user_id' => Yii::$app->user->identity->id, 'task_id' => $task_id])->andWhere(['or',['!=', 'error', ''],['solved' => 0]])->orderBy('id DESC')->limit(1)->one();
     }
     public static function getUserSolutions($tasks)
     {
        $ids=[];
        foreach($tasks as $task)
        {
            $ids[]=$task->id;
        }
        $user_id=Yii::$app->user->identity->id;
        return self::find()->select(['task_id'])->where(['user_id'=>$user_id, 'task_id'=>$ids, 'solved'=>1])->indexBy('task_id')->column();
     }
}

