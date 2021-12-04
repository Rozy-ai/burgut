<?php
if (isset($image) && isset($width) && isset($height)) {
    $thumbImageUrl = $image->getThumbPath($width, $height, null, true);
    $href = $image->getGalleryUrl();
    if (strlen(trim($thumbImageUrl)) > 5) { ?>
        <a href="<?= $href ?>">
            <?php if (isset($image->video_docs) && is_array($image->video_docs) && count($image->video_docs) > 0) { ?>
                <i class="fa fa-play-circle title gallery-item-icon"></i>
            <?php } else { ?>
                <i class="fa fa-camera title gallery-item-icon"></i>
            <?php } ?>

            <img src="<?php echo $thumbImageUrl; ?>" alt="">
            <div class="gallery-title">
                <div class="gallery-title-content">
                    <?= $image->title ?>
                </div>
            </div>
            <?php if ($image->type == \common\models\wrappers\ImageWrapper::IMAGE_VIDEO) { ?>
                <span class="video-icon"></span>
            <?php } ?>
        </a>
    <?php } ?>
<?php } ?>
