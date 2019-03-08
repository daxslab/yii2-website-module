<?php

use yii\helpers\Html;


?>

<li id="<?= $model->id ?>">
    <h3><?= Html::a(Html::encode($model->name), ['/website/metadata-definition/update', 'id' => $model->id]) ?></h3>
    <p><?= $model->type ?></p>
</li>

