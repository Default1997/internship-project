<?php
 
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use practically\chartjs\Chart;

use yii\widgets\ListView;

use app\models\LimitSpending;

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
                'value' => $model->subscription_code
            ]
        ],
    ]) ?>
 
</div>

<?php
    //подготовить массив статистики под формат виджета
    $data =array();
    foreach ($limitSpending as $limit) {
        $data[date('d-m-Y', $limit->date_update)]  = $limit->count;
    }
    // array_reverse($data, false);
    // print_r($data);die;

    echo Chart::widget([
        'type' => Chart::TYPE_BAR,
        'clientOptions' => [
            'title' => [
                'display' => true,
                'text' => 'Количество запросов по дням',
            ],
            'legend' => ['display' => false],
        ],
        'datasets' => [
            [
                // 'query' => LimitSpending::find()
                // ->select('count as data')
                // ->addSelect('date_update')
                // ->where(['user_id' => \Yii::$app->user->identity->id])
                // // ->orderBy('date_update SORT_ASC')
                // ->createCommand(),
                // 'labelAttribute' => 'date_update'
                'data' => $data
            ]
        ]
    ]);
?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list',
]);
?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<!-- <script type="text/javascript" src="jscript/graph.js"></script> -->