<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use daxslab\website\components\Lookup;
use dosamigos\ckeditor\CKEditor;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model daxslab\website\models\Page */
/* @var $form ActiveForm */

$pageTypeOptions = \yii\helpers\ArrayHelper::map(Yii::$app->website->pageTypes, 'id', 'name');
$defaultImage = Yii::getAlias('@web/images/no-image.png');
$currentWebsite = Yii::$app->website;

$module = $this->context->module->id;

?>
<div class="form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::errorSummary(array_merge([$model], $metadatas), ['class' => 'alert alert-danger']) ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'page_type_id')->widget(\dosamigos\selectize\SelectizeDropDownList::class, [
                'items' => $pageTypeOptions,
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'status')->widget(\kartik\switchinput\SwitchInput::class, [
                'pluginOptions' => [
                    'onText' => Yii::t('website', 'Published'),
                    'offText' => Yii::t('app', 'Draft'),
                ],
                'options' => [
                    'onchange' => "this.form.submit()",
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">

            <?= $form->field($model, 'abstract')->textarea(['rows' => 3]) ?>

            <?php if (!empty($metadatas)): ?>
                <div class="row">
                    <?php foreach ($metadatas as $index => $md): ?>
                        <div class="col-md-6">
                            <?php if ($md->metadataDefinition->type == \yii\validators\BooleanValidator::class): ?>
                                <?= $form
                                    ->field($md, "[{$index}]value")
                                    ->checkbox()
                                    ->label(Yii::t('app', '{label} {name}', [
                                        'label' => Html::encode($md->metadataDefinition->label),
                                        'name' => Html::tag('span', '(' . Html::encode($md->metadataDefinition->name) . ')', ['class' => 'text-muted']),
                                    ])) ?>
                            <?php else: ?>
                                <?= $form
                                    ->field($md, "[{$index}]value")
                                    ->label(Yii::t('app', '{label} {name}', [
                                        'label' => Html::encode($md->metadataDefinition->label),
                                        'name' => Html::tag('span', '(' . Html::encode($md->metadataDefinition->name) . ')', ['class' => 'text-muted']),
                                    ])) ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php
            // add showprotected ckeditor plugin for allowing usage of components
            $this->registerJs("CKEDITOR.plugins.addExternal('showprotected', '/js/ckeditor/showprotected/plugin.js', '');");
            $this->registerJs("CKEDITOR.plugins.addExternal('imagebrowser', '/js/ckeditor/imagebrowser/plugin.js', '');");

            echo $form->field($model, 'body')->widget(CKEditor::class, [
                'preset' => 'full',
                'clientOptions' => [
                    'extraPlugins' => 'showprotected,imagebrowser,showblocks,pastefromword,div,find,save,clipboard',
                    'imageBrowser_listUrl' => \yii\helpers\Url::to(["/$module/media/get-images-for-gallery"]),
                    'imageBrowser_pluginPath' => Yii::$app->assetManager->bundles[\daxslab\website\WebsiteAsset::class]->baseUrl,
                    'allowedContent' => true,
                    'contentsCss' => [
                        Yii::$app->assetManager->bundles[\yii\bootstrap4\BootstrapAsset::class]->baseUrl . '/css/bootstrap.css',
                    ]
                ],
            ])->label(false);

            // register components as protected elements in ckeditor
            $script = <<< JS
                        jQuery(function ($) {                    
                            CKEDITOR.config.protectedSource.push(/<\s*?header\b[^>]*>(.*?)<\/header\b[^>]*>/g );
                            
                            CKEDITOR.config.protectedSource.push(/<\s*?component\b[^>]*>(.*?)<\/component\b[^>]*>/g );
                            CKEDITOR.config.protectedSource.push(/<\s*?component\b[^>]*\/>/g );
                            
                            CKEDITOR.config.protectedSource.push(/<\s*?block\b[^>]*>(.*?)<\/block\b[^>]*>/g );
                            CKEDITOR.config.protectedSource.push(/<\s*?block\b[^>]*\/>/g );
                        });
JS;
            $this->registerJs($script, View::POS_END);
            ?>

        </div>
        <div class="col-md-4">

            <div class="mb-4">
                <?= Html::activeLabel($model, 'image') ?>
                <div class="image-area">
                    <div class="form-group mb-0">
                        <div class="input-group">
                            <?= Html::activeTextInput($model, 'image', ['class' => 'form-control']) ?>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <?= Html::button(Yii::t('website', 'Set'), [
                                    'class' => 'btn btn-primary',
                                    'data' => [
                                        'toggle' => 'modal',
                                        'target' => '#image-gallery-modal',
                                    ]]) ?>
                                <?= Html::button(Yii::t('website', 'Delete'), [
                                    'id' => 'btn-remove-picture',
                                    'class' => 'btn btn-danger',
                                ]) ?>
                            </div>
                        </div><!-- /input-group -->
                        <?php
                        \yii\bootstrap4\Modal::begin([
                            'id' => 'image-gallery-modal',
                            'size' => \yii\bootstrap4\Modal::SIZE_LARGE,
                            'title' => Yii::t('website', 'Select an image'),
                            'options' => [
                                'data' => [
                                    'target-field' => '#page-image',
                                    'preview' => '#page-image-preview',
                                    'default-image' => $defaultImage,
                                ]
                            ]
                        ])
                        ?>
                        <?= Yii::$app->runAction("/$module/media/images-gallery") ?>
                        <?php \yii\bootstrap4\Modal::end() ?>
                    </div>
                </div>
                <?= Html::img(isset($model->image) ? $model->image : $defaultImage, ['id' => 'page-image-preview', 'class' => 'img-fluid']) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('website', 'Save'), ['class' => 'btn btn-success']) ?>
                <?php if (!$model->isNewRecord): ?>
                    <?= Html::a(Yii::t('website', 'Delete'), Lookup::getLink($model, 'delete'), ['class' => 'btn btn-danger',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('website', 'Are you sure you want to delete this item?'),]) ?>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <h2><?= Yii::t('website', 'Subpages') ?></h2>

    <?= $model->id == null
        ? Html::tag('div', Yii::t('website', 'You must save this page before adding subpages'), ['class' => 'alert alert-info'])
        : Yii::$app->runAction("/{$module}/page/index", [
            'parent_id' => $model->id,
            'language' => $model->language,
        ]) ?>


</div><!-- _form -->
