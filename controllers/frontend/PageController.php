<?php

namespace daxslab\website\controllers\frontend;

use Yii;
use daxslab\website\models\Page;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PageController extends BaseController
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'text/html' => Response::FORMAT_HTML,
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
                'languages' => $this->module->languages,
            ],
        ];
    }

    public function actionHome($_lang = null)
    {
        $_lang = $_lang ?: explode('-', Yii::$app->language)[0];

        $homePage = Yii::$app->website->getRootPages()->byLanguage($_lang)->orderBy('position')->one();
        if (!$homePage) {
            throw new NotFoundHttpException(Yii::t('website', 'The requested page does not exist.'));
        }
        return $this->actionView($homePage->slug, $_lang);
    }

    public function actionView($slug, $_lang, $_format = Response::FORMAT_HTML)
    {
        $model = $this->findModel($slug, $_lang);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getPages()
                ->byStatus(Page::STATUS_POST_PUBLISHED)
                ->orderBy($model->type->sort_by),
        ]);

        $data = [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ];

        return $_format == Response::FORMAT_HTML
            ? $this->render($this->getViewFile($model), $data)
            : $data;
    }

}
