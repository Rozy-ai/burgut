<?php

namespace backend\controllers\mobile;

use common\components\TicketService;
use common\models\Payment;
use common\models\search\PaymentSearch;
use common\models\wrappers\PaymentWrapper;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * FlatOfferController implements the CRUD actions for FlatOfferWrapper model.
 */
class PaymentController extends RestController
{
    public $modelClass = 'common\models\wrappers\FlatOfferWrapper';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['register', 'check-status'],
            'optional' => ['check-status'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'register'],
            'rules' => [
                [
                    'actions' => ['index', 'register'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['view', 'check-status'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ];
        return $behaviors;
    }


    /**
     * Lists all FlatOfferWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '');
        if (isset($_GET['per-page'])) {
            $dataProvider->pagination->pageSize = $_GET['per-page'];
        }

        return [
            'status' => true,
            'total' => $dataProvider->getTotalCount(),
            'data' => $dataProvider->getModels()
        ];
    }

    /**
     * Displays a single FlatOfferWrapper model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $model;
    }


    public function actionCheckStatus()
    {
        $errors = ['message' => ""];
        $status = false;
        $response = null;
        $return_response = [];
        $order_status_url = null;
        $data = Yii::$app->request->get();
//        $user = Yii::$app->user->identity;

        if (isset($data) && isset($data['merchant_order_number'])) {
            $paymentInstance = PaymentWrapper::find()->where(['merchant_order_number' => $data['merchant_order_number']])->one();
            if (isset($paymentInstance)) {
                $response_data = $paymentInstance->checkStatus();
                if (isset($response_data['errors'])) {
                    $errors = ArrayHelper::merge($errors, $response_data['errors']);
                }

                if (isset($response_data['data'])) {
                    $return_response = $response_data['data'];
                    $ticketService = new TicketService();
                    $ticket_finish_response = $ticketService->finishPaymentProcess($paymentInstance);

                    if (isset($ticket_finish_response)) {
                        $refreshedPaymentInstance = PaymentWrapper::find()->where(['id' => $paymentInstance->id])->one();
                        if ($ticket_finish_response['status'] && (isset($refreshedPaymentInstance) && $refreshedPaymentInstance->status == PaymentWrapper::STATUS_SUCCESS))
                            $status = true;

                        if (isset($ticket_finish_response['errors']))
                            $errors = ArrayHelper::merge($errors, $ticket_finish_response['errors']);
                    }
                }

            } else {
                $errors = ArrayHelper::merge($errors, ['message' => 'Payment Order not found']);
            }

        } else {
            $errors = ArrayHelper::merge($errors, ['message' => Yii::t('app', 'Order Number request empty')]);
        }


        return [
            'status' => $status,
            'errors' => $errors,
            'data' => $return_response,
            'total' => 1,
        ];
    }


    /**
     * Finds the FlatOfferWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PaymentWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PaymentWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
