<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use daxslab\website\components\Lookup;

/* @var $this yii\web\View */
/* @var $model daxslab\website\models\MetadataDefinition */
/* @var $form yii\bootstrap4\ActiveForm */

$typeOptions = [
    \yii\validators\BooleanValidator::class => 'boolean',
    \yii\validators\DateValidator::class => 'date',
    \yii\validators\EmailValidator::class => 'email',
    \yii\validators\NumberValidator::class => 'number',
    \yii\validators\StringValidator::class => 'text',
    \yii\validators\UrlValidator::class => 'url',
    \yii\validators\RangeValidator::class => 'list',
];

?>

<div class="metadata-definition-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'label')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Optional')]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'type')->dropDownList($typeOptions) ?>
        </div>
    </div>

    <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>

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
