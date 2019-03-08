<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel daxslab\website\models\MetadataDefinitionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = Yii::t('website','Metadata Definitions');
?>
<div class="metadata-definition-index">

    <header class="mb-4 pb-2 border-bottom">
        <h2><?= Html::encode($title) ?></h2>
    </header>

    <p><?= Html::a(Yii::t('website','New...'), ['create', 'page_type_id' => $model->id])?></p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => Html::tag('ol', '{items}', [
                'data-update-page' => Url::toRoute(['menu-item/update-position'])
            ]) . "\n{pager}",
        'itemView' => '_view',
        'itemOptions' => ['tag' => false],
    ]); ?>
</div>
