<?php

namespace backend\controllers\mobile;

use backend\controllers\mobile\RestController;
use common\components\CommonController;
use common\models\AdvertActivity;
use common\models\search\AdvertActivitySearch;
use common\models\wrappers\AdvertActivityWrapper;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


class AdvertActivityController extends RestController
{
    public $modelClass = 'common\models\wrappers\PaymentWrapper';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['index', 'add', 'remove'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['transaction'],
            'rules' => [
                [
                    'actions' => ['index', 'add', 'remove'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
//                [
//                    'actions' => ['index', 'view'],
//                    'allow' => true,
//                    'roles' => ['?'],
//                ],
            ],
        ];
        return $behaviors;
    }


    public function actionIndex()
    {
        $advert_type = $_GET['advert_type'];

        if (isset($advert_type)) {
            $user_id = Yii::$app->user->identity->id;
            $advertActivitySearchModel = new AdvertActivitySearch();
            $advertActivitySearchModel->user_id = $user_id;
            $advertActivitySearchModel->advert_type = $advert_type;
            $dataProvider = $advertActivitySearchModel->search($_GET);
        }
        return [
            'status' => true,
            'total' => $dataProvider->getTotalCount(),
            'data' => $dataProvider->getModels()
        ];
    }


    public function actionAdd()
    {
        $data = Yii::$app->request->get();
        $status = false;
        $message = '';

        if (isset($data)) {
            $data['user_id'] = Yii::$app->user->id;
            $oldAdvertActivity = AdvertActivityWrapper::find()->where($data)->one();
            if (!isset($oldAdvertActivity)) {
                $advertActivity = new AdvertActivityWrapper();
                $advertActivity->user_id = Yii::$app->user->id;
                $advertActivity->advert_id = $data['advert_id'];
                $advertActivity->advert_type = $data['advert_type'];
                $advertActivity->activity_type = $data['activity_type'];
                if ($advertActivity->save()) {
                    $response = $advertActivity->completePostAddActivity();
                    return $response;
                    exit(1);
                }
            } else {
                $status = false;
                $message = \Yii::t('user', 'User already had this activity with this advert');
            }
        }


        return [
            'status' => $status,
            'errors' => $message
        ];
    }


    public function actionRemove()
    {
        $data = Yii::$app->request->get();
        $status = false;
        $message = '';

        if (isset($data)) {
            $data['user_id'] = Yii::$app->user->id;
            $advertActivity = AdvertActivityWrapper::find()->where($data)->one();
            if (isset($advertActivity)) {
                $response = $advertActivity->completePostRemoveActivity();
                if ($response['status']) {
                    if ($advertActivity->delete()) {
                        $status = true;
                        $message = \Yii::t('user', 'Activity removed');
                    }
                } else {
                    $status = false;
                    $message = $response['message'];
                }
            } else {
                $message = \Yii::t('user', 'Could not find activity');
            }
        }

        return [
            'status' => $status,
            'errors' => $message
        ];
    }
}
