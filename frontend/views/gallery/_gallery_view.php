<?php
$thumbImageUrl = $model->resize(390, 300, 'h', true);
$imageUrl = $model->getFullPath();
?>

<div class="col-md-4 col-lg-4 col-xs-12">
    <div class="gallery_view">
        <a class="fancybox" data-gall="myGallery" href="<?php echo $imageUrl; ?>">
            <img src="<?php echo $thumbImageUrl; ?>"/>
        </a>
    </div>
</div>