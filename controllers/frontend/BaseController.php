<?php
/**
 * Created by PhpStorm.
 * User: glpz
 * Date: 11/01/19
 * Time: 22:12
 */

namespace daxslab\website\controllers\frontend;

use yii\web\Controller;
use yii\data\ArrayDataProvider;
use daxslab\website\models\Page;
use yii\web\NotFoundHttpException;
use Yii;

class BaseController extends Controller
{
    protected function getViewFile($model)
    {
        $filePath = "{$this->viewPath}/{$model->type->name}.php";
        return file_exists($filePath)
            ? $model->type->name
            : 'page';
    }

    protected function findModel($slug, $language)
    {
        if (($model = Yii::$app->website->getPages()
                ->byStatus(Page::STATUS_POST_PUBLISHED)
                ->byLanguage($language)
                ->bySlug($slug)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('website','The page "{language}/{slug}" does not exist.', [
            'language' => $language,
            'slug' => $slug,
        ]));
    }
}
