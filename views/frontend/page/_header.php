<?php

use yii\helpers\Html;

$this->title = Html::encode($model->title);
$this->description = Html::encode($model->abstract);
$this->image = $model->image;

?>

<header class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1><?= $this->title ?></h1>
        <p class="lead mt-4 pt-4 border-top"><?= $this->description ?></p>
    </div>
</header>
