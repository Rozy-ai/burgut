<?php

namespace backend\controllers;

use common\components\TicketService;
use common\models\search\TicketSearch;
use common\models\wrappers\SeatWrapper;
use common\models\wrappers\TicketWrapper;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TicketController implements the CRUD actions for TicketWrapper model.
 */
class TicketController extends Controller
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
     * Lists all TicketWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TicketSearch();
        if (!isset($_GET['sort'])) {
            $_GET['sort'] = '-id';
        }
        $searchModel->status = TicketWrapper::STATUS_SUCCESS;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TicketWrapper model.
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
     * Creates a new TicketWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new TicketWrapper();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Updates an existing TicketWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Deletes an existing TicketWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TicketWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TicketWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TicketWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionSendEmail($id)
    {
        $model = $this->findModel($id);
        $ticketService = new TicketService();
        if ($ticketService->sendEmail($model)) {
            return $this->redirect(['index']);
        }
    }


    public function actionDialog()
    {
        $model = new TicketWrapper();
        $model->unique_code = strtoupper(uniqid());

        if (isset($_GET['id'])) {
            $model = TicketWrapper::find()->where(['id' => $_GET['id']])->one();
        }

        if (isset($_GET['seat_id'])) {
            $seatModel = SeatWrapper::find()->where(['id' => $_GET['seat_id']])->one();
            if (isset($seatModel)) {
                $model->seat_id = $seatModel->id;
                $model->location_id = $seatModel->location_id;
            }
        }

        if (!isset($model->location_id) && isset($_GET['location_id'])) {
            $model->location_id = $_GET['location_id'];
        }

        if (isset($_GET['event_id'])) {
            $model->event_id = $_GET['event_id'];
        }

        $post = Yii::$app->request->post();
        if ($post) {
            $message = array();
            $ticketService = new TicketService();
            $data = $post['TicketWrapper'];
            if (isset($data['seats']))
                $data['seats'] = explode($data['seats'], ',');
            elseif (isset($data['seat_id'])) {
                $data['seats'] = [$data['seat_id']];
            }

            $response = $ticketService->registerPayment($data);
            if (isset($response) && (isset($response['status']) && $response['status'] == true) && isset($response['data']['ticket_unique_code'])) {
                $ticketModel = TicketWrapper::find()->where(['unique_code' => $response['data']['ticket_unique_code']])->one();
                if (isset($ticketModel)) {
                    $paymentModel = $ticketModel->payment;
                    if (isset($paymentModel)) {
                        $ticket_finish_response = $ticketService->finishPaymentProcess($paymentModel);
                        if (isset($ticket_finish_response) && isset($ticket_finish_response['errors']) && count($ticket_finish_response['errors']) > 0) {
                            $message['status'] = 'error';
                            $message['message'] = 'Ticket save failed';
                            $message['errors'] = $model->getErrors();
                        } else {
                            $message['status'] = 'success';
                            $message['message'] = 'Ticket saved';
                        }
                    }
                }
            } else {
                $message['status'] = 'error';
                $message['message'] = 'Ticket register failed';
                $message['errors'] = $response['errors'];
            }

            echo Json::encode($message);
        } else {
            return $this->renderAjax('_dialog', [
                'model' => $model,
            ]);
        }
    }
}
