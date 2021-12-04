 <!--noindex-->
<?php $this->beginWidget('DNofollowWidget'); ?>
 <div id="<?php echo $this->outer_css_id; ?>" class="slider-wrapper theme-default">
<?php
   
    foreach($banners as $bannerModel){
        $images[]=array(
            'src'=>$bannerModel->getThumbPath($this->width,$this->height,'auto',true), 
            'url'=>$bannerModel->url, 
            'caption'=>$bannerModel->description,
        );
    }
    
    $this->widget('application.extensions.nivoslider.ENivoSlider', array(
//            'htmlOptions'=>array('style'=>'width: '.$this->width.'px; height: '.$this->height.'px;'),
            'images'=>$images
         )
     );

?>
</div>
<?php $this->endWidget(); ?>
<!--/noindex-->
