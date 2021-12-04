<?php
namespace common\widgets\category;

use common\models\wrappers\CategoryWrapper;
use yii\base\Widget;

class CategoryHeaderWidget extends Widget {
    public $maxSubCatCount;
    public $category_id;
    public $category_code;
    public $categoy_index_url;
    public $cssClass;
    public $showAllText;
    public $override_main_title;

    public function init() {
        if (!isset($this->maxSubCatCount)) {
            $this->maxSubCatCount = 5;
        }

        if (!isset($this->cssClass)) {
            $this->cssClass = "box_header_index";
        }
        parent::init();
    }


    public function run() {
        $sub_categories = array ();
        $query = CategoryWrapper::find();
        $query->andWhere([
            'code' => $this->category_code,
            'status' => 1
        ])->multilingual()->orderBy('sort_order');

        $categoryModels = $query->all();

//        $criteria->scopes = array ('enabled', 'sort_by_sort_order');
//        $categoryModels = Category::model()->cache(Yii::app()->params['cache_duration'], new CTagCacheDependency('Category'))->findAll($criteria);

        $categoryModel = null;
        foreach ($categoryModels as $cat) {
            if ($cat->parent_id == null && $cat->status == 1)
                $categoryModel = $cat;
            else if ($cat->status == 1) {
                $sub_categories[] = $cat;
            }
        }

        if (!isset($categoryModel))
            $categoryModel = array_shift($sub_categories);

        $sub_categories = array_slice($sub_categories, 0, $this->maxSubCatCount);


        if (isset ($categoryModel)) {
            return $this->render('CategoryHeaderWidget', ['sub_categories' => $sub_categories, 'categoryModel' => $categoryModel]);
        }
    }

}

?>
