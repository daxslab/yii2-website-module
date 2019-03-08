<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MenuItem */

$this->title = Yii::t('website','Create new menu item for "{menu}"', [
    'menu' => $model->menu->name,
]);
?>
<div class="menu-item-create">

    <header class="mb-4 pb-2 border-bottom">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
