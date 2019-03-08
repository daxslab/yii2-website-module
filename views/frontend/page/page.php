<?php

use yii\helpers\Html;
use daxslab\website\widgets\PageWidgetizer;

?>

<article id="<?= $model->slug ?>" class="<?= $model->type->name ?>">
    <?= $this->render('_header', ['model' => $model])?>
    <div class="container">

        <?php if ($model->body): ?>
            <?= PageWidgetizer::widget([
                'body' => $model->body
            ]) ?>
        <?php endif; ?>

        <?php if ($dataProvider->query->exists()): ?>
            <?= \yii\widgets\ListView::widget([
                'layout' => '{items}{pager}',
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'card-deck'],
                'itemView' => "_{$model->type->name}-view",
                'itemOptions' => ['tag' => false],
            ]) ?>
        <?php endif; ?>

    </div>
</article>
