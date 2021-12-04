<?php
namespace frontend\controllers;

use common\components\TicketService;
use common\models\wrappers\PaymentWrapper;
use Yii;
use yii\web\Controller;

//ini_set('max_execution_time', 6000);


class PaymentController extends Controller {
    public $layout = 'simple';

//    /**
//     * {@inheritdoc}
//     */
//    public function behaviors() {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }


    public function beforeAction($action) {
        if ($action->id == 'payment-response') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }


    public function actionPaymentResponse() {
        $result = ['status' => false];
        $message = "";
        $paymentOrderInstance = null;

        if (isset($_GET['merchant_order_number']) && isset($_GET['status'])) {
            $paymentOrderInstance = PaymentWrapper::find()->where(['merchant_order_number' => $_GET['merchant_order_number']])->one();

//            if (isset($paymentOrderInstance) && $paymentOrderInstance->status == PaymentWrapper::STATUS_PENDING) {
            if (isset($paymentOrderInstance)) {
                $paymentOrderInstance->date_finished = \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
//                $paymentOrderInstance->status = $_GET['status'];

                if ($paymentOrderInstance->status == PaymentWrapper::STATUS_SUCCESS) {
                    $result['status'] = true;

                    //recheck again even if success status returned
                    $response_data = $paymentOrderInstance->checkStatus();

                    if (isset($response_data['errors']) && isset($response_data['errors']['message'])) {
                        $message = $response_data['errors']['message'];
                    } else {
                        $message = Yii::t('app', 'Payment was successful');
                    }
                }

                //if bank form returned failure
                if ($paymentOrderInstance->status == PaymentWrapper::STATUS_FAILED) {
                    $result['status'] = false;
                    if (strlen(trim($message)) == 0)
                        $message .= Yii::t('app', 'Payment error occured');
                }

//                if ($paymentOrderInstance->save()) {
                $ticketService = new TicketService();
                $ticket_finish_response = $ticketService->finishPaymentProcess($paymentOrderInstance);
//                    if (isset($ticket_finish_response)) {
//                        $refreshedPaymentInstance = PaymentWrapper::find()->where(['id' => $paymentOrderInstance->id])->one();
//                        if ($ticket_finish_response['status'] && (isset($refreshedPaymentInstance) && $refreshedPaymentInstance->status == PaymentWrapper::STATUS_SUCCESS))
//                            $status = true;
//
////                        if (isset($ticket_finish_response['errors']))
////                            $errors = ArrayHelper::merge($errors, $ticket_finish_response['errors']);
//                    }
//                }
            } else {
                $message .= Yii::t('app', 'Payment with this number was not found');
            }
        }

        $result['message'] = $message;
        return $this->render('payment_response', ['result' => $result, "paymentOrderInstance" => $paymentOrderInstance]);
    }

}
