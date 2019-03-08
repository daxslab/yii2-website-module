<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model daxslab\website\models\Website */

$this->title = Yii::t('website','Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="website-update">

    <header class="mb-4 pb-2 border-bottom">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?= Yii::$app->runAction('/website/page-type/index') ?>

</div>
