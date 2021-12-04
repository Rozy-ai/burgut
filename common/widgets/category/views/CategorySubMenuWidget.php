<?php
$subCategoryModels = $this->subCategoryModels;
$relatedCategoryModels = $this->relatedCategoryModels;
$printed_count = 0;
$minimized_class = 'minimized';
?>

    <div class="<?php echo $this->wrapperCssClass; ?> <?= $minimized_class ?> dynamic">
        <ul>
            <?php foreach ($subCategoryModels as $subcatModel) {
                if (isset($this->relatedActiveRecord)) {
                    $count = $this->relatedActiveRecord->countByAttributes(array('category_id' => $subcatModel->id, 'status' => 1));
                    if ((int)$count > 0) { ?>
                        <li class="<?php echo $this->itemCssClass; ?> ">
                            <span class="media-object responsive">
                                <?php if ($this->show_photo) echo CHtml::link(CHtml::image($subcatModel->getThumbPath(45, 45, 'h'), ""), $subcatModel->url, array('class' => "thumb")); ?>
                            </span>
                            <?php
                            $cat_name = $subcatModel->name;
                            $cat_name = Yii::app()->controller->truncate($cat_name, 3, 50);
                            if (isset($count)) {
                                $cat_name = $cat_name . " (" . $count . ")";
                            }
                            $printed_count++;
                            echo CHtml::link($cat_name, $subcatModel->url);
                            ?>
                        </li>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

            <?php foreach ($relatedCategoryModels as $relatedModel) { ?>
                <li class="<?php echo $this->itemCssClass; ?> ">
                    <span class="media-object responsive">
                        <?php if ($this->show_photo) echo CHtml::link(CHtml::image($relatedModel->getThumbPath(45, 45, 'h'), ""), $subcatModel->url, array('class' => "thumb")); ?>
                    </span>
                    <?php
                    $cat_name = $relatedModel->name;
                    $cat_name = Yii::app()->controller->truncate($cat_name, 3, 50);
                    if(isset($relatedModel->parent_id)){
                        $parentModel=$relatedModel->parent;
                        if(isset($parentModel)){
                            $cat_name.= ' ('.Yii::app()->controller->truncate($parentModel->name, 3, 50).')';
                        }
                    }
                    $printed_count++;
                    echo CHtml::link($cat_name, $relatedModel->url);
                    ?>
                </li>

            <?php } ?>

        </ul>
    </div>

<?php
$is_minimized = ($printed_count > 8) ? true : false;
$minimized_class = $is_minimized ? "minimized" : '';
if ($is_minimized) { ?>
    <div class="mobile_more_link visible-xs">
        <a href="#" data-label_less="<?php echo Yii::t('app', 'show_less'); ?>"
           data-label_more="<?php echo Yii::t('app', 'show_more'); ?>">
            <i class="fa fa-chevron-down" style="margin-right: 3px;"></i>
            <span><?php echo Yii::t('app', 'show_more'); ?></span>
        </a>
    </div>
<?php } ?>


<?php
Yii::app()->clientScript->registerScript('dynamicSubMenu', ' 

    $(".mobile_more_link a").on("click",function(){
        var less=$(this).data("label_less");
        var more=$(this).data("label_more");
        
        wrapper=$(".sub_categories.horizontal");
        if(wrapper.hasClass("minimized")){
            $(this).find("i").removeClass("fa-chevron-down");
            $(this).find("i").addClass("fa-chevron-up");
            $(this).find("span").text(less);
            wrapper.removeClass("minimized");
        }else{
            $(this).find("i").removeClass("fa-chevron-up");
            $(this).find("i").addClass("fa-chevron-down");
            $(this).find("span").text(more);
            wrapper.addClass("minimized");
        }
    });

', CClientScript::POS_READY);
?>