<?php

namespace frontend\controllers;

use common\components\TicketService;
use common\models\search\TicketSearch;
use common\models\wrappers\TicketWrapper;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TicketController implements the CRUD actions for TicketWrapper model.
 */
class TicketController extends Controller
{

    /**
     * Finds the TicketWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TicketWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TicketWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionDownload($unique_code)
    {
        $model = TicketWrapper::find()->where(['unique_code' => $unique_code])->one();
        if (isset($model)) {
            $pdfPath = $model->getPdfPath();
            if (file_exists($pdfPath)) {
                Yii::$app->response->sendFile($pdfPath);
            }
        }
    }


    public function actionSendEmail($id)
    {
        $model = $this->findModel($id);
        $ticketService = new TicketService();
        if ($ticketService->sendEmail($model)) {
            return $this->redirect(['index']);
        }
    }
}
