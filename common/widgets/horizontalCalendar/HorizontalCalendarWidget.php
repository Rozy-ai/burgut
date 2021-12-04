<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\horizontalCalendar;

use common\models\wrappers\ImageWrapper;

class HorizontalCalendarWidget extends \yii\base\Widget {
    public $refresh_class;

    public function init() {
        $view = $this->getView();
        HorizontalCalendarAsset::register($view);
        parent::init();
    }


    public function run() {
        return $this->render('HorizontalCalendarWidget');
    }
}