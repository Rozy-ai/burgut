<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\items\lastPosts;

use common\models\wrappers\ItemWrapper;

class LastPosts extends \yii\base\Widget
{
    public $list = [];
    public $category = 'blog';
    public $view = 'lastPosts';
    public $limit = 3;
    public $message;


    public function init()
    {
        if ($this->category && (!isset($this->list) || count($this->list) == 0))
            $this->list = ItemWrapper::find()
                ->joinWith('category cat')
                ->joinWith('category.parent parent')
                ->joinWith('translations tr')
                ->distinct()
                ->where(['tbl_item.status' => 1])
                ->andWhere(['not', ['tr.title' => null]])
                ->andWhere(['tr.language'=>\Yii::$app->language])
                ->andWhere(['or', 'cat.code="' . $this->category . '"', 'parent.code="' . $this->category . '"'])
                ->orderBy('id desc')
                ->limit($this->limit)
                ->all();
        parent::init();
    }


    public function run()
    {
        if (is_array($this->list) && count($this->list) && $this->view) {
            return $this->render($this->view);
        }
    }
}