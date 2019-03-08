<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MenuItem */

$this->title = Yii::t('website','Update {modelClass}: ', [
            'modelClass' => 'Menu Item',
        ]) . $model->id;
?>
<div class="menu-item-update">

    <header class="mb-4 pb-2 border-bottom">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
