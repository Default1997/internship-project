<?php
 
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
 
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
        ],
    ]) ?>
 
</div>


<!-- $model->identity->username
$model->identity->gender
$model->identity->updated_at -->

