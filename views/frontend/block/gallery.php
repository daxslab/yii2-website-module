<?php
use yii\helpers\Html;
?>

<div class="container-fluid">
    <?= \dosamigos\gallery\Gallery::widget([
        'items' => array_map(function($model){
            return [
                'src' => Yii::$app->thumbnailer->get($model->image, 640, 480),
                'url' => $model->image,
                'options' => ['class' => 'col-md-3 p-0'],
                'imageOptions' => ['class' => 'img-fluid', 'alt' => Html::encode($model->title)],
            ];
        }, $dataProvider->allModels),
        'options' => ['class' => 'row'],
    ])?>
</div>
