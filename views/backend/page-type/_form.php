<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use daxslab\website\components\Lookup;
use daxslab\website\models\PageType;

/* @var $this yii\web\View */
/* @var $model daxslab\website\models\PageType */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="page-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'allow_subpages')->widget(\kartik\switchinput\SwitchInput::class, [
                'pluginOptions' => [
                    'onText' => Yii::t('website', 'Yes'),
                    'offText' => Yii::t('app', 'No'),
                ],
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sort_by')->dropDownList([
                PageType::TYPE_SORT_CREATE_DATE_INVERSE => Yii::t('app', 'Creation Date Inverse'),
                PageType::TYPE_SORT_CREATE_DATE => Yii::t('app', 'Creation Date'),
                PageType::TYPE_SORT_UPDATE_DATE_INVERSE => Yii::t('app', 'Update Date Inverse'),
                PageType::TYPE_SORT_UPDATE_DATE => Yii::t('app', 'Update Date'),
                PageType::TYPE_SORT_POSITION_INVERSE => Yii::t('app', 'Position on List Inverse'),
                PageType::TYPE_SORT_POSITION => Yii::t('app', 'Position on List'),
            ]) ?>
        </div>
    </div>

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
