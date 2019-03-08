<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Media */

$this->title = Yii::t('website','Update Media: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('website','Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->filename;
?>
<div class="media-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
