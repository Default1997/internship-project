<?php
 
namespace app\models;
 
use Yii;
use yii\base\Model;
use yii\db\Expression;
use app\models\LimitSpending;
 
/**
 * Signup form
 */
class SignupForm extends \yii\db\ActiveRecord
{
 
    public $username;
    public $password;
    public $gender;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот логин уже занят.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'match', 'pattern' => '/^[a-z0-9]+$/i',  'message' => 'Используйте только латинские буквы и цифры.'],
            ['password', 'required'],
            ['gender', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
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
        $user->gender = $this->gender;
        $user->setPassword($this->password);
        $user->created_at = new Expression('NOW()');
        $user->updated_at = new Expression('NOW()');
        $user->generateAuthKey();
        // if ($user->save()) {
        //     $limitSpending = new LimitSpending();
        //     $limitSpending->user_id = $user->id . '_' . date_create('today')->getTimestamp();
        //     $limitSpending->count = 0;
        //     $limitSpending->updated_at = date_create('today')->getTimestamp();
        //     $limitSpending->save();
        // }
        

        return $user->save() ? $user : null;
    }
}