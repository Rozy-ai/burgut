<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\items\works\main;

use common\models\wrappers\ItemWrapper;
use common\widgets\items\listview\ListWidget;

class Works extends ListWidget
{
    public $items = [];
    public $category = 'our_works';
    public $view = 'works-slider-index';
    public $limit = 6;
    public $widget_title;

    public function init()
    {
        parent::init();
        if ($this->category) {
            if (isset($this->list) && count($this->list) > 0) {
                $this->items = $this->list;
            } else {
                $this->items = ItemWrapper::find()
                    ->joinWith('category cat')
                    ->joinWith('category.parent parent')
                    ->joinWith('translations tr')
                    ->distinct()
                    ->where(['tbl_item.status' => 1])
                    ->andWhere(['not', ['tr.title' => null]])
                    ->andWhere(['tr.language' => \Yii::$app->language])
                    ->andWhere(['or', 'cat.code="' . $this->category . '"', 'parent.code="' . $this->category . '"'])
                    ->orderBy('is_main desc, id desc')
                    ->limit($this->limit)
                    ->all();
            }
        }
    }


    public function run()
    {
        if (is_array($this->items) && count($this->items) && $this->view)
            return $this->render($this->view);
    }
}