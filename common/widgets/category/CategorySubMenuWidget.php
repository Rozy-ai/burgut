<?php
class CategorySubMenuWidget extends CWidget
{
    public $count;
    public $category_code;
    public $parent_category_code;
    public $category_id;
    public $itemCssClass;
    public $categoryModel;
    public $subCategoryModels;
    public $relatedCategoryModels;
    public $show_photo;
    public $wrapperCssClass;
    public $relatedActiveRecord;


    
    
    public function init() {
        $this->categoryModel=new Category();
        $this->categoryModel->unsetAttributes();
        
        if(isset ($this->category_id)){
            $this->categoryModel = Category::model()->findByPk($this->category_id);
        }elseif(isset ($this->category_code)){
            $this->categoryModel = Category::model()->no_parent()->findByAttributes(array('code'=>$this->category_code));
        }
        
        if(isset($this->categoryModel)){
            $this->subCategoryModels=Category::model()->findAllByAttributes(array('status'=>1,'parent_id'=>$this->categoryModel->id));
            $this->relatedCategoryModels=Category::model()->findAllByAttributes(array('status'=>1,'related_category_id'=>$this->categoryModel->id));
        }
//            $this->subCategoryModels=$this->categoryModel->children;
        
        if(!isset($this->show_photo))
            $this->show_photo=false;

        if(isset($this->relatedActiveRecord)){
            $this->relatedActiveRecord=CActiveRecord::model($this->relatedActiveRecord);
        }

        parent::init();
    }
    
    
    
    public function run()
    {
        if(isset($this->subCategoryModels) && count($this->subCategoryModels)>0)
            $this->render('CategorySubMenuWidget');
    }
    
}
?>
