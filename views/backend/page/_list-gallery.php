<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var $parent \backend\models\Page */
/** @var $language string */
/** @var $dataProvider \yii\data\ArrayDataProvider */

?>

<header class="mb-4">

    <?php
    \yii\bootstrap4\Modal::begin([
        'id' => 'page-gallery-modal',
        'size' => \yii\bootstrap4\Modal::SIZE_LARGE,
        'title' => Yii::t('website','Select an image'),
        'toggleButton' => [
            'label' => Yii::t('website','Add'),
            'class' => 'btn btn-success float-right',
        ],
        'options' => [
            'data' => [
                'url' => \yii\helpers\Url::toRoute(['page/add-image-to-gallery',
                    'gallery_id' => $parent->id,
                    'image_id' => 'image_id_param',
                ]),
            ]
        ]
    ])
    ?>

    <?= Yii::$app->runAction('/website/media/images-gallery') ?>

    <?php \yii\bootstrap4\Modal::end() ?>

    <h3 class="font-weight-normal"><?= Yii::t('website','Images in gallery') ?></h3>
</header>



<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '<div class="row">{items}</div>',
    'itemOptions' => ['class' => 'col-md-4 mb-4'],
    'itemView' => '_view-gallery',
]) ?>

