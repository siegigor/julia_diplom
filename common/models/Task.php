<?php

namespace common\models;

use Yii;
use yii\data\Pagination;
use common\models\Solution;

class Task extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'task';
    }

    public $solvedTask;
    public $sovedCode;
    public $solvedError;
    
    public function rules()
    {
        return [
            [['name', 'text', 'num'], 'required'],
            [['text', 'input_desc', 'output_desc', 'input1', 'output1'], 'string'],
            [['num', 'category_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'text' => 'Текст',
            'num' => 'Количество баллов',
            'category_id' => 'Категория',
            'input_desc' => 'Входные данные',
            'output_desc' => 'Выходные данные',
            'input1' => 'Входные данные #1',
            'output1' => 'Выходные данные #1',
        ];
    }
    /*public function afterFind()
    {
        if(!Yii::$app->user->isGuest)
        {
            $solution = Solution::isTaskSolved($this->id);
            if(isset($solution->id))
            {
                $this->solvedTask = 1;
                $this->sovedCode = $solution->code;
            }
            else
            {
                $error = Solution::isTaskError($this->id);
                $this->solvedError = isset($error->id) ? 1 : 0;
                $this->sovedCode = $error->code;
            }
        }
    }*/

    public function getSolutions()
    {
        return $this->hasMany(Solution::className(), ['task_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getTest()
    {
        return $this->hasMany(Test::className(), ['task_id' => 'id']);
    }
    
    public static function getAll($category=false)
    {
        $query = self::find();
        
        $countQuery = clone $query;
        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 9,
        ]);
        if($category)
        {
            $query->where(['category_id' => $category]);
        }
        $tasks = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        
        return ['tasks' => $tasks, 'pagination' => $pagination];
    }
    
    public static function getTask($id)
    {
        return self::find()->where(['id' => $id])->one();
    }
    
    public static function getNewTasks()
    {
        return self::find()->orderBy('id DESC')->limit(5)->all();
    }
    public function findSolution()
    {
        if(!Yii::$app->user->isGuest)
        {
            $solution = Solution::isTaskSolved($this->id);
            if(isset($solution->id))
            {
                $this->solvedTask = 1;
                $this->sovedCode = $solution->code;
            }
            else
            {
                $error = Solution::isTaskError($this->id);
                $this->solvedError = isset($error->id) ? 1 : 0;
                $this->sovedCode = $error->code;
            }
        }
    }
}
