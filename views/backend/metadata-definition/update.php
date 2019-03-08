<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model daxslab\website\models\MetadataDefinition */

$this->title = Yii::t('website','Update Metadata Definition: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('website','Settings'), 'url' => ['/website/website/update', 'id' => Yii::$app->website->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('website','Page Types'), 'url' => ['/website/website/update', 'id' => Yii::$app->website->id, '#' => 'page-types']];
$this->params['breadcrumbs'][] = ['label' => $model->pageType->name, 'url' => ['/website/page-type/update', 'id' => $model->page_type_id]];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="metadata-definition-update">

    <header class="mb-4 pb-2 border-bottom">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
