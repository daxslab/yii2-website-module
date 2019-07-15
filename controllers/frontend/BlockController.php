<?php

namespace daxslab\website\controllers\frontend;

use Yii;
use yii\data\ArrayDataProvider;
use daxslab\website\models\Page;

class BlockController extends BaseController
{
    public function actionView($slug, $view = null, $limit = 3)
    {
        $model = $this->findModel($slug, Yii::$app->language);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $model->getPages()
                ->byStatus(Page::STATUS_POST_PUBLISHED)
                ->orderBy('created_at DESC')
                ->limit($limit)
                ->all()
        ]);

        $view = isset($view) ? $view : $model->type->name;

        return $this->renderPartial($view, [
            'view' => $view,
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }
}