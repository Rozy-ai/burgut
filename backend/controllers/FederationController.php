<?php

namespace backend\controllers;

use common\components\CommonController;
use common\models\FederationLang;
use common\models\search\FederationSearch;
use common\models\wrappers\FederationWrapper;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * FederationController implements the CRUD actions for FederationWrapper model.
 */
class FederationController extends CommonController {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all FederationWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new FederationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FederationWrapper model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FederationWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new FederationWrapper();

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->load($post);
            $post = $post['FederationWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $model->docs = explode(',', $post['docs']);

//            if (isset($post['cats']) && strlen(trim($post['cats'])) > 0)
//                $model->cats = explode(',', $post['cats']);

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        $model->docs = implode($model->docs, ',');
        $model->cats = implode($model->cats, ',');
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FederationWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
//            echo "<pre>";
//            print_r($post);
//            echo "</pre>";

            $model->load($post);
            $post = $post['FederationWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $model->docs = explode(',', $post['docs']);

//            if (isset($post['cats']) && strlen(trim($post['cats'])) > 0)
            if (isset($post['cats']))
                $model->cats = $post['cats'];
//            echo "<pre>";
//            print_r($model->cats);
//            echo "</pre>";
//            exit(1);

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        $model->docs = implode($this->trimNonexistentDocuments($model->docs), ',');
//        $model->cats = implode($model->cats, ',');
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FederationWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $itemLangModels = FederationLang::find()->where(['item_id' => $id])->all();
        foreach ($itemLangModels as $itemLangModel) {
            if (isset($itemLangModel))
                $itemLangModel->delete();
        }


        $model = $this->findModel($id);
        $documents = $model->documents;
        if (isset($documents)) {
            foreach ($documents as $doc) {
                $doc->fullDelete('tbl_item_to_document');
            }
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FederationWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FederationWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = FederationWrapper::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
