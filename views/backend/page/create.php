<?php

use daxslab\website\components\Lookup;

$this->title = Yii::t('website','New Page');

if ($parent) {
    $this->params['breadcrumbs'] = Lookup::getBreadcrumbsForPage($model);
} else {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('website','Pages'), 'url' => ['page/index']];
    $this->params['breadcrumbs'][] = Yii::t('website',$this->title);
}

?>

<header class="mb-4 pb-2 border-bottom">
    <h1><?= $this->title ?></h1>
</header>

<?= $this->render('_form', [
    'model' => $model,
    'metadatas' => $metadatas,
]) ?>
