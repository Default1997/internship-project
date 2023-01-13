<?php
 
namespace app\models;
 
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\filters\RateLimitInterface;
use yii\web\TooManyRequestsHttpException;
use yii\web\Response;
use yii\db\Expression;
 
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */

 /**
 * @OA\Info(
 *     title="User model info test",
 *     version="0.2"
 * )
 */

class User extends ActiveRecord implements IdentityInterface, RateLimitInterface
{
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
    // public function behaviors()
    // {
    //     return [
    //         TimestampBehavior::className(),
    //     ];
    // }
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // ['status', 'default', 'value' => self::STATUS_ACTIVE],
            // ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }
 
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
 
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
        // throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
 
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        // return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
        return static::find()->where('BINARY [[username]]=:username', ['username' => $username])->one();
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
        return Yii::$app->security->validatePassword($password, $this->password);
    }
 
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
 
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @OA\Get(
     *     path="/api/data.json",
     *     @OA\Response(
     *         response="200",
     *         description="get ratelimit info"
     *     )
     * )
     */
    public function getRateLimit($request, $action)
    {   
        $count = $this->subscription->requests_count;
        return [$count, 24*3600]; //$count запросов можно отправить за сутки (в секундах)
    }

    /**
     * @OA\OpenApi(
     *   @OA\ExternalDocumentation(
     *     description="Из этого тестового описания вы узнаете о ссылке, которая решит вашу проблемму",
     *     url="https://yandex.ru"
     *   )
     * )
     */
    public function loadAllowance($request, $action)
    {
        $cache = Yii::$app->cache;

        
        $data = $cache->get('allowance'.$this->id);
        if ($data === false) {
           
            $cache->set('allowance'.$this->id, $this->subscription->requests_count, date_create('tomorrow')->getTimestamp() - time());//сколько всего запросов разрешено
            $cache->set('time'.$this->id, $this->limitSpending->updated_at, date_create('tomorrow')->getTimestamp() - time());//записать в кеш время последнего запроса, время жизни кеша до конца дня
            $this->limitSpending->updateAttributes(['count' => 0]);//если кеш пустой то значит начался новый день и нужно обнулить доступы
        }

        $allowance = $cache->get('allowance'.$this->id);
        $time = $cache->get('time'.$this->id);

        // if ($allowance == 1) {
        //     throw new TooManyRequestsHttpException('Лимиты кончились');
        // }

        Yii::$app->session->setFlash('success', 'Осталось запросов: '. $allowance. 'Использовано запросов: '. $this->limitSpending->count);
        return [$allowance, $time];//количество запросов в тарифе - количество уже потраченых запросов
    }

    /**
     * @OA\Get(
     *     path="/api/data1.json",
     *     @OA\Response(
     *         response="200",
     *         description="еще что то до кучи"
     *     )
     * )
     */

    public function saveAllowance($request, $action, $allowance, $timestamp)
    {           
       

        $this->limitSpending->updateCounters(['count' => 1]);//записать в БД что запрос израсходован
        $this->limitSpending->updateAttributes(['updated_at' => new Expression('NOW()')]);

        $cache = Yii::$app->cache;
        $cache->set('allowance'.$this->id, $allowance, date_create('tomorrow')->getTimestamp() - time());
        $cache->set('time'.$this->id, $timestamp, date_create('tomorrow')->getTimestamp() - time());
        
        if ($allowance == 0) {
            throw new TooManyRequestsHttpException('Лимиты кончились');
        }
        //потом здесь же нужно будет сохранить в БД что именно это был за запрос

    }

    public function getSubscription() 
    {
        return $this->hasOne(Subscription::class, ['code' => 'subscription_code']);
    }

    public function getLimitSpending() 
    {
        return $this->hasOne(LimitSpending::class, ['user_id' => 'id']);
    }
}