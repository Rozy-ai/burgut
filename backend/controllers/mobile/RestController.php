<?php

namespace backend\controllers\mobile;

use common\components\Common;
use common\components\CommonController;
use common\models\Document;
use common\models\Room;
use common\models\wrappers\DocumentWrapper;
use common\models\wrappers\LocationWrapper;
use common\models\wrappers\RoomWrapper;
use dektrium\user\models\User;
use frontend\models\SearchForm;
use Yii;
use common\models\wrappers\FlatOfferWrapper;
use common\models\search\FlatOfferSearch;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\rest\Serializer;

/**
 * FlatOfferController implements the CRUD actions for FlatOfferWrapper model.
 */
class RestController extends Controller
{

    public function beforeAction($action)
    {
//        if($action->id = 'my-action') {
        Yii::$app->request->enableCsrfValidation = false;
//        }
        return parent::beforeAction($action);
    }


    public function upload()
    {
        $document_ids = [];
        $uploadPath = Yii::getAlias('@uploads');
        if (isset($_FILES)) {
            foreach ($_FILES as $name => $tempFile) {
                $file = \yii\web\UploadedFile::getInstanceByName($name);

                //Print file data
                //print_r($file);
                $filename = md5(Yii::$app->user->id . microtime() . $file->name); //randomize filename
                $filename .= "." . $file->getExtension();
                if ($file->saveAs($uploadPath . '/' . $filename)) {
                    $document = new Document();
                    $document->org_filename = $file->name;
                    $document->filename = $filename;
                    $document->path = $filename;
                    $document->type = mime_content_type($uploadPath . '/' . $filename);
//                    $document->type = $file->type;
                    $document->size = $file->size;

                    //Now save file data to database
                    if ($document->save()) {
                        $document_ids[] = $document->id;
                    }
                }
            }
        }

        return $document_ids;
    }
}
