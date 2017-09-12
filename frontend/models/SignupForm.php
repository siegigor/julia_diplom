<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $name;
    public $university;
    public $group;
    public $country;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username', 'name', 'university', 'group', 'country'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким логином уже существует'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['name', 'university', 'group', 'country'], 'string', 'min'=>'3', 'max'=>'25'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким email уже существует'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->name = $this->name;
        $user->university = $this->university;
        $user->group = $this->group;
        $user->country = $this->country;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'country' => 'Страна',
            'group'=>'Группа',
            'name'=>'ФИО',
            'university'=>'Университет',
        ];
    }
}
