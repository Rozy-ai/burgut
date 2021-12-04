<?php

namespace backend\controllers;

use common\components\CommonController;
use common\models\OwnerContact;
use Yii;
use common\models\wrappers\OwnerContactWrapper;
use common\models\search\OwnerContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OwnerContactController implements the CRUD actions for OwnerContactWrapper model.
 */
class OwnerContactController extends CommonController
{

    public function behaviors() {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all OwnerContactWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model=OwnerContact::find()->one();
        if(!isset($model)){
            $model =new OwnerContact();
        }

        $model->load(Yii::$app->request->post());
        $model->save();

        return $this->render('create', [
            'model' => $model,
        ]);
    }
//
//    /**
//     * Displays a single OwnerContactWrapper model.
//     * @param integer $id
//     * @return mixed
//     */
   public function actionView($id)
   {
       return $this->render('view', [
           'model' => $this->findModel($id),
       ]);
   }
//
//    /**
//     * Creates a new OwnerContactWrapper model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        $model = new OwnerContactWrapper();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }
//
//    /**
//     * Updates an existing OwnerContactWrapper model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }
//
//    /**
//     * Deletes an existing OwnerContactWrapper model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the OwnerContactWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OwnerContactWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OwnerContactWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
