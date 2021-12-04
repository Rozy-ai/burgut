<?php

namespace backend\controllers\mobile;

use common\models\Message;
use common\models\search\FlatWantSearch;
use common\models\search\MessageSearch;
use common\models\wrappers\FlatWantWrapper;
use common\models\wrappers\MessageWrapper;
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
class MessageController extends RestController {
    public $modelClass = 'common\models\wrappers\MessageWrapper';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['index', 'send', 'delete'],
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
                    'actions' => ['index', 'send', 'delete'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }


    /**
     * Lists all FlatOfferWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        $advertModel = null;
        $searchModel = new MessageSearch();

        $user_id = Yii::$app->user->identity->id;
        $type = isset($_GET['type']) ? $_GET['type'] : MessageWrapper::TYPE_INBOX;
        switch ($type) {
            case MessageWrapper::TYPE_INBOX:
                $searchModel->receiver_id = $user_id;
                break;
            case MessageWrapper::TYPE_SENT:
                $searchModel->sender_id = $user_id;
                break;
            case MessageWrapper::TYPE_TRASH:
                $searchModel->status = MessageWrapper::STATUS_TRASH;
                break;
        }
//        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '');
        if (isset($_GET['per-page'])) {
            $dataProvider->pagination->pageSize = $_GET['per-page'];
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


    public function actionSend() {
        $model = new MessageWrapper();
        $user_id = Yii::$app->user->identity->id;
        $receivedUserId = null;
        $data = json_decode(Yii::$app->request->post('data'), true);
        if ($model->load($data, '')) {
            if (isset($data['flat_want_id']) && strlen(trim($data['flat_want_id'])) > 0 && $data['flat_want_id'] > 0) {
                $model->flat_want_id = $data['flat_want_id'];
                $flatWantModel = FlatWantWrapper::find()->where(['id' => $data['flat_want_id']])->one();
                if (isset($flatWantModel) && $flatWantModel->user_id) {
                    $receivedUserId = $flatWantModel->user_id;
                }
            }

            if (isset($data['flat_offer_id']) && strlen(trim($data['flat_offer_id'])) > 0 && $data['flat_offer_id'] > 0) {
                $model->flat_offer_id = $data['flat_offer_id'];
                $flatOfferModel = FlatOfferWrapper::find()->where(['id' => $data['flat_offer_id']])->one();
                if (isset($flatOfferModel) && $flatOfferModel->user_id) {
                    $receivedUserId = $flatOfferModel->user_id;
                }
            }

            if (isset($receivedUserId)) {
                $model->receiver_id = $receivedUserId;
            }

            $model->sender_id = $user_id;
            $model->date = date('Y-m-d H:i:s');
            $model->status = MessageWrapper::STATUS_SEND;
            if ($model->save()) {
                return [
                    'status' => true,
                    'errors' => [],
                    'total' => 1,
                ];
            }
        }

        return [
            'status' => false,
            'errors' => $model->getErrors(),
            'total' => 1,
        ];
    }


    public function actionDelete() {
        $data = json_decode(Yii::$app->request->post('data'), true);
        $user = Yii::$app->user->identity;
        $deleted = false;
        $errors = array ();

        if (isset($data) && isset($data['id']) && $data['id'] > 0 && isset($user)) {
            $model = MessageWrapper::find()->where(['id' => $data['id']])->one();
            if (isset($model)) {
                if ($model->status == MessageWrapper::STATUS_TRASH) {
                    if ($model->delete()) {
                        $deleted = true;
                    } else {
                        $errors = $model->getErrors();
                    }
                } else {
                    $model->status = MessageWrapper::STATUS_TRASH;
                    if ($model->save(false)) {
                        $deleted = true;
                    } else {
                        $errors = $model->getErrors();
                    }
                }
            }
        }

        return [
            'status' => $deleted,
            'errors' => $errors,
            'total' => 1
        ];
    }
}
