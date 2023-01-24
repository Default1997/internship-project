<?php

namespace app\controllers;


use yii\filters\RateLimiter;
use app\models\Cat;
use yii\filters\auth\HttpBearerAuth;

class ApiController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'rateLimiter' => [
                'class' => RateLimiter::className(),
            ],
            // $behaviors['authenticator'] = [
            //     'class' => HttpBearerAuth::class,
            // ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest()
    {
        return 'Ура, ты получил ответ. Hello World!';
    }

    public function actionTest2($param)
    {
        return 'Ответ с параметром: '.$param;
    }

    public function actionCreatecat()
    {
        $cat = new Cat();
        $cat->create($cat);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $cat;
    }
    /**
     * @OA\Get(
     *     path="/api/updateCat.json",
     *     @OA\Response(
     *         response="200",
     *         description="Update cat"
     *     )
     * )
     */
    public function actionUpdatecat($id, $gender, $mustache, $feet, $tail)
    {
        $cat = new Cat();
        $cat->updateCat($cat, $id, $gender, $mustache, $feet, $tail);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $cat;
    }

    public function actionDeletecat($id)
    {
        $cat = new Cat();
        $cat->deleteCat($cat, $id);
    }

    public function actionCastratecat($id)
    {
        $cat = new Cat();
        $cat->Castrate($cat, $id);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $cat;
    }

}
