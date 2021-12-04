<?php

namespace backend\controllers;

use common\models\wrappers\CompetitionWrapper;
use Yii;
use common\models\wrappers\CompetitionPhaseWrapper;
use common\models\search\CompetitionPhaseSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompetitionPhaseController implements the CRUD actions for CompetitionPhaseWrapper model.
 */
class CompetitionPhaseController extends Controller
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
     * Lists all CompetitionPhaseWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompetitionPhaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompetitionPhaseWrapper model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CompetitionPhaseWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompetitionPhaseWrapper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CompetitionPhaseWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CompetitionPhaseWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the CompetitionPhaseWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompetitionPhaseWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompetitionPhaseWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionDialog() {
        $model = new CompetitionPhaseWrapper();
        if (isset($_GET['id'])) {
            $model = CompetitionPhaseWrapper::find()->where(['id' => $_GET['id']])->one();
        }

        if (isset($_GET['competition_id'])) {
            $competitionModel=CompetitionWrapper::find()->where(['id'=>$_GET['competition_id']])->one();
            if(isset($competitionModel)){
                $model->competition_id = $competitionModel->id;
                $model->season_id = $competitionModel->season_id;
            }
        }


        if ($model->load(Yii::$app->request->post())) {
            $message = array ();
            if ($model->save()) {
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
}
