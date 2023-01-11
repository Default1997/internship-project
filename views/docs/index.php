<?php

use app\assets\SwaggerUiAsset;

/** @var $this \yii\web\View */
/** @var $url string */

SwaggerUiAsset::register($this);
?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title>Swagger UI</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="swagger-ui"></div>

<script>
    window.onload = function () {
        window.ui = SwaggerUIBundle({
            url: '<?= $url; ?>',
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: "StandaloneLayout"
        });
    }
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>