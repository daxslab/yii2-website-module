<?php
use yii\helpers\Html;

?>

<section class="<?= "block block-{$view}"?>">
    <header>
        <div class="container">
            <h2><?= Html::encode($model->title) ?></h2>
            <p class="lead mt-4 pt-4 border-top"><?= Html::encode($model->abstract) ?></p>
        </div>
    </header>
    <div class="container">

        <?php if ($dataProvider->count): ?>
            <?= \yii\widgets\ListView::widget([
                'layout' => '{items}{pager}',
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'card-deck'],
                'itemView' => "category-item",
                'itemOptions' => ['tag' => false],
            ]) ?>
        <?php endif; ?>

    </div>
</section>
