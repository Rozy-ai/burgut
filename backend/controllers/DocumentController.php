<?php

namespace backend\controllers;

use common\components\CommonController;
use common\models\Document;
use common\models\search\DocumentSearch;
use common\models\wrappers\DocumentWrapper;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends CommonController {

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
     * Lists all Document models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Document model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Document model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Document();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Document model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->load($post);
            if ($model->save()) {
                Yii::$app->end(1);
            }
        }
        return $this->renderAjax('dialog', [
                'model' => $model,
            ]);
        }

    /**
     * Deletes an existing Document model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Document the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = DocumentWrapper::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionCrop($id) {
        $returnUrl = '';
        $ratios = [
            ['width' => 16, 'height' => 9],
            ['width' => 4, 'height' => 3],
            ['width' => 1, 'height' => 1],
            ['width' => 2, 'height' => 3],
            ['width' => '', 'height' => ''],
        ];

        if ($_GET['returnUrl']) {
            $returnUrl = $_GET['returnUrl'];
        }

        if ($_GET['ratios']) {
            $ratios = unserialize($_GET['ratios']);
        }


        return $this->render('crop', [
            'model' => $this->findModel($id),
            'returnUrl' => $returnUrl,
            'ratios' => $ratios,
        ]);
    }


    public function actionAjaxCrop() {
        header('Content-type: text/json');
        header('Content-type: application/json');
        $result = ['status' => 'error'];

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $x = $_POST["x"];
            $y = $_POST["y"];
            $width = $_POST["width"];
            $height = $_POST["height"];

            $uploadfolder = trim(Yii::getAlias('@uploads'), DIRECTORY_SEPARATOR);
            $uploadfolder = DIRECTORY_SEPARATOR . $uploadfolder;

            $model = DocumentWrapper::find()->where(['id' => $id])->one();
            if (isset($model->cropped_path) && file_exists($uploadfolder . $model->cropped_path))
                $model->deleteImagePath($model->cropped_path);
            if (isset($model->path)) {
                $model->path = str_replace('\\', '/', $model->path);
                $path_array = array_reverse(explode('/', $model->path));
                $cropped_path = trim($model->path, $path_array[0]) . 'cropped_' . $path_array[0];

                if ($model->createCroppedImage($cropped_path, 2000, $width, $height, $x, $y)) {
                    $model->cropped_path = $cropped_path;
                    if ($model->save(false, ["cropped_path"])) {
                        $result['status'] = 'success';
                        $result['message'] = Yii::t('backend', 'Succesfully cropped');
                    }
                }
            }
        }
        echo json_encode($result);
    }


    public function actionUpload() {
        $fileName = 'file';
//        $uploadPath = trim(Yii::getAlias('@uploads'), DIRECTORY_SEPARATOR);
        $uploadPath = Yii::getAlias('@uploads');
        $folder = '';

        if (isset($_POST['folder'])) {
            $folder = $_POST['folder'];
            $tempUploadPath = $uploadPath . DIRECTORY_SEPARATOR . $folder;
            if (!is_dir($tempUploadPath)) {
                mkdir($tempUploadPath, 0755, true);
            }
        }

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            $filename = md5(Yii::$app->user->id . microtime() . $file->name); //randomize filename
            $filename .= "." . $file->getExtension();
            $path = trim($folder . DIRECTORY_SEPARATOR . $filename, DIRECTORY_SEPARATOR);
            if ($file->saveAs($uploadPath . DIRECTORY_SEPARATOR . $path)) {
                $document = new DocumentWrapper();
                $document->org_filename = $file->name;
                $document->filename = $filename;
                $document->path = $path;
                $document->type = $file->type;
                $document->size = $file->size;

                //Now save file data to database
                if ($document->save()) {
                    if (file_exists($uploadPath . DIRECTORY_SEPARATOR . $path)) {
                        echo \yii\helpers\Json::encode($document->id);
                    }
                } else {
                    echo "Document not saved <pre>";
                    print_r($document->getErrors());
                    echo "</pre>";
                }
            } else {
                echo 'File not saved';
            }
        } else {
            $result = array ();
            $files = DocumentWrapper::find()->all();
            if (isset($files)) {
                foreach ($files as $file) {
                    if (is_file($uploadPath . '/' . $file->filename)) {
                        $obj['id'] = $file->id;
                        $obj['name'] = $file->org_filename;
                        $obj['size'] = filesize($uploadPath . '/' . $file->filename);
                        $obj['url'] = Yii::$app->getHomeUrl() . 'uploads/' . $file->filename;
                        $result[] = $obj;
                    }
                }
            }

            header('Content-type: text/json');              //3
            header('Content-type: application/json');
            echo json_encode($result);
        }

        return false;
    }


    public function actionDeleteupload() {
        if (isset($_POST['fileId'])) {
            if ($_POST['type'] == 'Avatar') {
                $targetPath = Yii::getAlias('@uploads');
            }

            $document = Document::findOne($_POST['fileId']);
            if ($document != null) {
                if (unlink($targetPath . '/' . $document->filename)) {
                    $document->delete();
                }
            }
        }
        return true;
    }
}
