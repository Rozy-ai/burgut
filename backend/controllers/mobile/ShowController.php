<?php

namespace backend\controllers\mobile;

use common\models\search\ShowSearch;
use common\models\wrappers\DocumentWrapper;
use common\models\wrappers\ShowWrapper;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\rest\Serializer;

/**
 * FlatOfferController implements the CRUD actions for ShowWrapper model.
 */
class ShowController extends RestController
{
    public $modelClass = 'common\models\wrappers\ShowWrapper';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['index', 'view'],
            'optional' => ['index', 'view'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['create', 'update'],
            'rules' => [
//                [
//                    'actions' => ['create', 'update'],
//                    'allow' => true,
//                    'roles' => ['@'],
//                ],
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
     * Lists all ShowWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {

        Serializer::className();
        $searchModel = new ShowSearch();

        $date=new \DateTime();
        $searchModel->afterStartDatetime = $date;


        if (!isset($_GET['sort'])) {
            $_GET['sort'] = 'latest_event_date';
        }

        if (isset($_GET['keyword'])) {
            $searchModel->title = $_GET['keyword'];
        }


        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '');
        if (isset($_GET['per-page']))
            $dataProvider->pagination->setPageSize((int)$_GET['per-page']);

        if (isset($_GET['page']))
            $dataProvider->pagination->setPage((int)$_GET['page']);


        return [
            'status' => true,
            'total' => $dataProvider->getTotalCount(),
            'data' => $dataProvider->getModels()
        ];
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);

        $date=new \DateTime();
//        $interval = new \DateInterval('P1M');
//        $date->sub($interval);
        $model->afterStartDatetime = $date;

//        $model->updateCounters(['visited_count' => 1]);
        return $model;
    }


    protected function findModel($id)
    {
        if (($model = ShowWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
