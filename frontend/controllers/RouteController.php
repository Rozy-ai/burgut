<?php

namespace frontend\controllers;

use Yii;
use common\models\wrappers\RouteWrapper;
use common\models\search\RouteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RouteController implements the CRUD actions for RouteWrapper model.
 */
class RouteController extends Controller {
    /**
     * Lists all RouteWrapper models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new RouteSearch();
        if (isset($_GET['region'])) {
            $searchModel->region = $_GET['region'];
        } else {
            $searchModel->region = RouteWrapper::REGION_ASHGABAT;
        }

        if (isset($_GET['type'])) {
            $searchModel->type = $_GET['type'];
        } else {
            $searchModel->type = RouteWrapper::TYPE_IN_CITY;
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionMap($id) {
        $model = RouteWrapper::findOne($id);

        return $this->renderAjax('_leaflet_map', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the RouteWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RouteWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = RouteWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
