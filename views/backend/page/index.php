<?php

use yii\data\ArrayDataProvider;

$this->title = 'Pages';

if (!$parent) {
    $this->params['breadcrumbs'][] = Yii::t('website', $this->title);
}

?>

<header class="mb-4 pb-2 border-bottom">
    <h1><?= $this->title ?></h1>
</header>

<?php if ($parent): ?>
    <?= $this->render('_list', [
        'dataProvider' => $dataProvider,
    ]) ?>
<?php else: ?>
    <?= \yii\bootstrap4\Tabs::widget([
        'items' => array_map(function ($item) {
            return [
                'label' => $item,
                'content' => $this->render('_list', [
                    'dataProvider' => new ArrayDataProvider([
                        'allModels' => Yii::$app->website->getRootPages()->byLanguage($item)->orderBy('position')->all(),
                    ]),
                    'language' => $item,
                ])
            ];
        }, $this->context->module->languages)
    ]) ?>

<?php endif; ?>

