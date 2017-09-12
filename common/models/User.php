<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\User;
use common\models\Competition;
use common\models\Board;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['raiting', 'tasks_solved'], 'integer'],
            [['country'], 'string', 'max' => 255],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'email' => 'Email',
            'raiting' => 'Рейтинг',
            'lang' => 'Lang',
            'tasks_solved' => 'Количество решенных задач',
            'country' => 'Страна',
        ];
    }
    
    public function getCompetitions()
    {
        return $this->hasMany(Competition::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public static function isHasRez($user_id, $task_id)
    {
        if(isset(Solution::findOne(['user_id' => $user_id, 'task_id' => $task_id, 'solved' => 1])->id))
            return true;
        return false;
    }
    
    public static function isHasRezInComp($user_id, $task_id, $cid)
    {
        if(isset(Solution::findOne(['user_id' => $user_id, 'task_id' => $task_id, 'solved' => 1, 'competition_id'=>$cid])->id))
            return true;
        return false;
    }
    public static function resolveTask($point, $user_id, $task_id)
    {
        if(self::isHasRez($user_id, $task_id)===true)
            return true;

        $user = self::findOne(['id' => $user_id]);
        $user->raiting= $user->raiting+$point;
        $user->tasks_solved=$user->tasks_solved+1;       
        return $user->save()+1;      
    }
    public static function resolveTaskComp($point, $user_id, $task_id, $cid)
    {
        self::resolveTask($point, $user_id, $task_id);
        
        if(self::isHasRezInComp($user_id, $task_id, $cid)===true)
            return true;
        
        $board = Board::findOne(['competition_id' => $cid, 'user_id'=>$user_id]);
        $board->score= $board->score+$point;
        $board->tasks=$board->tasks+1; 
        
        return $board->save();
    }
    
    public static function getRaiting()
    {
        return self::find()->select(['username', 'raiting', 'tasks_solved', 'country'])->orderBy('raiting DESC')->all();
    }
    
    public static function getShortRaiting()
    {
        return self::find()->select(['username', 'raiting', 'tasks_solved', 'country'])->orderBy('raiting DESC')->limit(5)->all();
    }
}