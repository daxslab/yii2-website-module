<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MenuItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'menu_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'language')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::activeLabel($model, 'url') ?>
        <div class="input-group">
            <?= Html::activeTextInput($model, 'url', ['class' => 'form-control']) ?>
            <span class="input-group-btn">
                    <?= Html::button('Link', [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'modal',
                        'data-target' => '#select-content-modal'
                    ]) ?>
                </span>
        </div>
        <?= Html::error($model, 'url') ?>
    </div>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?php \yii\bootstrap4\Modal::begin([
        'id' => 'select-content-modal',
        'title' => Html::tag('h4', Yii::t('website','Select content'), ['class' => 'modal-title']),
        'options' => [
            'data' => [
                'target-field' => '#menuitem-url',
                'label-field' => '#menuitem-label',
            ]
        ]
    ]) ?>

    <?= \yii\widgets\Menu::widget([
        'items' => array_map(function ($item) {
            return $item->menuItem;
        }, Yii::$app->website->getRootPages()->byLanguage($model->language)->all()),
    ]) ?>

    <?php \yii\bootstrap4\Modal::end() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('website','Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
