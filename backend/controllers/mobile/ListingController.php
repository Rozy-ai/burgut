<?php

namespace backend\controllers\mobile;

use common\models\search\FlatWantSearch;
use common\models\wrappers\FlatWantWrapper;
use common\models\wrappers\RoomWrapper;
use dektrium\user\models\User;
use frontend\models\SearchForm;
use Yii;
use common\models\wrappers\FlatOfferWrapper;
use common\models\search\FlatOfferSearch;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * FlatOfferController implements the CRUD actions for FlatOfferWrapper model.
 */
class ListingController extends RestController
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
            'only' => ['index', 'toggle'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'toggle'],
            'rules' => [
                [
                    'actions' => ['index', 'toggle'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
//                [
//                    'actions' => ['index'],
//                    'allow' => true,
//                    'roles' => ['?'],
//                ],
//                [
//                    'actions' => ['view'],
//                    'allow' => true,
//                    'roles' => ['?'],
//                ],
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
        $adType = Yii::$app->request->get('type');
        $status = Yii::$app->request->get('status');
        $user_id = Yii::$app->user->identity->id;
        $dataProvider = null;
        if (isset($adType) && $adType == 'flatoffer' && isset($user_id)) {
            $searchModel = new FlatOfferSearch();
            $searchModel->user_id = $user_id;
//            if (!isset($status)) {
//                $status = FlatOfferWrapper::ADVERT_STATUS_ACTIVE;
//            }

//            $searchModel->status = $status;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '');
            if (isset($_GET['per-page'])) {
                $dataProvider->pagination->pageSize = $_GET['per-page'];
            }
        } elseif (isset($adType) && $adType == 'flatwant' && isset($user_id)) {
            $searchModel = new FlatWantSearch();
            $searchModel->user_id = $user_id;
//            if (!isset($status)) {
//                $status = FlatWantWrapper::ADVERT_STATUS_ACTIVE;
//            }
//            $searchModel->status = $status;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '');
            if (isset($_GET['per-page'])) {
                $dataProvider->pagination->pageSize = $_GET['per-page'];
            }
        }

        if (isset($dataProvider)) {
            return [
                'status' => true,
                'total' => $dataProvider->getTotalCount(),
                'data' => $dataProvider->getModels()
            ];
        } else {
            return [
                'status' => false,
                'total' => 0,
                'data' => []
            ];
        }
    }


    public function actionToggle()
    {
        $status = 1;
        $errors = [];
        $adType = Yii::$app->request->get('type');
        $adId = Yii::$app->request->get('id');
        $attribute = 'status';
        if (isset($adId) && isset($adType)) {
            if ($adType == 'flatoffer') {
                $model = FlatOfferWrapper::find()->where(['id' => $adId])->one();
            } else {
                $model = FlatWantWrapper::find()->where(['id' => $adId])->one();
            }


            ($model->$attribute == 1) ? $model->$attribute = 0 : $model->$attribute = 1;
            if ($attribute == 'status' && $model->$attribute == 1) {
                $expireDayCount = isset(Yii::$app->params['advert.expireDaysCount']) ? Yii::$app->params['advert.expireDaysCount'] : 7;
                $expireDate = new \DateTime();
                $expireDate->add(new \DateInterval("P" . $expireDayCount . "D"));
                $model->date_expired = \Yii::$app->formatter->asDate($expireDate, 'yyyy-MM-dd HH:mm:ss');
            }

            if ($model->save()) {
                $status = 1;
            } else {
                $status = 0;
                $errors = $model->getErrors();
            }
        }

        return [
            'status' => $status,
            'errors' => $errors,
            'total' => 1
        ];
    }



//
//    /**
//     * Lists all FlatOfferWrapper models.
//     * @return mixed
//     */
//    public function actionIndex()
//    {
//        $user_id = Yii::$app->user->identity->id;
//        $flatOfferSearchModel = new FlatOfferSearch();
//        $flatOfferSearchModel->user_id = $user_id;
//        $flatOfferDataProvider = $flatOfferSearchModel->search($_GET);
//
//
//        $flatWantSearchModel = new FlatWantSearch();
//        $flatWantSearchModel->user_id = $user_id;
//        $flatWantDataProvider = $flatWantSearchModel->search($_GET);
//
//        return $this->render('index', [
//            'user' => Yii::$app->user,
//            'flatOfferSearchModel' => $flatOfferSearchModel,
//            'flatWantSearchModel' => $flatWantSearchModel,
//            'flatOfferDataProvider' => $flatOfferDataProvider,
//            'flatWantDataProvider' => $flatWantDataProvider
//        ]);
//    }
}
