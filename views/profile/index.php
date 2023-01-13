<?php
 
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

// use OpenApi\Serializer;
 
/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
 
$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile">
 
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= Html::a('Редактировать', Url::to(['profile/update']), ['class' => 'btn btn-primary'], ['data-method' => 'POST']) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            // 'password',
            [
                'label' => 'Пароль',
                'value'  => 'Пароль скрыт'
            ],
            'gender',
            'auth_key',
            [
                'label' => 'Тариф',
                'value' => $model->subscription_code . ' Использовано запросов: ' . $model->limitSpending->count . ' из(пока что тестовых): ' . $model->subscription->requests_count
            ]
        ],
    ]) ?>
 
</div>

<?php


// print_r($model->getLimitSpending($model->id));die();

    // $serializer = new Serializer();
    // $openapi = $serializer->deserialize($jsonString, 'OpenApi\Annotations\OpenApi');
    // echo $openapi->toJson();

    // require("vendor/autoload.php");
// $openapi = \OpenApi\Generator::scan(['controllers\ProfileController.php']);
// header('Content-Type: application/x-yaml');
// echo $openapi->toYaml();
?>


<!-- $model->identity->username
$model->identity->gender
$model->identity->updated_at -->

