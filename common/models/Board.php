<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "board".
 *
 * @property integer $id
 * @property integer $competition_id
 * @property integer $user_id
 * @property integer $tasks
 * @property integer $score
 *
 * @property Competition $competition
 * @property User $user
 */
class Board extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['competition_id', 'user_id'], 'required'],
            [['competition_id', 'user_id', 'tasks', 'score'], 'integer'],
            [['competition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competition::className(), 'targetAttribute' => ['competition_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'competition_id' => 'Competition ID',
            'user_id' => 'User ID',
            'tasks' => 'Tasks',
            'score' => 'Score',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetition()
    {
        return $this->hasOne(Competition::className(), ['id' => 'competition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public static function UserToCompetition($competition_id)
    {
        $user_id = Yii::$app->user->identity->id;
        $compuser=self::find()->where(['user_id' => $user_id, 'competition_id' => $competition_id])->one();
        if(!isset($compuser->id))
        {
            $compuser = new self();
            $compuser->user_id = $user_id;
            $compuser->competition_id = $competition_id;
            $compuser->tasks = 0;
            $compuser->score = 0; 
            $compuser->save();
        }
        
        return true;
    }
    
    public static function getBoard($comp_id)
    {
        return self::find()->where(['competition_id' => $comp_id])->orderBy('score DESC')->all();
    } 
    
    public static function getUserCompetition($comps)
    {   $ids=[];
        foreach($comps as $comp)
        {
            $ids[]=$comp->id;
        }
        return self::find()
        ->select('competition_id')
        ->where(['user_id' => Yii::$app->user->identity->id, 'competition_id'=>$ids])
        //->indexBy('competition_id')
        //->column();
        ->asArray()->column();
    }
}
