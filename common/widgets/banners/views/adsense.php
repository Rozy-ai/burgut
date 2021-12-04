 <!--noindex-->
 <div id="<?php echo $this->outer_css_id;  ?>" class="adsense <?php echo $this->outer_css_class; ?>">
     <?php
    if(isset($bannerModel)){
        echo $bannerModel->adsense_code;
    }
?>
</div>
<!--/noindex-->
