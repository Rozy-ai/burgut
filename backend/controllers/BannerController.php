<?php

namespace backend\controllers;

use common\components\CommonController;
use Yii;
use common\models\wrappers\BannerWrapper;
use common\models\search\BannerSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BannerController implements the CRUD actions for BannerWrapper model.
 */
class BannerController extends CommonController {


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
     * Lists all BannerWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BannerWrapper model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BannerWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new BannerWrapper();
        $post = Yii::$app->request->post();
        if (isset($post) && $model->load(Yii::$app->request->post())) {
            $post = $post['BannerWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $model->docs = explode(',', $post['docs']);

            if ($model->save()) {
                if (!Yii::$app->request->isAjax)
                    return $this->redirect(['view', 'id' => $model->id]);
                else
                    Yii::$app->end(1);
            }
        }

        $model->docs = implode($model->docs, ',');
        $method = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BannerWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if (isset($post) && $model->load(Yii::$app->request->post())) {
            $post = $post['BannerWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $model->docs = explode(',', $post['docs']);

            if ($model->save()) {
                if (!Yii::$app->request->isAjax)
                    return $this->redirect(['view', 'id' => $model->id]);
                else
                    Yii::$app->end(1);
            }
        }

        $model->docs = implode($model->docs, ',');
        $method = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BannerWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model=$this->findModel($id);
        $redirectUrl=Url::to(['banner-type/update','id'=>$model->type]);

        if($model->delete())
            return $this->redirect($redirectUrl);
    }

    /**
     * Finds the BannerWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BannerWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BannerWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
