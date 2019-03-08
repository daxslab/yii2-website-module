<?php

use yii\helpers\Html;
use yii\bootstrap4\Carousel;
?>

<?= Carousel::widget([
    'items' => array_map(function($model){
        return [
            'content' => Html::img($model->image, ['alt' => Html::encode($model->title)]),
            'caption' => Html::tag('h2', Html::encode($model->title))
        ];
    }, $dataProvider->allModels)
])?>
