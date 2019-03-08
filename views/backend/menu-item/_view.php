<?php

use yii\helpers\Html;

?>

<li id="<?= $model->id ?>" class="handle">
    <h2><?= Html::a($model->label, \daxslab\website\components\Lookup::getLink($model, 'update')) ?></h2>
    <p>
        <strong><?= Yii::t('website','URL') ?>: </strong> <?= Html::a($model->url, $model->url) ?><br/>
        <?= Html::a(Yii::t('website','[Delete]'), \daxslab\website\components\Lookup::getLink($model, 'delete'), [
            'data-method' => 'post',
            'data-confirm' => Yii::t('website','Are you sure you want to delete this item?')
        ]) ?>
    </p>
</li>