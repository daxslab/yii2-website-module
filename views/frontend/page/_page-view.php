<?php

use yii\helpers\Html;

?>

<div class="card mb-4">
    <?php if($model->image): ?>
    <?= Html::a(Html::img(Yii::$app->thumbnailer->get($model->image, 640, 480), ['class' => 'img-fluid']), $model->possibleUrl) ?>
    <?php endif; ?>
    <div class="card-body">
        <h2 class="card-title"><?= Html::a(Html::encode($model->title), $model->possibleUrl) ?></h2>
        <p class="card-text"><?= Html::encode($model->abstract) ?></p>
    </div>
</div>

<?php if (($index + 1) % 3 == 0): ?>
    <div class="w-100"></div>
<?php endif; ?>
