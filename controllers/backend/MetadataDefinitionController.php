<?php

namespace daxslab\website\controllers\backend;

use daxslab\website\models\PageType;
use Yii;
use daxslab\website\models\MetadataDefinition;
use daxslab\website\models\MetadataDefinitionSearch;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MetadataDefinitionController implements the CRUD actions for MetadataDefinition model.
 */
class MetadataDefinitionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MetadataDefinition models.
     * @return mixed
     */
    public function actionIndex($page_type_id)
    {
        $pageType = PageType::findOne($page_type_id);
        if(!$pageType){
            throw  new NotFoundHttpException(Yii::t('website','Page Type not found'));
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $pageType->getMetadataDefinitions()->orderBy('name')->all(),
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->renderPartial('index', [
            'model' => $pageType,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MetadataDefinition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($page_type_id)
    {
        $model = new MetadataDefinition([
            'page_type_id' => $page_type_id,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/website/page-type/update', 'id' => $model->page_type_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MetadataDefinition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/website/page-type/update', 'id' => $model->page_type_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MetadataDefinition model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['/website/page-type/update', 'id' => $model->page_type_id]);
    }

    /**
     * Finds the MetadataDefinition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MetadataDefinition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MetadataDefinition::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('website','The requested page does not exist.'));
    }
}
