<?php

use yii\helpers\Html;

?>

<div class="card">
    <?= Html::img(Yii::$app->thumbnailer->get($model->url, 300, 300), [
        'alt' => $model->filename,
        'class' => 'img-fluid card-img-top',
        'data-url' => $model->url,
        'data-id' => $model->id,
    ])
    ?>
    <footer class="card-footer">
        <p style="font-size: .75em; margin-bottom: 0"><?= $model->filename ?></p>
    </footer>
</div>
