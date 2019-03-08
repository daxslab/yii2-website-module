<?php

use yii\helpers\Html;
use daxslab\website\widgets\PageWidgetizer;

$this->title = $model->title;
$this->description = $model->abstract;
$this->image = $model->image;

?>

<article id="<?= $model->slug ?>" class="<?= $model->type->name ?>">
    <?= $this->render('_header', ['model' => $model])?>
    <div class="container">

        <?php if ($model->body): ?>
            <?= PageWidgetizer::widget([
                'body' => $model->body
            ])?>
        <?php endif; ?>

        <?php if ($dataProvider->query->exists()): ?>
            <div class="row">
                <?= \yii\widgets\ListView::widget([
                    'layout' => '{items}{pager}',
                    'dataProvider' => $dataProvider,
                    'itemView' => "_{$model->type->name}-view",
                    'itemOptions' => ['tag' => false],
                ]) ?>
            </div>
        <?php endif; ?>

    </div>
</article>
