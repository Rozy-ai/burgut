<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\show\listview;

use common\models\search\EventSearch;
use common\models\search\ShowSearch;
use common\models\wrappers\EventWrapper;
use \common\widgets\items\listview\ListWidget as BaseListWidget;

class ListWidget extends BaseListWidget {
    public $showSearchModel;
    public $location_id;

    public function init() {
        $this->showSearchModel = new ShowSearch();
        if (isset($this->location_id)) {
            $this->showSearchModel->location_id = $this->location_id;
        }

        parent::init();
    }

    public function run() {
        $this->list = $this->showSearchModel->search([])->getModels();
        if (is_array($this->list) && count($this->list) && $this->view) {
            return $this->render($this->view);
        }
    }
}