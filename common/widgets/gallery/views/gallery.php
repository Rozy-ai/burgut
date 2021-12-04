<?php
//$dropZoneName=$this->context->dropzoneName;
//$options=$this->context->options;
//$deleteUrl=\yii\helpers\Url::to([$this->context->deleteUrl]);
//$uploadUrl=\yii\helpers\Url::to([$this->context->uploadUrl]);
//$inputId=$this->context->inputId;
$images = $this->context->images;
$galleryHref = \yii\helpers\Url::to(['gallery/index']);

if (isset($images)) { ?>
    <div class="layer home_gallery1">
        <div class="col-md-12">
            <h3 class="widget-header pull-left"><?= Yii::t('app', 'Gallery') ?></h3>
        </div>

        <div class="col-md-12">
            <!--        <div class=" col-md-10 col-xs-offset-1">-->


            <div class="single-widget">
                <div class="col-md-3 col-xs-12">
                    <div class="row">
                        <div class="sma-img gallery col-xs-12">
                            <?php
                            if (isset($images) && isset($images[1])) {
                                echo $this->render('_view', ['image' => $images[1], 'width' => 300, 'height' => 190]);
                            }
                            ?>
                        </div>
                        <div class="sma-img gallery col-xs-12">
                            <?php
                            if (isset($images) && isset($images[2])) {
                                echo $this->render('_view', ['image' => $images[2], 'width' => 300, 'height' => 190]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="sma-img gallery main col-md-6 hidden-xs">
                    <?php
                    if (isset($images) && isset($images[0])) {
                        echo $this->render('_view', ['image' => $images[0], 'width' => 552, 'height' => 382]);
                    }
                    ?>
                </div>
                <div class="col-md-3 col-xs-12">
                    <div class="row">
                        <div class="sma-img gallery col-xs-12">
                            <?php
                            if (isset($images) && isset($images[3])) {
                                echo $this->render('_view', ['image' => $images[3], 'width' => 300, 'height' => 190]);
                            }
                            ?>
                        </div>
                        <div class="sma-img gallery hidden-xs">
                            <?php
                            if (isset($images) && isset($images[4])) {
                                echo $this->render('_view', ['image' => $images[4], 'width' => 300, 'height' => 190]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--        </div>-->
        </div>
    </div>
<?php } ?>
