<?php
namespace common\components;

use common\models\wrappers\DocumentWrapper;
use yii\filters\AccessControl;
use Yii;
use DateTime;
use DateTimeZone;

class CommonController extends \yii\web\Controller {
    //put your code here

    // public function behaviors() {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                     'matchCallback' => function ($rule, $action) {
    //                         $permission = Yii::$app->controller->module->id . '/' . Yii::$app->controller->id . '/' . $action->id;
    //                         $commonPermission = Yii::$app->controller->module->id . '/' . Yii::$app->controller->id . '/*';
    //                         return Yii::$app->user->can($permission) || Yii::$app->user->can($commonPermission);
    //                     },
    //                 ],

    //                 [
    //                     'allow' => true,
    //                     'roles' => ['?'],
    //                     'matchCallback' => function ($rule, $action) {
    //                         $guestRole = \Yii::$app->authManager->getRole('guest');
    //                         $permission = \Yii::$app->authManager->getPermission(Yii::$app->controller->module->id . '/' . Yii::$app->controller->id . '/' . $action->id);
    //                         if (isset($guestRole) && isset($permission)) {
    //                             if (\Yii::$app->authManager->hasChild($guestRole, $permission)) {
    //                                 return true;
    //                             }
    //                             return false;
    //                         } else
    //                             return false;
    //                     },
    //                 ],
    //             ],
    //         ],
    //     ];
    // }


    public function init() {
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        date_default_timezone_set('Asia/Ashgabat');
//        ini_set("sendmail_form", "no-reply@turkmenportal.com");
//            if(isset(Yii::app()->session['lang']))
//                Yii::app()->setLanguage(Yii::app()->session['lang']);
//                Yii::app()->setLanguage('tm');

//
//        $_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
//        $_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl . "/images/uploads/"; // URL for the uploads folder
//        $_SESSION['KCFINDER']['uploadDir'] = Yii::app()->basePath . "/../images/uploads/"; // path to the uploads
//            $this->meta_description=Yii::t('app', 'site_name');
        parent::init();
    }


    public function trimNonexistentDocuments($docs = []) {
        $exists = [];
        if (is_array($docs)) {
            foreach ($docs as $docId) {
                $document = DocumentWrapper::findOne(['id' => $docId]);
                if (isset($document)) {
                    $path = $document->getFullPath();
                    if (isset($path) && strlen(trim($path)) > 0) {
                        $exists[] = $docId;
                    }
                }
            }
        }
        return $exists;
    }


    public function truncate($input, $maxWords, $maxChars) {
//            $words = preg_split('/\s+/', $input);
        $words = explode(' ', $input);
        $words = array_slice($words, 0, $maxWords);
        $words = array_reverse($words);

        $chars = 0;
        $truncated = array ();

        while (count($words) > 0) {
            $fragment = trim(array_pop($words));
            $chars += strlen($fragment);

            if ($chars > $maxChars) break;

            $truncated[] = $fragment;
        }

        $result = implode($truncated, ' ');

        return $result . ($input == $result ? '' : '...');
//            return $input;
    }

    public function phoneNumber($input) {
        $numbers = $input.' ';
        $len =strlen($numbers);
        $l = 0;
        $k = 0;
        $j = 0;
        for ($i=0; $i < $len ; $i++) {
            if ($k==2 ) {
                $j=0;
                $k=0;
                $phone_numbers[]= mb_strcut($numbers,$l,$i-$l);
                $l=$i;
            }
            if ($j==2) {
                $k++;
            }
            if ($numbers[$i] == '-') {
                $j++;
            }
        }
        return $phone_numbers;
    }


    public static function getFragment($text, $word) {
        if ($word) {
            $pos = max(mb_stripos($text, $word, null, 'UTF-8') - 100, 0);
            $fragment = mb_substr($text, $pos, 200, 'UTF-8');
            $highlighted = str_ireplace($word, '<mark>' . $word . '</mark>', $fragment);
        } else {
            $highlighted = mb_substr($text, 0, 200, 'UTF-8');
        }
        return $highlighted . (strlen($text) == strlen($highlighted) ? '' : '...');
    }


    public function dateToW3C($date) {
        if (is_int($date))
            return date(DATE_W3C, $date);
        else
            return date(DATE_W3C, strtotime($date));
    }


    public function renderDate($mydate, $raw = false) {
        $mydate = new DateTime($mydate);
        $mydate->setTimezone(new DateTimeZone("Asia/Ashgabat"));
        $day_name = $mydate->format("d/m/Y");
        $time = $mydate->format("H:i");
        $mydate_ts = $mydate->getTimestamp();


        if (!$raw) {
            if ($mydate_ts >= strtotime('today'))
                $day_name = Yii::t('app', 'today') . ' ' . $time;
            else if ($mydate_ts >= strtotime('yesterday'))
                $day_name = Yii::t('app', 'yesterday') . ' ' . $time;
        }

        return $day_name;
    }


    public function renderDateTime($date, $raw = false, $time_format = 'H:i', $date_format = 'd.m.Y') {
        $time_str = '';
        $date_str = '';
        if (is_int($date)) {
            $time_str = date($time_format, $date);
            $date_str = date($date_format, $date);
        } else {
            $time_str = date($time_format, strtotime($date));
            $date_str = date($date_format, strtotime($date));
        }
        if ($raw) {
            return $time_str . ' ' . $date_str;
        } else
            return '<span class="article_header_time">' . $time_str . '</span>' . $date_str;
    }


    public function renderDateToWord($date, $moth_format = 'm', $year_format = 'Y') {
        $date_str = '';
        $months = array (
            "tk" => array ("", 'Ýanwar', 'Fewral', 'Mart', 'Aprel', 'Maý', 'Iýun', 'Iýul', 'Awgust', 'Sentýabr', 'Oktýabr', 'Noýabr', 'Dekabr'),
            "ru" => array ("", 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'),
            "en" => array ("", 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
        );

        if (!is_int($date)) {
            $date = strtotime($date);
        }

        $str = date('d', $date);
        if (isset($moth_format))
            $str = $str . " " . $months[Yii::$app->language][ltrim(date($moth_format, $date), "0")];
        if (isset($year_format))
            $str = $str . " " . date($year_format, $date);

        return $str;
    }

    public  function filesize_formatted($size)
    {
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

}