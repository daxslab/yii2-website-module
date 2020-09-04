<?php

use yii\helpers\Html;

$thumbnailUrl = isset($model->image)
    ? Yii::$app->thumbnailer->get($model->image, 75, 75)
    : Yii::$app->thumbnailer->get(Yii::getAlias('@web/images/no-image.png'), 75, 75);

$handleClass = $model->parent_id == null || ($model->parent_id !== null && $model->parent->type->sort_by === 'position')
    ? 'handle'
    : '';

?>

<li id="<?= $model->id ?>" class="media mb-2 <?= $handleClass ?>">

    <?= Html:: img($thumbnailUrl, ['class' => 'mr-3']) ?>

    <div class="media-body">
        <h2 class="m-0">
            <?= Html::a(Html::encode($model->title), ['update', 'id' => $model->id]) ?>
            <small class="text-muted text-uppercase">[<?= Html::encode($model->type->name) ?>]</small>
        </h2>
        <ul class="list-unstyled">
            <li><strong><?= Yii::t('website', 'Preview') ?>
                    : </strong> <?= Html::a($model->url, $model->url, ['target' => '_blank']) ?></li>
            <li><strong><?= Yii::t('website', 'Updated') ?>: </strong> <?= $model->updated_at ?>
                <strong><?= Yii::t('website', 'by') ?>: </strong> <?= $model->editor->name ?></li>
        </ul>
    </div>
</li>
