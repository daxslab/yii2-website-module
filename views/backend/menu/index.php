<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel daxslab\website\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('website','Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <header class="mb-4 pb-2 border-bottom">
        <h1><?= Html::encode($this->title) ?></h1>
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
