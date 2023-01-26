<?php

namespace app\controllers;
 
use app\models\User;
use app\models\LimitSpending;
use app\models\QuotaUtilization;
use app\models\ProfileUpdateForm;
use app\models\QuotaUtilizationSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use OpenApi\Annotations as OA;
use Yii;
use yii\data\ActiveDataProvider;

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
 
    public function actionIndex($days = 30)
    {
        // print_r($this->findModel());die;
        $model = $this->findModel();
        $searchModel = new QuotaUtilizationSearch;

        // $dataProvider = new ActiveDataProvider([
        //     'query' => QuotaUtilization::find()->where(['user_id' => \Yii::$app->user->identity->id])->orderBy(['date' => SORT_DESC]),
        //     'pagination' => [
        //         'pageSize' => 10,
        //         ],
        // ]);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'model' => $this->findModel(),
            'limitSpending' => LimitSpending::find()->where(['user_id' => \Yii::$app->user->identity->id])->limit($days)->orderBy(['date_update' => SORT_DESC])->all(),
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
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