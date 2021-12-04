<?php
use yii\helpers\Html;

$thumbImageUrl = $model->getThumbPath(350, 200, 'h', true);
$href = $model->getGalleryUrl();
?>

<?php if (strlen(trim($thumbImageUrl)) > 5) { ?>
    <div class="col-md-3 col-lg-3 col-xs-12">
        <div class="single-box gallery">
            <a href="<?= $href ?>"><img src="<?php echo $thumbImageUrl; ?>" alt="">
                <span class="gallery-title"><?= Yii::$app->controller->truncate($model->title, 10, 100) ?></span>
                <?php if($model->type==\common\models\wrappers\ImageWrapper::IMAGE_VIDEO) {?>
                    <span class="video-icon"></span>
                <?php }?>
            </a>
        </div>
    </div>
<?php } ?>
