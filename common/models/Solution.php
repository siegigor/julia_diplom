<?php

namespace common\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "solution".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $task_id
 * @property string $code
 * @property string $lang
 * @property string $test_result
 * @property string $error
 * @property integer $solved
 *
 * @property User $user
 * @property Task $task
 */
class Solution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id', 'solved', 'competition_id'], 'integer'],
            [['code', 'lang', 'solved', 'competition_id'], 'required'],
            [['code', 'test_result', 'error'], 'string'],
            [['lang'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
            'code' => 'Code',
            'lang' => 'Lang',
            'test_result' => 'Test Result',
            'error' => 'Error',
            'solved' => 'Solved',
            'competition_id' => 'Из соревнования',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getCompetitions()
    {
        return $this->hasOne(Competition::className(), ['id' => 'competition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
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
        return self::find()->where(['user_id' => $id])->all();
    }
    
    public function checkAndSave($task, $error, $success, $cid)
    {
        if($success == count($task->test))
        {
            if(!$cid)
                User::resolveTask($task->num, Yii::$app->user->identity->id, $task->id);
            else 
                User::resolveTaskComp($point, $user_id, $task_id, $cid);
            $this->newSolution(Yii::$app->user->identity->id, $task->id, 1, $cid);
            $isSolved = 1;
        }    
        else
            $this->newSolution(Yii::$app->user->identity->id, $task->id, 0, $cid, $error);
            
        $this->save();
        
        return $isSolved;
    }
    
    public static function solvedFromCompetition($comp_id)
    {
        return self::find()->where(['competition_id' => $comp_id, 'user_id' => Yii::$app->user->identity->id])->all();
    }
}
