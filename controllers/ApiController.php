<?php

namespace app\controllers;


use yii\filters\RateLimiter;

class ApiController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'rateLimiter' => [
                'class' => RateLimiter::className(),
            ],
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

}
