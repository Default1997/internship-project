<?php
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
 
/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
 
$this->title = 'Редактировать профиль';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Профиль'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-update">
 
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Чтобы внести изменения введите пароль и нажмите на кнопку Cохранить</p>
 
    <div class="user-form">
 
    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'gender')->radioList(['Male' => 'Мужской', 'Female' => 'Женский'])?>
                <?= $form->field($model, 'password')->passwordInput(['value' => '']) ?>
                <?= $form->field($model, 'new_password')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
 
    </div>
 
</div>