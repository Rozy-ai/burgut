<?php

namespace backend\controllers;

use common\models\search\SeatSearch;
use common\models\wrappers\SeatWrapper;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * SeatController implements the CRUD actions for SeatWrapper model.
 */
class SeatController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all SeatWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SeatWrapper model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SeatWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SeatWrapper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $method = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SeatWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $method = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SeatWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the SeatWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SeatWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SeatWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionDialog()
    {
        $model = new SeatWrapper();
        if (isset($_GET['id'])) {
            $model = SeatWrapper::find()->where(['id' => $_GET['id']])->one();
        }

        if (isset($_GET['seat_group_id'])) {
            $model->seat_group_id = $_GET['seat_group_id'];
        }

        if (isset($_GET['location_id'])) {
            $model->location_id = $_GET['location_id'];
        }


//        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ActiveForm::validate($model);
//        }

        if ($model->load(Yii::$app->request->post())) {
            $model->name = $model->label_y . $model->label_x;

            $message = array();
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


    public function actionDialogRange()
    {
        $model = new SeatWrapper();
        if (isset($_GET['id'])) {
            $model = SeatWrapper::find()->where(['id' => $_GET['id']])->one();
        }

        if (isset($_GET['seat_group_id'])) {
            $model->seat_group_id = $_GET['seat_group_id'];
        }

        if (isset($_GET['location_id'])) {
            $model->location_id = $_GET['location_id'];
        }

        if ($model->load(Yii::$app->request->post())) {
            $message = array();
            $errors[] = array();
            $saved = true;

            if (isset($model->label_x_start) && isset($model->label_x_end)) {
                for ($i = (int)$model->label_x_start; $i <= (int)($model->label_x_end); $i++) {
                    $seatModel = SeatWrapper::find()->where(['label_y' => $model->label_y, 'label_x' => $i . "", 'seat_group_id' => $model->seat_group_id])->one();
                    if (!isset($seatModel))
                        $seatModel = new SeatWrapper();

                    $seatModel->seat_group_id = $model->seat_group_id;
                    $seatModel->label_y = $model->label_y;
                    $seatModel->label_x = $i . "";
                    $seatModel->name = $seatModel->label_y . $seatModel->label_x;

                    if (!$seatModel->save()) {
                        $saved = false;
                        $errors[] = $seatModel->getErrors();
                    }
                }
            }

            if (!$saved) {
                $message['status'] = 'error';
                $message['message'] = 'Seat range save failed';
                $message['errors'] = $errors;
            } else {
                $message['status'] = 'success';
                $message['message'] = 'Seats saved';
            }

            echo Json::encode($message);
        } else {
            return $this->renderAjax('_dialog_range', [
                'model' => $model,
            ]);
        }
    }



}
