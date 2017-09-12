<?php

namespace common\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $num
 * @property integer $category_id
 * @property integer $test_id
 *
 * @property Solution[] $solutions
 * @property Category $category
 * @property Test $test
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolutions()
    {
        return $this->hasMany(Solution::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasMany(Test::className(), ['task_id' => 'id']);
    }
    
    public static function getAll()
    {
        $query = self::find();
        
        $countQuery = clone $query;
        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 9,
        ]);
        
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
    
    public static function getTaskByCategory($category)
    {
        $query = self::find()->where(['category_id' => $category]);
         
        $countQuery = clone $query;
        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 9,
        ]);
        
        $tasks = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        
        return ['tasks' => $tasks, 'pagination' => $pagination];
    }
}
