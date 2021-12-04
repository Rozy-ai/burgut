<?php

namespace backend\controllers\mobile;

use common\models\search\ItemSearch;
use common\models\wrappers\ItemWrapper;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * FlatOfferController implements the CRUD actions for ItemWrapper model.
 */
class ItemController extends RestController
{
    public $searchModel;
    public $modelClass = 'common\models\wrappers\ItemWrapper';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
//            'only' => ['create', 'update', 'index', 'view'],
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
     * Lists all ItemWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (isset($this->searchModel))
            $searchModel = $this->searchModel;
        else
            $searchModel = new ItemSearch();
        $searchModel->status = ItemWrapper::STATUS_ENABLED;

        if (!isset($_GET['sort'])) {
            $_GET['sort'] = '-is_vip,date_created';
        }

        if (isset($_GET['keyword'])) {
            $searchModel->title = $_GET['keyword'];
        }
        if (isset($_GET['location']) && strlen(trim($_GET['location'])) > 1) {
            $searchModel->address = $_GET['location'];
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

    /**
     * Displays a single ItemWrapper model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->updateCounters(['visited_count' => 1]);
        return $model;
    }


    /**
     * Finds the ItemWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
