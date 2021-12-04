<?php
use yii\helpers\Html;
?>
<?php //Yii::app()->controller->categoryUrl = $categoryModel->url; ?>

<div class="category_header">
    <div class="<?php echo $this->context->cssClass; ?>">
        <div class="header">
            <?php
            $title = $categoryModel->name;
            if (isset($this->context->override_main_title) && strlen(trim($this->context->override_main_title)) > 2)
                $title = $this->context->override_main_title;

            echo Html::a($title, $categoryModel->url, ['class' => "headerColor"]); ?>
        </div>

        <div class="sub_header">
            <?php
            //            if (!Yii::app()->mobileDetect->isMobile() && !Yii::app()->mobileDetect->isTablet() && !Yii::app()->mobileDetect->isIphone()) {
            foreach ($sub_categories as $key => $category) {
                if ($key > $this->context->maxSubCatCount)
                    continue;
                echo Html::a($category->name, $category->url, ["class" => "indexLink blueColor"]);
            }
            //            }
            ?>
        </div>
        <?php if (isset($this->context->showAllText) && strlen(trim($this->context->showAllText)) > 3) { ?>
            <div class="sub_header pull-right">
                <?php echo Html::a($this->context->showAllText, $categoryModel->url, ['class' => "show_all_header"]); ?>
            </div>
        <?php } ?>
    </div>
</div>
