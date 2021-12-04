<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 1/27/2018
 * Time: 6:44 PM
 */

namespace backend\controllers\mobile;

use dektrium\user\models\LoginForm;
use dektrium\user\models\RecoveryForm;
use dektrium\user\models\RegistrationForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class ApiController extends Controller {
    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['dashboard'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
//            'only' => ['dashboard','login','register'],
            'only' => ['dashboard'],
            'rules' => [
                [
                    'actions' => ['dashboard'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
//                [
//                    'actions' => ['login','register'],
//                    'allow' => true,
//                    'roles' => ['?'],
//                ],
            ],
        ];
        return $behaviors;
    }

    public function actionLogin() {

        $model = \Yii::createObject(LoginForm::className());
        $model->scenario = \common\models\security\LoginForm::SCENARIO_REST_LOGIN;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }


    public function actionRegister() {
        if (!Yii::$app->getModule('user')->enableRegistration) {
            throw new NotFoundHttpException();
        }

        $model = \Yii::createObject(RegistrationForm::className());
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->register()) {
            return ['success' => true];
//            return $this->actionLogin();
//            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }


    public function actionForgot() {
        $sent = false;
        $errors = array ();

        $model = \Yii::createObject([
            'class' => RecoveryForm::className(),
            'scenario' => RecoveryForm::SCENARIO_REQUEST,
        ]);

        $data = Yii::$app->getRequest()->getBodyParams();
        if (isset($data) && isset($data['email'])) {
            if ($model->load($data, '') && $model->sendRecoveryMessage()) {
                $sent = true;
            } else {
                $errors = $model->getErrors();
            }
        }

        return [
            'status' => $sent,
            'errors' => $errors,
            'total' => 1
        ];
    }


    public function actionDashboard() {
        $response = [
            'username' => Yii::$app->user->identity->username,
            'access_token' => Yii::$app->user->identity->getAuthKey(),
        ];

        return $response;
    }

    public function actionContact() {
        $response = [
            'contact_us' => 'roomstorent.com'
        ];

        return $response;
    }
}
