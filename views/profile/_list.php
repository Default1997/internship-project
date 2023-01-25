<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
 
<div class="item">
    <?= Html::encode($model->date) ?>   
    <?= Html::encode($model->request_method) ?>  
    <?= Html::encode($model->api_method) ?>  
    <?= Html::encode($model->params) ?>  
</div>