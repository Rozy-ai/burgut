<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\carousel\cart;

use common\models\Competition;
use common\models\search\CompetitionSearch;
use common\models\search\EventSearch;
use common\models\wrappers\EventWrapper;
use common\models\wrappers\ItemWrapper;
use common\widgets\items\listview\ListWidget;
use yii\data\Sort;

class CompetitionCarousel extends \yii\base\Widget {

    public $list = [];
    public $item_class;
    public $view;
    public $limit;
    public $show_all_title;
    public $show_all_url;
    public $widget_title;

    public function init() {
        $view = $this->getView();
        CarouselAsset::register($view);

        $competitionSearch = new CompetitionSearch();
        $startDate = new \DateTime();
        $competitionSearch->is_active = true;
        $dataProvider = $competitionSearch->search([]);
//        $dataProvider->setSort([
//            'defaultOrder' => ['s.start_date' => SORT_ASC]
//        ]);

        $this->list = $dataProvider->getModels();
//        $this->list = EventWrapper::find()->where(['tbl_item.status' => 1])->andWhere(['or', 'cat.code="' . $this->category . '"', 'parent.code="' . $this->category . '"'])->orderBy('id desc')->limit($this->limit)->all();
        parent::init();
    }


    public function run() {
        if (is_array($this->list) && count($this->list) && $this->view)
            return $this->render($this->view);
    }
}