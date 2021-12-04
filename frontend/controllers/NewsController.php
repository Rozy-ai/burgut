<?php

namespace frontend\controllers;

use common\components\CommonController;
use common\models\wrappers\CategoryWrapper;
use common\models\wrappers\CommentWrapper;
use common\models\wrappers\MenuWrapper;
use Yii;
use common\models\wrappers\ItemWrapper;
use common\models\search\ItemSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for ItemWrapper model.
 */
class NewsController extends CommonController
{
    public $layout = 'bootstrap';

    /**
     * @inheritdoc
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
     * Lists all ItemWrapper models.
     * @return mixed
     */
    public function actionIndex($path = null, $category_id = null)
    {
        $searchModel = new ItemSearch();
        $searchModel->status = 1;
        $searchModel->isOnlyLanguageExist = true;
        $modelCategory = CategoryWrapper::findByPath($path);

        if (!isset($_GET['sort'])) {
            $_GET['sort'] = '-id';
        }


        if (isset($_GET['pub_date'])) {
            $searchModel->pub_date = $_GET['pub_date'];
            $old_date = strtotime($_GET['pub_date']);
            $_GET['pub_date'] = date('d-m-Y', $old_date);

            //if pub_date is not empty it means to show archive news so changing category to news
            $modelCategory = CategoryWrapper::find()->where(['code' => 'news'])->one();
        }


        if (isset($modelCategory)) {
            $children = $modelCategory->children;
            if (is_array($children) && count($children) == 0)
                $searchModel->category_id = $modelCategory->id;
//            elseif (($modelCategory->parent_id == null || $modelCategory->parent_id == 0))
            else {
                $child_ids = ArrayHelper::map($children, 'id', 'id');
                $child_ids[] = $modelCategory->id;
                $searchModel->category_ids = $child_ids;
            }
        }



        $viewpath = 'index';
        if (isset($modelCategory) && $modelCategory->code == 'location')
            $viewpath = 'location/index';

        return $this->render($viewpath, [
            'searchModel' => $searchModel,
            'modelCategory' => $modelCategory,
        ]);
    }


    /**
     * Displays a single ItemWrapper model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->updateCounters(['visited_count' => 1]);
        $modelCategory = $model->category;

        $viewpath = 'view';
        if (isset($modelCategory) && $modelCategory->code == 'location')
            $viewpath = 'location/view';

        return $this->render($viewpath, [
            'model' => $model,
        ]);
    }

    /**
     * Finds the ItemWrapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemWrapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionAddComment()
    {
        $commentModel = new CommentWrapper();
        $user = Yii::$app->user->identity;
        $post = Yii::$app->request->post();


        if (isset($post['CommentWrapper']['item_id'])) {
            $itemModel = ItemWrapper::find()->where(['id' => $post['CommentWrapper']['item_id']])->one();
            if (isset($itemModel)) {
                $commentModel->load($post);
                $commentModel->items_rel = array($itemModel->id);
                if ($commentModel->save()) {
                    $commentsModel = $itemModel->comments;
                    $show_form = false;
                    return $this->renderAjax('//comment/index', ['commentsModel' => $commentsModel, 'show_form' => $show_form]);
                }
            }
        }
    }
}
