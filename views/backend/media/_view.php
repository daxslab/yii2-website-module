<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

$imageToDisplay = $model->isImage ? Yii::$app->thumbnailer->get($model->url, 300, 300) : $model->prettyIcon;
?>

<div class="card mb-4">
    <h2 class="card-header d-none"><?= StringHelper::truncate(Html::encode($model->filename), 15) ?></h2>
    <?= Html::img($imageToDisplay, ['alt' => $model->filename, 'class' => 'img-fluid']) ?>
    <div class="btn-group d-flex" role="group" aria-label="...">
        <?= Html::a(Yii::t('website','Delete'), \daxslab\website\components\Lookup::getLink($model, 'delete'), [
            'class' => 'btn btn-danger w-100',
            'data-method' => 'post',
            'data-confirm' => Yii::t('website','Are you sure you want to delete this item?'),
        ]) ?>
    </div>
    <div class="card-footer">
        <?= Html::a(Yii::t('website', 'Link'), $model->url) ?>, 
        <?= Yii::$app->formatter->asShortSize($model->size, 2) ?>
    </div>
</div>
