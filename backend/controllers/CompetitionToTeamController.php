<?php

namespace backend\controllers;

use common\components\CommonController;
use common\models\wrappers\CompetitionWrapper;
use Yii;
use common\models\wrappers\CompetitionToTeamWrapper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompetitionToTeamController implements the CRUD actions for CompetitionToTeamWrapper model.
 */
class CompetitionToTeamController extends Controller {
    /**
     * Deletes an existing CompetitionToTeamWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the CompetitionToTeamWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompetitionToTeamWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = CompetitionToTeamWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionDialog() {
        $model = new CompetitionToTeamWrapper();
        if (isset($_GET['id'])) {
            $model = CompetitionToTeamWrapper::find()->where(['id' => $_GET['id']])->one();
        }

        if (isset($_GET['competition_id'])) {
            $competition = CompetitionWrapper::find()->where(['id' => $_GET['competition_id']])->one();
            $model->competition_id = $competition->id;
            $model->category_id = $competition->category_id;
        }

        if ($model->load(Yii::$app->request->post())) {
            $message = array ();
            if ($model->save()) {
                $message['status'] = 'success';
                $message['message'] = 'Seat saved';
            } else {
                $message['status'] = 'error';
                $message['message'] = 'Seat save failed';
                $message['errors'] = $model->getErrors();
            }

            echo Json::encode($message);
        } else {
            return $this->renderAjax('_dialog', [
                'model' => $model,
            ]);
        }
    }

}
