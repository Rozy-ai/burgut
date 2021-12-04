<?php

namespace frontend\controllers;

use common\components\CommonController;
use common\models\search\LocationSearch;
use common\models\wrappers\CategoryWrapper;
use common\models\wrappers\CommentWrapper;
use common\models\wrappers\LocationWrapper;
use common\models\wrappers\MenuWrapper;
use Yii;
use common\models\wrappers\ItemWrapper;
use common\models\search\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for ItemWrapper model.
 */
class LocationController extends CommonController
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
        $searchModel = new LocationSearch();
        $searchModel->status = 1;
        $modelCategory = CategoryWrapper::findByPath($path);

        if (!isset($_GET['sort'])) {
            $_GET['sort'] = '-id';
        }

        if (isset($modelCategory)) {
            $children = $modelCategory->children;
            if (is_array($children) && count($children) == 0)
                $searchModel->category_id = $modelCategory->id;
            elseif (($modelCategory->parent_id == null || $modelCategory->parent_id == 0))
                $searchModel->parent_category_id = $modelCategory->id;
        }


        return $this->render('index', [
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

        return $this->render('view', [
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
        if (($model = LocationWrapper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
