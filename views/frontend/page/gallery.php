<?php

use yii\helpers\Html;
use daxslab\website\widgets\PageWidgetizer;

?>

<article id="<?= $model->slug ?>" class="<?= $model->type->name ?>">
    <?= $this->render('_header', ['model' => $model]) ?>
    <div class="container">

        <?= \yii\bootstrap4\Breadcrumbs::widget([
            'links' => \daxslab\website\components\Lookup::getBreadcrumbsForPage($model, true),
        ]) ?>

        <?= \dosamigos\gallery\Gallery::widget([
            'items' => array_map(function ($model) {
                return [
                    'src' => Yii::$app->thumbnailer->get($model->image, 640, 480),
                    'url' => $model->image,
                    'options' => ['class' => 'col-md-4 mb-4'],
                    'imageOptions' => ['class' => 'img-fluid', 'alt' => Html::encode($model->title)],
                ];
            }, $dataProvider->query->all()),
            'options' => ['class' => 'row'],
        ]) ?>

    </div>
</article>
