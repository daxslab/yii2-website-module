<?php

use yii\helpers\Html;

$thumbnailUrl = isset($model->image)
    ? Yii::$app->thumbnailer->get($model->image, 75, 75)
    : Yii::$app->thumbnailer->get(Yii::getAlias('@web/images/no-image.png'), 75, 75);

?>

<li id="<?= $model->id ?>" class="media mb-2 handle">

    <?= Html:: img($thumbnailUrl, ['class' => 'mr-3']) ?>

    <div class="media-body">
        <h2 class="m-0">
            <?= Html::a(Html::encode($model->title), ['update', 'id' => $model->id]) ?>
            <small class="text-muted text-uppercase">[<?= Html::encode($model->type->name) ?>]</small>
        </h2>
        <ul class="list-unstyled">
            <li><strong><?= Yii::t('website','Preview')?>: </strong> <?= Html::a($model->url, $model->url, ['target' => '_blank']) ?></li>
            <li><strong><?= Yii::t('website','Updated')?>: </strong> <?= $model->updated_at ?></li>
        </ul>
    </div>
</li>
