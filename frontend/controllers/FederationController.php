<?php

namespace frontend\controllers;

use common\components\CommonController;
use common\models\search\FederationSearch;
use common\models\wrappers\CommentWrapper;
use common\models\wrappers\FederationWrapper;
use common\models\wrappers\MenuWrapper;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * FederationController implements the CRUD actions for FederationWrapper model.
 */
class FederationController extends CommonController {
    public $layout = 'bootstrap';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all FederationWrapper models.
     * @return mixed
     */
    public function actionIndex($path = null, $category_id = null) {
        $searchModel = new FederationSearch();
        $searchModel->status = 1;

        if (!isset($_GET['sort'])) {
            $_GET['sort'] = '-id';
        }


        return $this->render('index', [
            'searchModel' => $searchModel
        ]);
    }


    /**
     * Displays a single FederationWrapper model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $model->updateCounters(['visited_count' => 1]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the FederationWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FederationWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = FederationWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionAddComment() {
        $commentModel = new CommentWrapper();
        $user = Yii::$app->user->identity;
        $post = Yii::$app->request->post();


        if (isset($post['CommentWrapper']['federation_id'])) {
            $federationModel = FederationWrapper::find()->where(['id' => $post['CommentWrapper']['federation_id']])->one();
            if (isset($federationModel)) {
                $commentModel->load($post);
                $commentModel->federations_rel = array ($federationModel->id);
                if ($commentModel->save()) {
                    $commentsModel = $federationModel->comments;
                    $show_form = false;
                    return $this->renderAjax('//comment/index', ['commentsModel' => $commentsModel, 'show_form' => $show_form]);
                }
            }
        }
    }
}
