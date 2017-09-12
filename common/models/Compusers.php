<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "compusers".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $competition_id
 *
 * @property User $user
 * @property Competition $competition
 */
class Compusers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'compusers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'competition_id'], 'required'],
            [['user_id', 'competition_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['competition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competition::className(), 'targetAttribute' => ['competition_id' => 'id']],
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
            'competition_id' => 'Competition ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetition()
    {
        return $this->hasOne(Competition::className(), ['id' => 'competition_id']);
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
            $compuser->save();
        }
        
        return true;
    }
}
