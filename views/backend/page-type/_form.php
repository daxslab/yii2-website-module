<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use daxslab\website\components\Lookup;

/* @var $this yii\web\View */
/* @var $model daxslab\website\models\PageType */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="page-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, 'website_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('website', 'Save'), ['class' => 'btn btn-success']) ?>
        <?php if (!$model->isNewRecord): ?>
            <?= Html::a(Yii::t('website', 'Delete'), Lookup::getLink($model, 'delete'), [
                'class' => 'btn btn-danger',
                'data-method' => 'post',
                'data-confirm' => Yii::t('website', 'Are you sure you want to delete this item?')
            ]) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
