<?php

namespace common\models;

use Yii;
use common\models\Task;
use common\models\User;
use common\models\Board;

class Competition extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'competition';
    }

    public $hasThisUser;
    public $start;

    public function rules()
    {
        return [
            [['task_ids', 'time_start', 'time_end', 'user_id'], 'required'],
            [['user_id', 'checked'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['task_ids', 'time_start', 'time_end'], 'safe'],
        ];
    }
    public function afterFind()
    {
      
        if($this->time_start > date('U'))
            $this->start = 0;
        else
            $this->start = 1;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'task_ids' => 'Задачи',
            'time_start' => 'Время начала соревнования',
            'time_end' => 'Время окончания соревнования',
            'user_id' => 'Создатель',
            'checked' => 'Прошел модерацию',
        ];
    }


    public function getBoards()
    {
        return $this->hasMany(Board::className(), ['competition_id' => 'id']);
    }
    
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getSolutions()
    {
        return $this->hasMany(Solution::className(), ['competition_id' => 'id']);
    }
    
    public static function getCompetitions()
    {
        return self::find()->where([">", 'time_end', date('U')])->andWhere(['checked' => 1])->all();
    }
    
    public static function getNewCompetitions()
    {
        return self::find()->where([">", 'time_end', date('U')])->andWhere(['checked' => 1])->orderBy('id DESC')->limit(5)->all();
    }
    
    public static function getIdsCompetitions()
    {
        return self::find()->select(['id'])->where([">", 'time_end', date('U')])->andWhere(['checked' => 1])->column();
    }
    
    public static function getCompetition($id)
    {
        return self::find()->where(['id' => $id])->limit(1)->one();
    }
    
    public static function getCompTasks($comp_id)
    {
        $tasks = self::find()->select(['task_ids'])->where(['id' => $comp_id])->limit(1)->one();
        $ids = explode(", ", $tasks->task_ids);
        return Task::find()->where(['id' => $ids])->all();
    }
    
    public static function checkCompetition($id)
    {
        $competition = self::findOne($id);
        $competition->checked = 1;
        $competition->save();
    }

    
    public function saveAdmin($user_id = false)
    {
        $this->user_id = $user_id;
        $this->checked = 1;
        $this->task_ids = implode(", ", $this->task_ids);
        $this->time_start = strtotime($this->time_start);
        $this->time_end = strtotime($this->time_end); 
        return $this->save();
    }
    
    public static function getCompetitionByUser($user_id)
    {
        return self::find()
        ->leftJoin('board', '`board`.`competition_id` = `competition`.`id`')
        ->with('boards')
        ->where(['board.user_id' => $user_id])
        ->all();
    }
    
    
}
