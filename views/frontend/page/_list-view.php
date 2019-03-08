<?php

use yii\helpers\Html;

$textColumnClass = isset($model->image) ? 'col-md-8' : 'col-md-4';

?>

<div class="card mb-4">
    <div class="row">
        <?php if ($model->image): ?>
            <div class="col-md-4">
                <?= Html::a(Html::img(Yii::$app->thumbnailer->get($model->image, 640, 480), ['class' => 'img-fluid']), $model->possibleUrl) ?>
            </div>
        <?php endif; ?>
        <div class="<?= $textColumnClass ?>">
            <div class="card-body">
                <h2 class="card-title"><?= Html::a(Html::encode($model->title), $model->possibleUrl) ?></h2>
                <p class="text-muted m-0">
                    <small><?= Yii::$app->formatter->asDate($model->created_at) ?></small>
                </p>
                <p class="card-text"><?= Html::encode($model->abstract) ?></p>
            </div>
        </div>
    </div>
</div>
