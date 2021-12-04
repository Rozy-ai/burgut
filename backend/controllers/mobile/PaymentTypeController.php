<?php

namespace backend\controllers\mobile;

use common\components\HalkbankPaymentService;
use common\components\PaymentService;
use common\components\PaymentTypeService;
use common\models\search\PaymentTypeSearch;
use common\models\wrappers\EventToSeatWrapper;
use common\models\wrappers\PaymentWrapper;
use common\models\wrappers\PaymentTypeWrapper;
use Yii;
use yii\db\conditions\InCondition;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PaymentTypeController implements the CRUD actions for PaymentTypeWrapper model.
 */
class PaymentTypeController extends RestController
{
    public $modelClass = 'common\models\wrappers\PaymentTypeWrapper';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['create'],
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
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['index', 'view'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ];
        return $behaviors;
    }


    /**
     * Lists all PaymentTypeWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentTypeSearch();
        $searchModel->status = PaymentTypeWrapper::STATUS_ENABLED;
        $searchModel->type = PaymentTypeWrapper::TYPE_MOBILE;

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
     * Displays a single PaymentTypeWrapper model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $model;
    }


    /**
     * Finds the PaymentTypeWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PaymentTypeWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PaymentTypeWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
