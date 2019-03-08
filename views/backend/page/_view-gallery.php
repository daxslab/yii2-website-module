<?php

use yii\helpers\Html;

$context = $this->context;

$thumbnailer = Yii::$app->thumbnailer;

$image = $model->image
    ? $thumbnailer->get($model->image, 300, 300)
    : $thumbnailer->get(Yii::getAlias('@web/images/default-image.png'), 300, 300);
?>

<div class="card">
    <?= Html::a(Html::img($image, ['class' => 'img-fluid'])) ?>
    <div class="card-footer">
        <?= Html::a(Yii::t('website','Delete'), ['/website/page/delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-block',
            'data-method' => 'post',
            'data-confirm' => Yii::t('website','Are you sure you want to delete this item?')
        ]) ?>
    </div>
</div>


