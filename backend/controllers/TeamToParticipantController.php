<?php

namespace backend\controllers;

use common\models\wrappers\TeamWrapper;
use Yii;
use common\models\wrappers\TeamToParticipantWrapper;
use common\models\search\TeamToParticipantSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeamToParticipantController implements the CRUD actions for TeamToParticipantWrapper model.
 */
class TeamToParticipantController extends Controller {
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
     * Lists all TeamToParticipantWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TeamToParticipantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeamToParticipantWrapper model.
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
     * Creates a new TeamToParticipantWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TeamToParticipantWrapper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TeamToParticipantWrapper model.
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
     * Deletes an existing TeamToParticipantWrapper model.
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
     * Finds the TeamToParticipantWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TeamToParticipantWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TeamToParticipantWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionDialog() {
        $model = new TeamToParticipantWrapper();
        if (isset($_GET['id'])) {
            $model = TeamToParticipantWrapper::find()->where(['id' => $_GET['id']])->one();
        }

        if (isset($_GET['team_id'])) {
            $team = TeamWrapper::find()->where(['id' => $_GET['team_id']])->one();
            $model->team_id = $team->id;
        }

        if (isset($_GET['type'])) {
            $model->type = $_GET['type'];
        }

        $post = Yii::$app->request->post();
        if (isset($post['TeamToParticipantWrapper']) && $model->load($post)) {
            $post = $post['TeamToParticipantWrapper'];


            if (isset($post['date_joined']) && strlen(trim($post['date_joined'])) > 0)
                $model->date_joined = \Yii::$app->formatter->asDate($model->date_joined, 'yyyy-MM-dd');
            else
                $model->date_joined = null;

            if (isset($post['date_leaved']) && strlen(trim($post['date_leaved'])) > 0) {
                $model->date_leaved = \Yii::$app->formatter->asDate($model->date_leaved, 'yyyy-MM-dd');
                $model->status = TeamToParticipantWrapper::STATUS_ARCHIVE;
            } else {
                $model->date_leaved = null;
                $model->status = TeamToParticipantWrapper::STATUS_ACTIVE;
            }

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
