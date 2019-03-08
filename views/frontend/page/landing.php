<?php

use yii\helpers\Html;
use \daxslab\website\widgets\PageWidgetizer;

$this->title = $model->title;
$this->description = $model->abstract;
$this->image = $model->image;

?>

<?= PageWidgetizer::widget([
    'body' => $model->body
])?>