<?php

namespace daxslab\website\controllers\backend;

use Yii;
use daxslab\website\models\Page;
use daxslab\website\models\Media;
use yii\base\Exception;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use daxslab\website\models\Metadata;

class PageController extends Controller
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

    private $className = Page::class;

    public function actionIndex($parent_id = null)
    {
        $dataProvider = new ActiveDataProvider();

        $parent = isset($parent_id) ? Page::findOne($parent_id) : null;
        if ($parent) {
            $dataProvider->query = $parent->getPages();
            $dataProvider->pagination->route = '/website/page/update';
            $dataProvider->pagination->pageParam = "subpages-{$parent->id}";
        } else {
            $dataProvider->query = Yii::$app->website->getRootPages();
        }

        $dataProvider->query->orderBy('position');

        $renderMethod = isset($parent) ? 'renderPartial' : 'render';
        $renderView = isset($parent)
            ? file_exists(Yii::getAlias("@daxslab/website/views/backend/page/_list-{$parent->type->name}.php"))
                ? "_list-{$parent->type->name}"
                : '_list'
            : 'index';

        return $this->$renderMethod($renderView, [
            'parent' => $parent,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($page_type_id, $language, $parent_id = null)
    {
        $model = new $this->className([
            'page_type_id' => $page_type_id,
            'parent_id' => $parent_id,
            'language' => $language,
            'website_id' => Yii::$app->website->id,
        ]);

        $metadatas = array_map(function ($mdd) {
            return new Metadata([
                'metadata_definition_id' => $mdd->id,
            ]);
        }, $model->type->metadataDefinitions);

        $this->savePageAndMetadatas($model, $metadatas);

        return $this->render('create', [
            'model' => $model,
            'parent' => $model->parent,
            'metadatas' => $metadatas,
        ]);
    }

    /**
     * Updates an existing PlantType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $metadatas = $model->metadatas;

        if ($this->savePageAndMetadatas($model, $metadatas)) {
        } else {
            die('no');
        }

        return $this->render('update', [
            'model' => $model,
            'metadatas' => $metadatas,
        ]);
    }

    public function actionUpdatePosition()
    {
        $id = Yii::$app->request->post()['id'];
        $position = Yii::$app->request->post()['position'];

        $model = $this->findModel($id);
        if ($model->moveToPosition($position)) {
            return $this->asJson([
                'success' => true,
                'position' => $model->position
            ]);
        }

        return $this->asJson([
            'success' => false,
        ]);
    }


    /**
     * Deletes an existing PlantType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return isset($model->parent_id)
            ? $this->redirect(['update', 'id' => $model->parent_id])
            : $this->redirect(['index']);
    }

    public function actionAddImageToGallery($gallery_id, $image_id)
    {
        $gallery = $this->findModel($gallery_id);
        $image = Media::findOne($image_id);
        $postType = Yii::$app->website->getPageTypes()->where(['name' => 'page'])->one();

        $galleryItem = new Page([
            'parent_id' => $gallery->id,
            'image' => $image->url,
            'title' => $image->filename,
            'language' => $gallery->language,
            'page_type_id' => $postType->id,
            'website_id' => $gallery->website_id,
        ]);

        if ($galleryItem->save()) {
            return $this->redirect(['/website/page/update', 'id' => $gallery->id]);
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'success' => false,
                'errors' => $galleryItem->errors,
            ];
        }
    }

    protected function savePageAndMetadatas($model, $metadatas)
    {
        $success = true;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $success = $model->save();
                Model::loadMultiple($metadatas, Yii::$app->request->post());
                foreach ($metadatas as $md) {
                    $md->page_id = $model->id;
                }
                if (Model::validateMultiple($metadatas)) {
                    foreach ($metadatas as $md) {
                        $success = $success && $md->save(false);
                    }
                }
                if ($success) {
                    $transaction->commit();
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Throwable $e) {
                $transaction->rollBack();
            }
        }
        return $success;
    }

    protected function findModel($id)
    {
        if (($model = ($this->className)::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('website','The requested page does not exist.'));
    }

}