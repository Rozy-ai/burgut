<?php

namespace backend\controllers\mobile;

use common\components\HalkbankPaymentService;
use common\components\PaymentService;
use common\components\TicketService;
use common\models\search\TicketSearch;
use common\models\wrappers\EventToSeatWrapper;
use common\models\wrappers\PaymentWrapper;
use common\models\wrappers\TicketWrapper;
use Yii;
use yii\db\conditions\InCondition;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * TicketController implements the CRUD actions for TicketWrapper model.
 */
class TicketController extends RestController
{
    public $modelClass = 'common\models\wrappers\TicketWrapper';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['create', 'index', 'view'],
            'optional' => ['view', 'create'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index'],
            'rules' => [
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['view', 'create'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ];
        return $behaviors;
    }


    /**
     * Lists all TicketWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TicketSearch();
//        $searchModel->status = TicketWrapper::ADVERT_STATUS_ACTIVE;

        if (!isset($_GET['sort'])) {
            $_GET['sort'] = '-is_vip,date_created';
        }

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
     * Displays a single TicketWrapper model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($unique_code)
    {
        $model = TicketWrapper::find()->where(['unique_code' => $unique_code])->one();
//        $model->updateCounters(['view_count' => 1]);
        return $model;
    }


    public function actionCreate()
    {
        $data = Yii::$app->request->getBodyParams();


        if (isset($data)) {
            $ticketService = new TicketService();
            return $ticketService->registerPayment($data);
        }

        return [
            'status' => false,
            'errors' => ['message' => 'Provide all params'],
            'total' => 1,
        ];
    }


    /**
     * Deletes an existing TicketWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
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
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
