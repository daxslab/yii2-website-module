<?php

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$newItem = [
    'title' => Yii::t('website', 'New Page'),
    'image' => Yii::$app->thumbnailer->get(Yii::getAlias('@web/images/no-image.png'), 75),
];

$language = isset($language) ? $language : $parent->language;
$parent = isset($parent) ? $parent : null;

?>

<?= \yii\widgets\Menu::widget([
    'options' => ['class' => 'list-inline'],
    'itemOptions' => ['class' => 'list-inline-item'],
    'items' => array_map(function ($item) use ($language, $parent) {
        return [
            'label' => Yii::t('app', 'New {type}', [
                'type' => strtoupper(Html::encode($item->name)),
            ]),
            'url' => ['page/create',
                'page_type_id' => $item->id,
                'language' => $language,
                'parent_id' => isset($parent) ? $parent->id : null
            ],
        ];
    }, Yii::$app->website->pageTypes),
]) ?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => Html::tag('ol', '{items}', [
            'class' => 'list-unstyled',
            'data-update-page' => Url::toRoute(['page/update-position'])
        ]) . "\n{pager}",
    'itemView' => '_view',
    'itemOptions' => ['tag' => false],
]) ?>

<?php
// register components as protected elements in ckeditor
$script = <<< JS
                    
        
JS;

$this->registerJs($script, View::POS_END);
?>
