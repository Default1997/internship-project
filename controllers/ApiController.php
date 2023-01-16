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

}
