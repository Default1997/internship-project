<?php

namespace app\controllers;
use OpenApi\Annotations as OA;
use yii\helpers\Url;
use Yii;
use yii\filters\auth\HttpBearerAuth;

/**
 * @OA\Info(
 *     title="My Second API",
 *     version="0.2"
 * )
 */


class DocsController extends \yii\web\Controller
{

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render('index', ['url' => Url::to(['data'])]);
    }


    public function actionData()
    {
        return $this->asJson(\OpenApi\Generator::scan([
            // Yii::getAlias('@app/controllers/UserController.php'),

            Yii::getAlias('@app/models/User.php'),
        ]));
    }

}
