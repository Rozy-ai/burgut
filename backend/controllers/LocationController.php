<?php

namespace backend\controllers;

use common\components\CommonController;
use common\models\LocationLang;
use Yii;
use common\models\wrappers\LocationWrapper;
use common\models\search\LocationSearch;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LocationController implements the CRUD actions for LocationWrapper model.
 */
class LocationController extends CommonController {


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
     * Lists all LocationWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        if (!isset($_GET['sort'])) {
            $_GET['sort'] = '-id';
        }
        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LocationWrapper model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LocationWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new LocationWrapper();

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->load($post);
            $post = $post['LocationWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $model->docs = explode(',', $post['docs']);

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        $model->docs = implode($model->docs, ',');
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LocationWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->load($post);
            $post = $post['LocationWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $model->docs = explode(',', $post['docs']);

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        $model->docs = implode($this->trimNonexistentDocuments($model->docs), ',');
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LocationWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $locationLangModels = LocationLang::find()->where(['location_id' => $id])->all();
        foreach ($locationLangModels as $locationLangModel) {
            if (isset($locationLangModel))
                $locationLangModel->delete();
        }


        $model = $this->findModel($id);
        $documents = $model->documents;
        if (isset($documents)) {
            foreach ($documents as $doc) {
                $doc->fullDelete('tbl_location_to_document');
            }
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LocationWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LocationWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LocationWrapper::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionEventList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $data = LocationWrapper::find()->joinWith('translations')->where(['like', 'title', $q])->multilingual()->limit(20)->all();
            foreach ($data as $d) {
                $out['results'] = array ($d->id, $d->title);
            }
//            $data = ArrayHelper::map($data, 'id', 'title', 'id');

//            $query = new Query();
//            $query->select('id, visited_count')
//                ->from('tbl_location')
////                ->where(['like', 'name', $q])
//                ->limit(20);
//            $command = $query->createCommand();
//            $data = $command->queryAll();

//            echo "<pre>";
//            print_r($out['results']);
//            echo "</pre>";
//            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => $this->findModel($id)->title];
        }
        return $out;
    }
}
