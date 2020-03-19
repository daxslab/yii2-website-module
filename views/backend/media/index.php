<?php

use backend\models\PageSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ListView;
use vinpel\DropZone\DropZone;

/* @var $this View */
/* @var $searchModel PageSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('website','Media');

$this->params['breadcrumbs'][] = $this->title;
$module = $this->context->module->id;

?>
<div class="content-index">

    <header class="mb-4 pb-2 border-bottom">
        <h1><?= $this->title ?></h1>
    </header>

    <?=
    DropZone::widget([
        'options' => [
            'paramName' => "Media[filename]",
            'method' => 'post',
            'url' => Url::toRoute(["/$module/media/upload"]),
        ],
    ]);
    ?>

    <div class="card my-4">
        <div class="card-body">
            <?= $this->render('_search', [
                'model' => $searchModel
            ]) ?>
        </div>
    </div>

    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '<div class="row">{items}</div>{pager}',
        'itemOptions' => ['class' => 'col-sm-6 col-md-3'],
        'itemView' => '_view',
    ])
    ?>

</div>
