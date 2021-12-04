<?php
namespace common\models\wrappers;

use common\components\Utf;
use common\models\Document;
use common\models\DocumentLang;
use common\models\Music;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\base\ErrorException;
use yii\image\drivers\Image;
use yii\image\ImageDriver;

/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 31.3.2017
 * Time: 4:25 PM
 */
class DocumentWrapper extends Document {

    public $uploadfolder = '';
    public $uploadsUrl = '';

    public function rules() {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['title', 'author'], 'string'],
            [['title', 'author', 'title_ru', 'author_ru', 'title_en', 'author_en', 'video_document_id'], 'safe'],
        ]);
    }


    public function attributeLabels() {
        return \yii\helpers\ArrayHelper::merge(parent::attributeLabels(), [
            'video_document_id' => Yii::t('app', 'Media Content'),
        ]);
    }


    public function behaviors() {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->urlManager->languages,
//                'languages' => [
//                    'tk' => 'Turkmen',
//                    'ru' => 'Russian',
//                    'en' => 'English',
//                ],
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                //'requireTranslations' => false',
                //'dynamicLangClass' => true',
                'langClassName' => DocumentLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => Yii::$app->language,
                'langForeignKey' => 'document_id',
                'tableName' => "{{%tbl_document_lang}}",
                'attributes' => [
                    'title', 'author',
                ]
            ],
        ];
    }

    public static function find() {
        return new MultilingualQuery(get_called_class());
    }


    public function getVideoDocument() {
        return $this->hasOne(DocumentWrapper::className(), ['id' => 'video_document_id']);
    }


    public function getThumb($width = null, $height = null, $type = "", $is_cropped = false, $with_watermark = true) {
        $type = explode('/', $this->type);
        $path = null;

        if (isset($type) && is_array($type)) {
            if ($type[0] == 'image') {
                return $this->resize($width, $height, $type, $is_cropped, $with_watermark);
            } else {
                $format = $type[1] . '.png';
                $uploadfolder = Yii::getAlias('@formaticons');
                if (file_exists($uploadfolder . "/" . $format) && is_file($uploadfolder . "/" . $format)) {
                    $path = $format;
                } else {
                    $format = 'no_format.png';
                    if (file_exists($uploadfolder . "/" . $format) && is_file($uploadfolder . "/" . $format)) {
                        $path = $format;
                    }
                }

                $this->uploadfolder = $uploadfolder;
                $this->uploadsUrl = Yii::getAlias('@uploadsUrl') . DIRECTORY_SEPARATOR . 'formaticons';
                if (isset($path)) {
                    $this->path = $path;
                    return $this->resize($width, $height, $type, $is_cropped, $with_watermark);
                }
            }
        }
    }


    public function resize($width, $height, $type = "", $is_cropped = false, $with_watermark = true) {


        switch ($type) {
            case "h":
                $type = Image::HEIGHT;
                break;
            case "w":
                $type = Image::WIDTH;
                break;
            case "auto":
                $type = Image::AUTO;
                break;
            default:
                $type = Image::CROP;
        }

        if (!isset($this->uploadfolder) || strlen(trim($this->uploadfolder)) == 0) {
            $uploadfolder = Yii::getAlias('@uploads');
        } else {
            $uploadfolder = $this->uploadfolder;
        }

        $filename = $this->path;
        if (!file_exists($uploadfolder . "/" . $filename))
            return false;

//        echo "</br>After fullpoath: ".$uploadfolder . "/" . $filename;

        $scale = 1;
        try {
            if (!isset($width) && !isset($height)) {
                list($width, $height) = getimagesize($uploadfolder . "/" . $filename);
            }


            if (isset($this->cropped_path) && strlen(trim($this->cropped_path)) > 0 && $is_cropped == true) {
                $filename = $this->cropped_path;
                if (file_exists($uploadfolder . "/" . $filename) && is_file($uploadfolder . "/" . $filename)) {
                    $datas = getimagesize($uploadfolder . "/" . $filename);
                    $scale = $width / $datas[0];
                    $width = $datas[0];
                    $height = $datas[1];
                }
            }

            $width = ($width * $scale);
            $height = ($height * $scale);
            if (!file_exists($uploadfolder . "/" . $filename) || !is_file($uploadfolder . "/" . $filename)) {
                return;
            }

            $info = pathinfo($filename);
            $extension = $info['extension'];


            $old_image = $filename;
            $utf = new Utf();
            $new_image = 'cache/' . $utf->utf8_substr($filename, 0, $utf->utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . $type . '.' . $extension;

            if (!file_exists($uploadfolder . "/" . $new_image) || (filemtime($uploadfolder . "/" . $old_image) > filemtime($uploadfolder . "/" . $new_image))) {
                $path = '';
                $directories = explode('/', dirname(str_replace('../', '', $new_image)));

                foreach ($directories as $directory) {
                    $path = $path . '/' . $directory;

                    if (!file_exists($uploadfolder . "/" . $path)) {
                        @mkdir($uploadfolder . "/" . $path, 0777);
                    }
                }

                list($width_orig, $height_orig) = getimagesize($uploadfolder . "/" . $old_image);
                $ext = pathinfo($uploadfolder . "/" . $old_image, PATHINFO_EXTENSION);

                if (($width_orig != $width || $height_orig != $height) && $ext != 'swf') {
                    //                https://github.com/yurkinx/yii2-image
//                $file=Yii::getAlias($uploadfolder ."/". $old_image);
                    try {
                        $image = Yii::$app->image->load($uploadfolder . "/" . $old_image);
                        $image->resize($width, $height, $type);
//                        $image->sharpen(40);

                        if (($width > 450 || $height > 400) && $with_watermark == true) {
                            if (file_exists($uploadfolder . "/" . 'watermark.png')) {
                                $mark = $image = Yii::$app->image->load($uploadfolder . "/" . 'watermark.png');
                                $image->watermark($mark, 1, 1, 70);
                            }
                        }

                        $image->save($uploadfolder . "/" . $new_image, 100);
                    } catch (ErrorException $ex) {
                        return "";
                    }
                } else {
                    copy($uploadfolder . "/" . $old_image, $uploadfolder . "/" . $new_image);
                }
            }


            if (!isset($this->uploadsUrl) || strlen(trim($this->uploadsUrl)) == 0) {
                $uploadsUrl = Yii::getAlias('@uploadsUrl');
            } else {
                $uploadsUrl = $this->uploadsUrl;
            }
            $thumb = $uploadsUrl . '/' . $new_image;

            return str_replace('\\', '/', $thumb);
        } catch (Exception $e) {
            return "";
        }
    }


    public function getFullPath() {
        if (!isset($this->uploadfolder) || strlen(trim($this->uploadfolder)) == 0) {
            $uploadfolder = Yii::getAlias('@uploads');
        } else {
            $uploadfolder = $this->uploadfolder;
        }

        $filename = $this->path;

        if (!file_exists($uploadfolder . "/" . $filename) || !is_file($uploadfolder . "/" . $filename)) {
            return "";
        } else {
            $uploadsUrl = Yii::getAlias('@uploadsUrl');
            $path = $uploadsUrl . '/' . $filename;

//            $utf = new Utf();
//            $webrootPath = Yii::getAlias('@mysite');
//            $path = $webrootPath . "/" . substr($uploadfolder, strlen($webrootPath)) . '/' . $filename;
////            $path = '/maro/uploads/' . $filename;
            return $path;
        }
    }


    public function createCroppedImage($cropped_path, $realWidth, $width = 1, $height = 0, $x = 0, $y = 0, $ratio = 0.75) {
        if (!isset($this->uploadfolder) || strlen(trim($this->uploadfolder)) == 0) {
            $uploadfolder = Yii::getAlias('@uploads');
        } else {
            $uploadfolder = $this->uploadfolder;
        }

        $image = $uploadfolder . '/' . $this->path;
        $thumbname = $uploadfolder . '/' . $cropped_path;


        if (!file_exists($image))
            return false;


        if ($width == 1 || $height == 0) {
            $datas = getimagesize($image);
            $height = $datas[1];
            $width = $height * $ratio;
        }

        if ($realWidth > $width)
            $realWidth = $width;

        $scale = $realWidth / $width;
        $newWidth = ceil($width * $scale);
        $newHeight = ceil($height * $scale);

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        //saving the image into memory (for manipulation with GD Library)
        $exploded = explode('.', $image);
        $ext = $exploded[count($exploded) - 1];

        if (preg_match('/jpg|jpeg/i', $ext)) {
            $source = imagecreatefromjpeg($image);
        } else if (preg_match('/png/i', $ext))
            $source = imagecreatefrompng($image);
        else if (preg_match('/gif/i', $ext))
            $source = imagecreatefromgif($image);
        else if (preg_match('/bmp/i', $ext))
            $source = imagecreatefrombmp($image);
        else
            return 0;


//        $source = imagecreatefromjpeg($image);
        if (imagecopyresampled($newImage, $source, 0, 0, $x, $y, $newWidth, $newHeight, $width, $height)) {
            if (imagejpeg($newImage, $thumbname, 100)) {
                imagedestroy($source);
                chmod($thumbname, 0777);
                return true;
            }
        }
        return false;
    }


    public function deleteImagePath($path) {
        $uploadfolder = trim(Yii::getAlias('@uploads'), '/');
        if (isset($path) && file_exists($uploadfolder . '/' . $path)) {
            $realUrl = $uploadfolder . '/' . $path;
            if (file_exists($realUrl))
                unlink($realUrl);
        } else
            return false;
    }


    public function fullDelete($related_table_name = null) {
        if (!isset($this->id))
            return;

        $uploadfolder = trim(Yii::getAlias('@uploads'), '/');
        $file = realpath($uploadfolder . $this->path);
        if (is_file($file)) {
            unlink($file);
        }


        if (isset($related_table_name) && strlen(trim($related_table_name)) > 0) {
            $this->removeFromRelationsTable($related_table_name, $this->id);
        }
        return $this->delete();
    }


    public function removeFromRelationsTable($tablename, $documentId) {
        $sql = "DELETE FROM " . $tablename . " WHERE document_id=:documentId";
        echo "</br>Remove from relation table docId: " . $documentId;
        echo "</br>sql: " . $sql;

        $command = Yii::$app->db->createCommand($sql);
        $command->bindValue(":documentId", $documentId, \PDO::PARAM_INT);
        return $command->execute();
    }


    function filesize() {
        $uploadfolder = Yii::getAlias('@uploads');
        $filename = $this->path;
        $path = $uploadfolder . DIRECTORY_SEPARATOR . $filename;

        if (is_file($path)) {
            $size = filesize($path);
            $units = array ('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $power = $size > 0 ? floor(log($size, 1024)) : 0;
            return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
        }
    }

}