<?php
namespace backend\controllers;

use common\models\Document;
use common\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class SiteController extends Controller {
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'upload', 'deleteupload'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            // change layout for error action
            if ($action->id == 'error') $this->layout = 'loginLayout';
            return true;
        } else {
            return false;
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

//
//    public function actionUpload() {
//        $fileName = 'file';
//        $uploadPath = Yii::getAlias('@uploads');
//
//        if (isset($_FILES[$fileName])) {
//            $file = \yii\web\UploadedFile::getInstanceByName($fileName);
//
//            //Print file data
//            //print_r($file);
//            $filename = md5(Yii::$app->user->id . microtime() . $file->name); //randomize filename
//            $filename .= "." . $file->getExtension();
//            if ($file->saveAs($uploadPath . '/' . $filename)) {
//                $document = new Document();
//                $document->org_filename = $file->name;
//                $document->filename = $filename;
//                $document->url = $uploadPath . '/' . $filename;
//                $document->type = $file->type;
//                $document->size = $file->size;
//
//                //Now save file data to database
//                if ($document->save()) ;
//                echo \yii\helpers\Json::encode($document->id);
////                echo \yii\helpers\Json::encode($file);
//            }
//        } else {
//            $result = array ();
//            $files = Document::find()->all();
//            if (isset($files)) {
//                foreach ($files as $file) {
//                    if (is_file($uploadPath . '/' . $file->filename)) {
//                        $obj['id'] = $file->id;
//                        $obj['name'] = $file->org_filename;
//                        $obj['size'] = filesize($uploadPath . '/' . $file->filename);
//                        $obj['url'] = Yii::$app->getHomeUrl() . 'web/uploads/' . $file->filename;
//                        $result[] = $obj;
//                    }
//                }
//            }
//
//            header('Content-type: text/json');              //3
//            header('Content-type: application/json');
//            echo json_encode($result);
//        }
//
//        return false;
//    }
//
//
//    public function actionDeleteupload() {
//        if (isset($_POST['fileId'])) {
//            if ($_POST['type'] == 'Avatar') {
//                $targetPath = Yii::getAlias('@uploads');
//            }
//
//            $document = Document::findOne($_POST['fileId']);
//            if ($document != null) {
//                if (unlink($targetPath . '/' . $document->filename)) {
//                    $document->delete();
//                }
//            }
//        }
//        return true;
//    }




}
