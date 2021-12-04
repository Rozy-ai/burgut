<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\carousel\cart;

use common\models\search\EventSearch;
use common\models\wrappers\EventWrapper;
use common\models\wrappers\ItemWrapper;
use common\widgets\items\listview\ListWidget;
use yii\data\Sort;

class EventCarousel extends ListWidget
{

    public function init()
    {
        $view = $this->getView();
        CarouselAsset::register($view);

        $eventSearchModel = new EventSearch();
        $startDate = new \DateTime();
//        $startDate->modify('-3 day');

        $eventSearchModel->afterStartDatetime = $startDate;
        $dataProvider = $eventSearchModel->search([]);
        $dataProvider->setSort([
            'defaultOrder' => ['start_time' => SORT_ASC]
        ]);

        $this->list = $dataProvider->getModels();
//        $this->list = EventWrapper::find()->where(['tbl_item.status' => 1])->andWhere(['or', 'cat.code="' . $this->category . '"', 'parent.code="' . $this->category . '"'])->orderBy('id desc')->limit($this->limit)->all();
        parent::init();
    }


    public function run()
    {
        if (is_array($this->list) && count($this->list) && $this->view)
            return $this->render($this->view);
    }
}