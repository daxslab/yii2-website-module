<?php

use yii\helpers\Html;
use backend\models\MenuItemSearch;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this View */
/* @var $searchModel MenuItemSearch */
/* @var $dataProvider ActiveDataProvider */

$website = Yii::$app->website;

?>
<div class="menu-item-index">

    <p>
        <?= Html::a(Yii::t('website','New Item'), [
            '/website/menu-item/create',
            'menu_id' => $menu->id,
            'language' => $language,
        ]) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => Html::tag('ol', '{items}', [
                'data-update-page' => Url::toRoute(['menu-item/update-position'])
            ]) . "\n{pager}",
        'itemView' => '_view',
        'itemOptions' => ['tag' => false],
    ]) ?>

</div>
