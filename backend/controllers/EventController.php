<?php

namespace backend\controllers;

use backend\models\SeatPriceForm;
use common\components\CommonController;
use common\models\EventToSeat;
use common\models\EventToTeam;
use common\models\search\EventSearch;
use common\models\wrappers\EventToParticipantWrapper;
use common\models\wrappers\EventToSeatWrapper;
use common\models\wrappers\EventToTeamWrapper;
use common\models\wrappers\EventWrapper;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * EventController implements the CRUD actions for EventWrapper model.
 */
class EventController extends CommonController {
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
     * Lists all EventWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new EventSearch();
        if (!isset($_GET['sort'])) {
            $_GET['sort'] = '-start_time';
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EventWrapper model.
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
     * Creates a new EventWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new EventWrapper();

        if (isset($_GET['competition_id'])) {
            $model->competition_id = $_GET['competition_id'];
            $model->season_id = $model->competition->season_id;
        }

        $post = Yii::$app->request->post();
        if (isset($post) && count($post) > 0) {
            $model->load($post);
            if (isset($model->start_time)) {
                $start_time = new \DateTime($model->start_time);
                $model->start_time = $start_time->format('Y-m-d H:i:s');
            }
            if ($model->save()) {
                $this->assignSourceEvents($model);
                \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Event has been created please fill other details'));
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                echo "<pre>";
                print_r($model->getErrors());
                echo "</pre>";
                \Yii::$app->getSession()->setFlash('danger', \Yii::t('app', 'Cannot create event'));
            }
        }

        $model->sources = $model->sourceEvents;
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EventWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        if (isset($post) && count($post) > 0) {
            $model->load($post);
            if (isset($model->start_time)) {
                $start_time = new \DateTime($model->start_time);
                $model->start_time = $start_time->format('Y-m-d H:i:s');
            }
            if ($model->save()) {
                $this->assignSourceEvents($model);
                return $this->redirect(['competition/update', 'id' => $model->competition_id]);
            }
        }
        $model->sources = $model->sourceEvents;

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    protected function assignSourceEvents($model) {
        if (isset($model->sources) && is_array($model->sources)) {
            foreach ($model->sources as $source_event_id) {
                $sourceEvent = EventWrapper::findOne($source_event_id);
                $sourceEvent->parent_id = $model->id;
                if ($sourceEvent->save(false)) {
                    if ($sourceEvent->competition->is_team) {
                        $wonEventToTeams = EventToTeamWrapper::find()->where(['event_id' => $sourceEvent->id, 'result_state' => EventToTeamWrapper::RESULT_STATE_WIN])->all();
                        foreach ($wonEventToTeams as $eventToTeam) {
                            $modelEventToTeam = EventToTeamWrapper::find()->where(['team_id' => $eventToTeam->team_id, 'event_id' => $model->id])->one();
                            if (!isset($modelEventToTeam)) {
                                $modelEventToTeam = new EventToTeamWrapper();
                                $modelEventToTeam->team_id = $eventToTeam->team_id;
                                $modelEventToTeam->event_id = $model->id;
                                $modelEventToTeam->category_id = $model->category_id;
                                $modelEventToTeam->save(false);
                            }
                        }
                    } else {
                        $wonEventToParticipants = EventToParticipantWrapper::find()->where([
                            'event_id' => $sourceEvent->id,
                            'result_state' => EventToParticipantWrapper::RESULT_STATE_WIN,
                            'type' => EventToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE,
                        ])->all();

                        foreach ($wonEventToParticipants as $eventToParticipant) {
                            $modelEventToParticipant = EventToParticipantWrapper::find()->where(['participant_id' => $eventToParticipant->participant_id, 'event_id' => $model->id, 'type' => EventToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE])->one();
                            if (!isset($modelEventToParticipant)) {
                                $modelEventToParticipant = new EventToParticipantWrapper();
                                $modelEventToParticipant->participant_id = $eventToParticipant->participant_id;
                                $modelEventToParticipant->type = EventToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE;
                                $modelEventToParticipant->event_id = $model->id;
                                $modelEventToParticipant->category_id = $model->category_id;
                                $modelEventToParticipant->save(false);
                            }
                        }
                    }
                }
            }
        }
    }


    /**
     * Deletes an existing EventWrapper model.
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
     * Finds the EventWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EventWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = EventWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

//
//    public function actionSeatPrice($seat_group_id)
//    {
//        $model = new SeatPriceForm();
//        if (isset($_GET['seat_group_id']) && isset($_GET['event_id'])) {
//            $model->seat_group_id = $_GET['seat_group_id'];
//            $model->event_id = $_GET['event_id'];
//
//            $eventToSeat = EventToSeatWrapper::find()->where(['event_id' => $model->event_id, 'seat_group_id' => $model->seat_group_id])->one();
//            if (isset($eventToSeat)) {
//                $model->price = $eventToSeat->price;
//                $model->discount = $eventToSeat->discount;
//            }
//        }
//
//        if ($model->load(Yii::$app->request->post())) {
//            $message = array();
//            if (isset($model->event_id) && isset($model->seat_group_id)) {
//                if (EventToSeatWrapper::updateAll(['price' => $model->price, 'discount' => $model->discount], ['event_id' => $model->event_id, 'seat_group_id' => $model->seat_group_id])) {
//                    $message['status'] = 'success';
//                    $message['message'] = 'Message successfully sent';
//                } else {
//                    $message['status'] = 'error';
//                    $message['message'] = 'Message failed due to internal error';
//                }
//            }
//
//            echo Json::encode($message);
//        } else {
//            return $this->renderAjax('_seat_price_dialog', [
//                'model' => $model,
//            ]);
//        }
//    }


    /**
     * [actionJsoncalendar description]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @param  [type] $_     [description]
     * @return [type]        [description]
     */
    public function actionEventCalendar($start = NULL, $end = NULL, $_ = NULL) {
        $events = array ();

        $searchModel = new EventSearch();
        $date = new \DateTime();
        $searchModel->afterStartDatetime = $date;

        if (!isset($_GET['sort'])) {
            $_GET['sort'] = '-start_time';
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '');
        $eventModels = $dataProvider->getModels();
        foreach ($eventModels as $eventModel) {
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $eventModel->id;
            $Event->title = $eventModel->title;
            $start_time = new \DateTime($eventModel->start_time);
            $Event->start = $start_time->format('Y-m-d\TH:m:s\Z');
//            $Event->url = $eventModel->url;
            $Event->url = Url::to(['/event-to-seat/index', 'event_id' => $eventModel->id]);
            $events[] = $Event;
        }
        header('Content-type: application/json');
        echo Json::encode($events);
        Yii::$app->end();
    }

}
