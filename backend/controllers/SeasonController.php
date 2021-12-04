<?php

namespace backend\controllers;

use common\models\wrappers\CompetitionWrapper;
use Yii;
use common\models\wrappers\SeasonWrapper;
use common\models\search\SeasonSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SeasonController implements the CRUD actions for SeasonWrapper model.
 */
class SeasonController extends Controller {
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
     * Lists all SeasonWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SeasonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SeasonWrapper model.
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
     * Creates a new SeasonWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new SeasonWrapper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SeasonWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SeasonWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionDialog() {
        $model = new SeasonWrapper();
        if (isset($_GET['id'])) {
            $model = SeasonWrapper::find()->where(['id' => $_GET['id']])->one();
        }

        if (isset($_GET['competition_id'])) {
            $model->competition_id = $_GET['competition_id'];
        }


        if ($model->load(Yii::$app->request->post())) {
            if (isset($model->start_date))
                $model->start_date = \Yii::$app->formatter->asDate($model->start_date, 'yyyy-MM-dd');
            if (isset($model->end_date))
                $model->end_date = \Yii::$app->formatter->asDate($model->end_date, 'yyyy-MM-dd');


            $message = array ();
            if ($model->save()) {
                $competitionModel = CompetitionWrapper::find()->where(['id' => $model->competition_id])->one();
                if (isset($competitionModel) && !isset($competitionModel->season_id)) {
                    $competitionModel->season_id = $model->id;
                    $competitionModel->save();
                }

                $message['status'] = 'success';
                $message['message'] = 'Seat saved';
            } else {
                $message['status'] = 'error';
                $message['message'] = 'Seat save failed';
                $message['errors'] = $model->getErrors();
            }

            echo Json::encode($message);
        } else {
            return $this->renderAjax('_dialog', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the SeasonWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SeasonWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SeasonWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
