<?php

use yii\helpers\Html;

$module = $this->context->module->id;
?>

<li id="<?= $model->id ?>">
    <h3><?= Html::a(Yii::t('app', '{label} {name}', [
            'label' => Html::encode($model->label),
            'name' => Html::tag('span', '(' . Html::encode($model->name) . ')', ['class' => 'text-muted']),
        ]), ["/$module/metadata-definition/update", 'id' => $model->id]) ?></h3>
    <p><?= $model->type ?></p>
</li>

