<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\items\recent;
use common\models\wrappers\ItemWrapper;

class RecentPosts  extends \yii\base\Widget{
    public $items= [];
    public $count= 3;
    public $category= 'blog';

    public function init() {
        if ($this->category)
            $this->items = ItemWrapper::find()
                ->joinWith('category cat')
                ->joinWith('category.parent parent')
                ->joinWith('translations tr')
                ->distinct()
                ->where(['tbl_item.status' => 1])
                ->andWhere(['not', ['tr.title' => null]])
                ->andWhere(['tr.language'=>\Yii::$app->language])
                ->andWhere(['or', 'cat.code="' . $this->category . '"', 'parent.code="' . $this->category . '"'])
                ->orderBy('date_created')
                ->limit($this->count)
                ->all();
        parent::init();
    }


    public function run()
    {
        if(isset($this->items))
            return $this->render('recent-items');
    }
}