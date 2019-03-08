<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model daxslab\website\models\PageType */

$this->title = Yii::t('website','Update Page Type: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('website','Settings'), 'url' => ['website/update']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('website','Page Types'), 'url' => ['website/update', '#' => 'page-types']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="page-type-update">

    <header class="mb-4 pb-2 border-bottom">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?= Yii::$app->runAction('/website/metadata-definition/index', ['page_type_id' => $model->id]) ?>

</div>
