<?php

namespace common\models;

use Yii;
use common\models\Task;
use common\models\User;
use common\models\Board;
/**
 * This is the model class for table "competition".
 *
 * @property integer $id
 * @property string $task_ids
 * @property string $time_start
 * @property string $time_end
 *
 * @property Board[] $boards
 */
class Competition extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'competition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_ids', 'time_start', 'time_end', 'user_id'], 'required'],
            [['user_id', 'checked'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['task_ids', 'time_start', 'time_end'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
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
    
}
