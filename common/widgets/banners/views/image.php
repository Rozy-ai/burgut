<!--noindex-->
<?php
use yii\helpers\Html;

?>


<div id="<?php echo $this->context->outer_css_id; ?>" class="<?php echo $this->context->outer_css_class; ?>">
    <?php
    if (isset($bannerModel)) {
        $documents = $bannerModel->documents;
        if (isset($documents[0]) && count($documents) > 0) {
            $document = $documents[0];
            $path = $document->getFullPath();
            if (isset($path))
                echo Html::a(Html::img($path, ['alt' => $bannerModel->description, 'width' => $this->context->width, 'height' => $this->context->height]), "http://" . $bannerModel->url, array('target' => "_blank", "rel" => "nofollow"));
        }
    }
    ?>
</div>

<!--/noindex-->
