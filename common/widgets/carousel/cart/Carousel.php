<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\carousel\cart;

use common\models\wrappers\ItemWrapper;
use common\widgets\items\listview\ListWidget;

class Carousel extends ListWidget {


    public function init() {
        $view = $this->getView();
        CarouselAsset::register($view);
        parent::init();
    }


    public function run() {
        if (is_array($this->list) && count($this->list) && $this->view)
            return $this->render($this->view);
    }
}