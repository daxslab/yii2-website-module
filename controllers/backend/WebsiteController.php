<?php

namespace daxslab\website\controllers\backend;

use Yii;
use daxslab\website\models\Website;
use daxslab\website\models\WebsiteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WebsiteController implements the CRUD actions for Website model.
 */
class WebsiteController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Displays a single Website model.
     * @return mixed
     */
    public function actionView()
    {
        return $this->render('view', [
            'model' => Yii::$app->website,
        ]);
    }

    /**
     * Updates an existing Website model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = Yii::$app->website;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

}
