<?php

namespace backend\controllers;

use common\components\CommonController;
use common\models\Document;
use common\models\Image;
use Yii;
use common\models\wrappers\ImageWrapper;
use common\models\search\ImageSearch;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ImageController implements the CRUD actions for ImageWrapper model.
 */
class ImageController extends CommonController
{

    public function behaviors()
    {
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
     * Lists all ImageWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();
        if (isset($_GET['type'])) {
            $searchModel->type = $_GET['type'];
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ImageWrapper model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCrop($id)
    {
        return $this->render('crop', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ImageWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ImageWrapper();
        $model->type = isset($_GET['type']) ? $_GET['type'] : ImageWrapper::IMAGE_VIDEO;

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->load($post);
            $post = $post['ImageWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $model->docs = explode(',', $post['docs']);

            if (isset($post['video_docs']) && strlen(trim($post['video_docs'])) > 0)
                $model->video_docs = explode(',', $post['video_docs']);

            if ($model->save()) {
                return $this->redirect(['index', 'ImageSearch[type]' => $model->type]);
            }
        }


        $model->docs = implode($model->docs, ',');
        $model->video_docs = implode($model->video_docs, ',');
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ImageWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->load($post);
            $post = $post['ImageWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $model->docs = explode(',', $post['docs']);

            if (isset($post['video_docs']) && strlen(trim($post['video_docs'])) > 0)
                $model->video_docs = explode(',', $post['video_docs']);

            if ($model->save()) {
                return $this->redirect(['index', 'ImageSearch[type]' => $model->type]);
            }
        }

        $model->docs = implode($this->trimNonexistentDocuments($model->docs), ',');
        $model->video_docs = implode($this->trimNonexistentDocuments($model->video_docs), ',');
        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing ImageWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $documents = $model->documents;
        if (isset($documents)) {
            foreach ($documents as $doc) {
                $doc->fullDelete('tbl_image_to_document');
            }
        }

        $vidDocuments = $model->videoDocuments;
        if (isset($vidDocuments)) {
            foreach ($vidDocuments as $doc) {
                $doc->fullDelete('tbl_image_video_to_document');
            }
        }

        $redirectUrl = Url::to(['image/index', 'ImageSearch[type]' => $model->type]);
        if ($model->delete())
            return $this->redirect($redirectUrl);
    }

    /**
     * Finds the ImageWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ImageWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ImageWrapper::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
