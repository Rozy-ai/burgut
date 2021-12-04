<?php

namespace backend\controllers;

use common\components\CommonController;
use common\models\wrappers\ItemWrapper;
use Yii;
use common\models\wrappers\TeamWrapper;
use common\models\search\TeamSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeamController implements the CRUD actions for TeamWrapper model.
 */
class TeamController extends CommonController {
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
     * Lists all TeamWrapper models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TeamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeamWrapper model.
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
     * Creates a new TeamWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TeamWrapper();
        $contentItemModel = new ItemWrapper();
        $contentItemModel->type = ItemWrapper::TYPE_RELATED;
        $contentItemModel->status = 1;

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $contentItemModel->load($post);
            $model->load($post);

            $post = $post['ItemWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $contentItemModel->docs = explode(',', $post['docs']);

            if ($contentItemModel->save()) {
                $model->content_item_id = $contentItemModel->id;
                if ($model->save())
                    return $this->redirect(['index']);
                else {
                    echo "<pre> show model: ";
                    print_r($model->getErrors());
                    echo "</pre>";
                }
            } else {
                echo "<pre>";
                print_r($contentItemModel->getErrors());
                echo "</pre>";
            }
        }
        $contentItemModel->docs = implode($contentItemModel->docs, ',');
        return $this->render('create', [
            'model' => $model,
            'contentItemModel' => $contentItemModel,
        ]);
    }

    /**
     * Updates an existing TeamWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $contentItemModel = $model->loadContent();
        if (!isset($contentItemModel)) {
            $contentItemModel = new ItemWrapper();
            $contentItemModel->status = 1;
        }
        $contentItemModel->type = ItemWrapper::TYPE_RELATED;

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $contentItemModel->load($post);
            $model->load($post);

            $post = $post['ItemWrapper'];
            if (isset($post['docs']) && strlen(trim($post['docs'])) > 0)
                $contentItemModel->docs = explode(',', $post['docs']);

            if ($contentItemModel->save()) {
                $model->content_item_id = $contentItemModel->id;
                if ($model->save())
                    return $this->redirect(['index']);
                else {
                    echo "<pre> show model: ";
                    print_r($model->getErrors());
                    echo "</pre>";
                }
            } else {
                echo "<pre> item model: ";
                print_r($contentItemModel->getErrors());
                echo "</pre>";
            }
        }

        $contentItemModel->docs = implode($this->trimNonexistentDocuments($contentItemModel->docs), ',');
        return $this->render('update', [
            'model' => $model,
            'contentItemModel' => $contentItemModel,
        ]);
    }

    /**
     * Deletes an existing TeamWrapper model.
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
     * Finds the TeamWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TeamWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TeamWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
//            $data = LocationWrapper::find()->joinWith('translations')->where(['like', 'title', $q])->multilingual()->limit(20)->all();
//            foreach ($data as $d) {
//                $out['results'] = array ($d->id, $d->title);
//            }

            $query = TeamWrapper::find();

            $query->distinct()
                ->select('t.id, tr.title AS text')
                ->joinWith('content co')
                ->joinWith('content.translations tr')
                ->where(['like', 'tr.title', $q])
                ->from('tbl_team as t')
                ->limit(20);

            if (isset($_GET['competition_id'])) {
                $query->joinWith('competitionToTeams ct');
                $query->andWhere(['ct.competition_id' => $_GET['competition_id']]);
            }

            $out['results'] = $query->asArray()->all();
//            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => TeamWrapper::findOne(['id' => $id])->name];
        }
        return $out;
    }
}
