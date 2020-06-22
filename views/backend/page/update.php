<?php

use \daxslab\website\components\Lookup;
use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'] = Lookup::getBreadcrumbsForPage($model);

\daxslab\website\components\Lookup::getLink($model, 'create');

?>

<header class="mb-4 pb-2 border-bottom">
    <h1>
        <?= $this->title ?>
        <small title="<?= Yii::t('website', 'Slug') ?>" class="text-muted">(<?= $model->slug ?>)</small><br/>
        <small><?= Html::a($model->url, $model->url, ['target' => '_blank']) ?></small>
    </h1>
</header>

<?= $this->render('_form', [
    'model' => $model,
    'metadatas' => $metadatas,
]) ?>
