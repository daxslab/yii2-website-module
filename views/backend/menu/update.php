<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model daxslab\website\models\Menu */

$this->title = Yii::t('website','Update Menu: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('website','Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="menu-update">

    <header class="mb-4 pb-2 border-bottom">
        <h1><?= $this->title ?></h1>
    </header>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?= \yii\bootstrap4\Tabs::widget([
        'items' => array_map(function ($item) use($model) {
            return [
                'label' => $item,
                'content' => Yii::$app->runAction('website/menu-item/index', ['menu_id' => $model->id, 'language' => $item])
            ];
        }, $this->context->module->languages)
    ]) ?>

</div>
