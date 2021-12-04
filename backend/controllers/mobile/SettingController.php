<?php

namespace backend\controllers\mobile;

use Yii;
use common\models\wrappers\SettingWrapper;
use common\models\search\SettingSearch;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * SettingController implements the CRUD actions for SettingWrapper model.
 */
class SettingController extends RestController
{
    public $modelClass = 'common\models\wrappers\SettingWrapper';
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
            'optional' => ['view', 'create','index'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['create'],
            'rules' => [
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['view', 'index'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ];
        return $behaviors;
    }


    /**
     * Lists all SettingWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingSearch();
        $searchModel->type=SettingWrapper::TYPE_MOBILE;

        if (!isset($_GET['sort'])) {
            $_GET['sort'] = 'category';
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
     * Displays a single SettingWrapper model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        return $model;
    }

    /**
     * Finds the SettingWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SettingWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SettingWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
