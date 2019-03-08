<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Media */

$this->title = Yii::t('website','New...');
$this->params['breadcrumbs'][] = ['label' => Yii::t('website','Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="media-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
