<?php

namespace common\widgets\slick;

use common\widgets\items\listview\ListWidget;

class Slick extends ListWidget {

    public function init() {
        $view = $this->getView();
        SlickAsset::register($view);
        parent::init();
    }


    public function run() {
        if (is_array($this->list) && count($this->list) && $this->view)
            return $this->render($this->view);
    }
}
