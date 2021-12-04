<?php

namespace backend\controllers;

use common\components\CommonController;
use Yii;
use common\models\wrappers\ParticipantWrapper;
use common\models\search\ParticipantSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParticipantController implements the CRUD actions for ParticipantWrapper model.
 */
class ParticipantController extends CommonController {
    /**
     * {@inheritdoc}
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
     * Lists all ParticipantWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ParticipantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ParticipantWrapper model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ParticipantWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ParticipantWrapper();


        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if (isset($model->birthdate)) {
                $start_time = new \DateTime($model->birthdate);
                $model->birthdate = $start_time->format('Y-m-d');
            }

            $post = $post['ParticipantWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $model->docs = explode(',', $post['docs']);


            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }


        $model->docs = implode($model->docs, ',');
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ParticipantWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if (isset($model->birthdate)) {
                $start_time = new \DateTime($model->birthdate);
                $model->birthdate = $start_time->format('Y-m-d');
            }



            $post = $post['ParticipantWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $model->docs = explode(',', $post['docs']);

//            echo "<pre>";
//            print_r($post);
//            print_r($model->docs);
//            echo "</pre>";
//            exit(1);


            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->docs = implode($this->trimNonexistentDocuments($model->docs), ',');
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ParticipantWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ParticipantWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ParticipantWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ParticipantWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = ParticipantWrapper::find()->select('
                ' . ParticipantWrapper::tableName() . '.id as id, 
                firstname, 
                lastname, 
                middlename'
            )
                ->where(['OR', ['like', 'firstname', $q], ['like', 'lastname', $q], ['like', 'middlename', $q]])
                ->limit(20);

            if (isset($_GET['gender'])) {
                $query->andWhere(['gender' => $_GET['gender']]);
            }

            if (isset($_GET['competition_id'])) {
                $query->joinWith('competitionToParticiapants cp');
                $query->andWhere(['cp.competition_id' => $_GET['competition_id']]);
            }

            $participants = $query->all();
            $out['results'] = [];
            foreach ($participants as $participant) {
                $out['results'][] = ['id' => $participant->id, 'text' => $participant->firstname . ' ' . $participant->lastname . ' ' . $participant->middlename];
            }
//            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => ParticipantWrapper::findOne(['id' => $id])->firstname];
        }
        return $out;
    }
}
