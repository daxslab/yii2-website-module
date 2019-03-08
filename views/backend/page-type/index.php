<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel daxslab\website\models\PageTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div id="page-type-index">

    <header class="mb-4 pb-2 border-bottom">
        <h2><?= Yii::t('website','Page Types') ?></h2>
    </header>

    <p>
        <?= Html::a(Yii::t('website','New...'), ['create']) ?>
    </p>

    <?= ListView::widget([
        'layout' => '{items}',
        'dataProvider' => $dataProvider,
        'options' => ['tag' => 'ol'],
        'itemOptions' => ['tag' => 'li'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['update', 'id' => $model->id]);
        },
    ]) ?>
</div>
