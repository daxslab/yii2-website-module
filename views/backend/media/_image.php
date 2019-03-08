<?php

use yii\helpers\Html;

?>

<?= Html::img(Yii::$app->thumbnailer->get($model->url, 300, 300), [
    'alt' => $model->filename,
    'class' => 'img-fluid',
    'data-url' => $model->url,
    'data-id' => $model->id,
])
?>
