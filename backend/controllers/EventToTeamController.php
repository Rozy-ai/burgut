<?php

namespace backend\controllers;

use common\models\CompetitionToTeam;
use common\models\EventToTeam;
use common\models\wrappers\CompetitionToParticipantWrapper;
use common\models\wrappers\CompetitionToTeamWrapper;
use common\models\wrappers\EventToParticipantWrapper;
use common\models\wrappers\EventWrapper;
use Yii;
use common\models\wrappers\EventToTeamWrapper;
use common\models\search\EventToTeamSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventToTeamController implements the CRUD actions for EventToTeamWrapper model.
 */
class EventToTeamController extends Controller {
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
     * Lists all EventToTeamWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new EventToTeamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EventToTeamWrapper model.
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
     * Creates a new EventToTeamWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new EventToTeamWrapper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EventToTeamWrapper model.
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
     * Deletes an existing EventToTeamWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        EventToParticipantWrapper::deleteAll(['team_id' => $model->team_id, 'event_id' => $model->event_id]);
        $model->delete();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the EventToTeamWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EventToTeamWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = EventToTeamWrapper::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionDialog() {
        $model = new EventToTeamWrapper();
        if (isset($_GET['id'])) {
            $model = EventToTeamWrapper::find()->where(['id' => $_GET['id']])->one();
        }

        if (isset($_GET['event_id'])) {
            $event = EventWrapper::find()->where(['id' => $_GET['event_id']])->one();
            $model->event_id = $event->id;
            $model->category_id = $event->category_id;
        }

        if ($model->load(Yii::$app->request->post())) {
            $message = array ();
            if ($model->save()) {
                $eventToParticipants = EventToParticipantWrapper::find()->where(['event_id' => $model->event_id, 'team_id' => $model->team_id])->all();
                if (count($eventToParticipants) == 0) {
                    //attach participants to event
                    $competitionParticipants = CompetitionToParticipantWrapper::find()->where(['competition_id' => $model->event->competition_id, 'team_id' => $model->team_id])->all();
                    foreach ($competitionParticipants as $competitionParticipant) {
                        $eventToParticipant = new EventToParticipantWrapper();
                        $eventToParticipant->setAttributes($competitionParticipant->attributes);
                        $eventToParticipant->event_id = $model->event_id;
                        if (!$eventToParticipant->save()) {
                            $message['errors'][] = $model->getErrors();
                        }
                    }
                }

                $message['status'] = 'success';
                $message['message'] = 'Team added to event';
            } else {
                $message['status'] = 'error';
                $message['message'] = 'Failed to add team to event';
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
