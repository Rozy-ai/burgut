<?php

namespace backend\controllers;

use common\components\CommonController;
use common\models\Banner;
use common\models\search\BannerSearch;
use common\models\wrappers\BannerWrapper;
use Yii;
use common\models\wrappers\BannerTypeWrapper;
use common\models\search\BannerTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BannerTypeController implements the CRUD actions for BannerTypeWrapper model.
 */
class BannerTypeController extends CommonController {

    public function behaviors() {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all BannerTypeWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BannerTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BannerTypeWrapper model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BannerTypeWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new BannerTypeWrapper();

        $post = $_POST;
        if (isset($_POST['BannerTypeWrapper'])) {
            $model->load(Yii::$app->request->post());

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('update', 'id' => $model->id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('id', $e->getMessage());
            }

        } elseif (isset($_GET['BannerType'])) {
            $model->attributes = $_GET['BannerType'];
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BannerTypeWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $bannerGridModel = new BannerSearch();
        $bannerGridModel->type = $id;

        if (isset($_GET['banner_id']) && strlen(trim($_GET['banner_id'])) > 0) {
            $bannerModel = BannerWrapper::find()->where(['id' => $_GET['banner_id']])->one();
            $bannerGridModel->exceptions = array($_GET['banner_id']);
        } else
            $bannerModel = new BannerWrapper();

        if (isset($bannerModel))
            $bannerModel->type = $id;


        if (isset($_POST['BannerTypeWrapper'])) {
            $model->load(Yii::$app->request->post());
            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('index'));
                    }
                }
            } catch (Exception $e) {
                $model->addError('id', $e->getMessage());
            }

        }

        $bannerModel->docs = implode($bannerModel->docs, ',');
        return $this->render('update', array(
            'model' => $model,
            'bannerModel' => $bannerModel,
            'bannerGridModel' => $bannerGridModel,
        ));

    }

    /**
     * Deletes an existing BannerTypeWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BannerTypeWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BannerTypeWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BannerTypeWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
