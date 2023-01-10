<?php

namespace app\models;
 
use yii\base\Model;
use yii\db\ActiveQuery;
use Yii;
 
class ProfileUpdateForm extends Model
{
    public $username;
    public $gender;
    public $password;
    public $new_password;
 
    /**
     * @var User
     */
    private $_user;
 
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        $this->username = $user->username;
        $this->gender = $user->gender;
        $this->password = $user->password;
        parent::__construct($config);
    }
 
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            // ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот логин уже занят.'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'Такое имя поользователя уже существует'),'filter' => ['<>', 'id', $this->_user->id]],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'match', 'pattern' => '/^[a-z0-9]+$/i',  'message' => 'Используйте только латинские буквы и цифры.'],
            ['password', 'required'],
            ['gender', 'required'],
            ['password', 'string', 'min' => 6],
            ['new_password', 'string', 'min' => 6],
        ];
    }
 
    public function update()
    {   
        $user = $this->_user;
        // print_r(Yii::$app->security->generatePasswordHash($this->password));die;
        if (Yii::$app->security->validatePassword($this->password, $user->password)) {
            $user->username = $this->username;
            if ($this->new_password != NULL) {
                $user->setPassword($this->new_password);
            }else{
                $user->setPassword($this->password);
            }
            
            $user->gender = $this->gender;

            Yii::$app->session->setFlash('success', "Изменения сохранены");
            return $user->save();
        } else {
            Yii::$app->session->setFlash('error', 'Неверный пароль');
            return false;
        }
    }
}