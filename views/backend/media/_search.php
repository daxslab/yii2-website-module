<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\MediaSearch */
/* @var $form yii\widgets\ActiveForm */

$mimeTypeOptions = Yii::$app->website->getMedias()->select('mime_type')->column();
$mimeTypeOptions = array_combine($mimeTypeOptions, $mimeTypeOptions);

?>

<div class="media-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-8">
            <?= $form->field($model, 'filename') ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'mime_type')->dropDownList($mimeTypeOptions, ['prompt' => Yii::t('website', '-- Choose one --')]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('website', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('website', 'Reset'), Url::current(['MediaSearch' => null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
