<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\event\listview;

use common\models\search\EventSearch;
use common\models\wrappers\EventWrapper;
use \common\widgets\items\listview\ListWidget as BaseListWidget;

class ListWidget extends BaseListWidget {
    public $event_date;
    public $show_id;
    public $location_id;
    public $eventSearchModel;


    public function init() {
        $this->eventSearchModel = new EventSearch();

        if (isset($this->show_id)) {
            $this->eventSearchModel->show_id = $this->show_id;
        }

        if (isset($this->location_id)) {
            $this->eventSearchModel->location_id = $this->location_id;
        }

        if (isset($this->event_date)) {
            $this->eventSearchModel->from_start_time = $this->event_date->format('Y-m-d') . ' 00:00';
            $this->eventSearchModel->to_start_time = $this->event_date->format('Y-m-d') . ' 23:59';
        }

        parent::init();
    }

    //test

    public function run() {
//        echo "EVENT_DATE:" . $this->event_date->format('d-m-Y');
        $this->list = $this->eventSearchModel->search([])->getModels();
        if (is_array($this->list) && count($this->list) && $this->view) {
            return $this->render($this->view);
        }
    }
}