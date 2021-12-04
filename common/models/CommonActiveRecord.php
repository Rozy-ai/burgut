<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 10:34 AM
 */

namespace common\models;


use common\models\wrappers\AlbumWrapper;
use common\models\wrappers\CategoryWrapper;
use common\models\wrappers\DocumentWrapper;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class CommonActiveRecord extends ActiveRecord
{

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->hasAttribute('date_created') && $this->hasAttribute('date_modified')) {
                if ($insert) {
                    if (!isset($this->date_created) || strlen(trim($this->date_created)) == 0)
                        $this->date_created = \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
                    if (!isset($this->date_modified) || strlen(trim($this->date_modified)) == 0)
                        $this->date_modified = \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
                } else {
                    if (!isset($this->date_modified) || strlen(trim($this->date_modified)) == 0)
                        $this->date_modified = \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
                    else {
                        $this->date_modified = isset($this->date_modified) ? \Yii::$app->formatter->asDate($this->date_modified, 'yyyy-MM-dd HH:mm:ss') : \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
                        $this->date_created = isset($this->date_created) ? \Yii::$app->formatter->asDate($this->date_created, 'yyyy-MM-dd HH:mm:ss') : \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
                    }
                }
            }

            return true;
        } else {
            return false;
        }
    }


    public function makeMockFiles($documents = [])
    {
        $result = [];
        $uploadPath = \Yii::getAlias('@uploads');
        foreach ($documents as $document) {
            if (is_file($uploadPath . '/' . $document->path)) {
                $obj['id'] = $document->id;
                $obj['name'] = $document->org_filename;
                $obj['size'] = filesize($uploadPath . '/' . $document->path);
//                $obj['url'] = Yii::$app->getHomeUrl().'web/uploads/'.$file->filename;
                $obj['url'] = $document->getThumb(120, 120);
                $result[] = $obj;
            }
        }

        return $result;
    }


    public function getAlbumList()
    {
        return ArrayHelper::map(AlbumWrapper::find()->all(), 'id', 'name');
    }


    public function getCategoryList()
    {
        return ArrayHelper::map(CategoryWrapper::find()->all(), 'id', 'name');
    }

    public function getCategoryCodeDataList()
    {
        $dataList = [];
        $categories = CategoryWrapper::find()->all();
        foreach ($categories as $category) {
            $dataList[$category->id] = ['data-code' => $category->code];
        }
        return $dataList;
    }


    public function getParentCategoryList($except = [])
    {
        $list = ArrayHelper::map(CategoryWrapper::find()->all(), 'id', 'name');
        if ($except && !is_array($except)) {
            $except = [$except];
        }

        if (is_array($except) && count($except) > 0) {
            foreach ($except as $id) {
                if (isset($id)) {
                    unset($list[$id]);
                }
            }
        }
        return $list;
    }

    public function getThumbPath($width = null, $height = null, $type = '', $is_cropped = false, $with_watermark = false, $with_no_image = false, $code = null)
    {
        $thumb = "";
        $documents = $this->documents;
        if (isset ($documents) && is_array($documents) && count($documents) > 0) {
            $document = $documents[0];
            if (isset($code)) {
                foreach ($documents as $docs) {
                    if ($docs->code == $code)
                        $document = $docs;
                }
            } elseif (isset($document->code)) {
                foreach ($documents as $docs) {
                    if (!$docs->code || $docs->code == '')
                        $document = $docs;
                }
            }



            if (isset($document->name))
                $this->photo_name = $document->name;

            $thumb = $document->resize($width, $height, $type, $is_cropped, $with_watermark);
        }

        if ($with_no_image == true && strlen(trim($thumb)) == 0) {
            $document = new DocumentWrapper();
            $document->path = 'no_image.jpg';
            $document->filename = 'no_photo';

            $thumb = $document->resize($width, $height, $type, $is_cropped, $with_watermark);
        }
        return $thumb;
    }


    public function formatDate($date, $format = 'dd/MM/yyyy')
    {
        return \Yii::$app->formatter->asDate($date, $format);
    }


    public function renderDateToWord($date)
    {
        $months = array(
            "tk" => array("", 'Ýanwar', 'Fewral', 'Mart', 'Aprel', 'Maý', 'Iýun', 'Iýul', 'Awgust', 'Sentýabr', 'Oktýabr', 'Noýabr', 'Dekabr'),
            "ru" => array("", 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'),
            "en" => array("", 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
        );

        if (!is_int($date)) {
            $date = strtotime($date);
        }


        $str = date('d', $date) . " " . $months[\Yii::$app->language][ltrim(date('m', $date), "0")] . " " . date('Y', $date);
        return $str;
    }



    const GENDER_MALE = 1, GENDER_FEMALE = 2;


    public function getGenderText() {
        $options = $this->getGenderOptions();
        return isset($options[$this->gender]) ? $options[$this->gender] : '';
    }

    public static function getGenderOptions() {
        return array (
            self::GENDER_MALE => \Yii::t('app', 'GENDER_MALE'),
            self::GENDER_FEMALE => \Yii::t('app', 'GENDER_FEMALE'),
        );
    }

}