<?php

namespace app\controllers;
 
use app\models\User;
use app\models\ProfileUpdateForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use OpenApi\Annotations as OA;
use Yii;

/**
 * @OA\Info(
 *     title="My First API",
 *     version="0.1"
 * )
 */
 

class OpenApi {}

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
 
    public function actionIndex()
    {
        // print_r($this->findModel());die;
        $model = $this->findModel();
        
        // print_r($model->subscription->id);die;
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }

    public function actionUpdate()
    {
        $user = $this->findModel();
        $model = new ProfileUpdateForm($user);
    
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Profile.
     *
     * @return Response
     */
    // public function actionProfile()
    // {
    //     $model = Yii::$app->getUser();

    //     return $this->render('profile', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * @OA\Get(
     *     path="/api/data.json",
     *     @OA\Response(
     *         response="200",
     *         description="User model"
     *     )
     * )
     */
 
    /**
     * @return User the loaded model
     */
    private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }
}