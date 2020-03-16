<?php

use yii\helpers\Html;

$module = $this->context->module->id;
?>

<li id="<?= $model->id ?>">
    <h3><?= Html::a(Html::encode($model->name), ["/$module/metadata-definition/update", 'id' => $model->id]) ?></h3>
    <p><?= $model->type ?></p>
</li>

