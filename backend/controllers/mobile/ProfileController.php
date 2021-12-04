<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\controllers\mobile;

use common\models\search\FlatOfferSearch;
use common\models\user\Profile;
use dektrium\user\controllers\ProfileController as BaseProfileController;
use dektrium\user\Finder;
use dektrium\user\models\RecoveryForm;
use dektrium\user\models\Token;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * RecoveryController manages password recovery process.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class ProfileController extends RestController {

    public $modelClass = 'common\models\user\Profile';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];


    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['create', 'update', 'index', 'view'],
            'optional' => ['view'],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['update'],
            'rules' => [
                [
                    'actions' => ['update'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['view'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionView() {
        $user = \Yii::$app->user->identity;
        if (isset($user)) {
            $model = $this->findModel($user->id);
            return $model;
        } else
            return null;
    }


    public function actionUpdate() {
        $user = \Yii::$app->user->identity;
        $data = json_decode(\Yii::$app->request->post('data'), true);
        $status = false;
        $errors = [];

        if (isset($user) && isset($data)) {
            $profile = $this->findModel($user->id);

            if ($profile == null) {
                $profile = new Profile();
                $profile->link('user', $user);
            }

            $profile->load($data, '');
            $docs_ids = $this->upload();
            if (isset($docs_ids) && is_array($docs_ids) && count($docs_ids) > 0) {
                $profile->document_id = array_pop($docs_ids);
            }

            if ($profile->save()) {
                $status = true;
            } else {
                $errors = ArrayHelper::merge($errors, $profile->getErrors());
            }
        } else {
            $errors = ArrayHelper::merge($errors, ['message' => 'User not found']);
        }

        return [
            'status' => $status,
            'errors' => $errors,
            'total' => 1,
        ];
    }


    protected function findModel($id) {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
