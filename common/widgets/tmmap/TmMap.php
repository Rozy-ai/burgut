<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\tmmap;
use common\models\wrappers\ImageWrapper;
use common\widgets\items\listview\ListWidget;

class TmMap extends ListWidget {
    public function init() {
        $view = $this->getView();
        TmMapAsset::register($view);
        parent::init();
    }


    public function run() {
        if (is_array($this->list) && count($this->list) && $this->view) {
            return $this->render($this->view);
        }
    }
}