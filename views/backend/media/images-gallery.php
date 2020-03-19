<?php

use yii\widgets\ListView;

?>

<?=
ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '<div class="row image-gallery">{items}</div>{pager}',
    'itemOptions' => ['class' => 'col-md-3'],
    'itemView' => '_image',
])
?>
