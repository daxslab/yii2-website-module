<?php

namespace daxslab\website\controllers\backend;

use daxslab\website\models\Menu;
use Yii;
use daxslab\website\models\MenuItem;
use daxslab\website\models\MenuItemSearch;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuItemController implements the CRUD actions for MenuItem model.
 */
class MenuItemController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'up' => ['POST'],
                    'down' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MenuItem models.
     * @param $website_id
     * @param $menu_id
     * @param $language
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($menu_id, $language)
    {
        $menu = Menu::findOne($menu_id);
        if ($menu == null || $menu->website_id != Yii::$app->website->id) {
            throw new NotFoundHttpException(Yii::t('website','Menu not found'));
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $menu->getMenuItems()->andWhere(['language' => $language])->orderBy('position')->all(),
            'pagination' => false,
        ]);

        return $this->renderPartial('index', [
            'dataProvider' => $dataProvider,
            'menu' => $menu,
            'language' => $language,
        ]);
    }

    /**
     * Creates a new MenuItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $website_id
     * @param $menu_id
     * @param $language
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($menu_id, $language)
    {
        $menu = Menu::findOne($menu_id);
        if ($menu == null || $menu->website_id != Yii::$app->website->id) {
            throw new NotFoundHttpException(Yii::t('website','Menu not found'));
        }

        $model = new MenuItem([
            'menu_id' => $menu_id,
            'language' => $language,
            'position' => $menu->getMenuItems()->where(['language' => $language])->count(),
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/website/menu/update', 'id' => $menu->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MenuItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/website/menu/update', 'id' => $model->menu_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
     * Deletes an existing MenuItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $menu = $model->menu;
        $model->delete();

        return $this->redirect(['/website/menu/update', 'id' => $menu->id]);
    }

    /**
     * Finds the MenuItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('website','The requested page does not exist.'));
    }
}
