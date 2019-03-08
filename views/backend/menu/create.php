<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model daxslab\website\models\Menu */

$this->title = Yii::t('website','New...');
$this->params['breadcrumbs'][] = ['label' => Yii::t('website','Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <header class="mb-4 pb-2 border-bottom">
        <h1><?= $this->title ?></h1>
    </header>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
