<?php

namespace backend\controllers;

use common\components\CommonController;
use common\models\wrappers\ItemWrapper;
use Yii;
use common\models\wrappers\ShowWrapper;
use common\models\search\ShowSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShowController implements the CRUD actions for ShowWrapper model.
 */
class ShowController extends CommonController
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
     * Lists all ShowWrapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShowSearch();
        if (!isset($_GET['sort'])) {
            $_GET['sort'] = '-id';
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShowWrapper model.
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
     * Creates a new ShowWrapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShowWrapper();
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
                    return $this->redirect(['view', 'id' => $model->id]);
                else{
                    echo "<pre> show model: ";
                    print_r($model->getErrors());
                    echo "</pre>";
                }
            }else{
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
     * Updates an existing ShowWrapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
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
                    return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $contentItemModel->docs = implode($this->trimNonexistentDocuments($contentItemModel->docs), ',');
        return $this->render('update', [
            'model' => $model,
            'contentItemModel' => $contentItemModel,
        ]);
    }

    /**
     * Deletes an existing ShowWrapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShowWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShowWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShowWrapper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
