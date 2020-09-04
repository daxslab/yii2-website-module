<?php

namespace daxslab\website\controllers\frontend;

use Yii;
use yii\data\ArrayDataProvider;
use daxslab\website\models\Page;

class BlockController extends BaseController
{
    public function actionView(array $params = [])
    {
        $slug = $params['slug'];
        $view = isset($params['view']) ? $params['view'] : null;

        $model = $this->findModel($slug, Yii::$app->language);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $model->getPages()
                ->byStatus(Page::STATUS_POST_PUBLISHED)
                ->orderBy($model->type->sort_by)
                ->limit(isset($params['limit']) ? $params['limit'] : 3)
                ->all()
        ]);

        $view = isset($view) ? $view : $model->type->name;

        $params['model'] = $model;
        $params['dataProvider'] = $dataProvider;
        return $this->renderPartial($view, $params);
    }
}
