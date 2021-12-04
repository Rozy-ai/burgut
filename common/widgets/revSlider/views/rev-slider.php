<?php

$this->registerJsFile(Yii::$app->request->baseUrl . '/source/revolution/js/jquery.themepunch.tools.min-rev=5.0.js', ['depends' => [\yii\web\JqueryAsset::className(), \yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/revolution/js/jquery.themepunch.revolution.min-rev=5.0.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/revolution/js/extensions/revolution.extension.video.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/revolution/js/extensions/revolution.extension.slideanims.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/revolution/js/extensions/revolution.extension.navigation.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/revolution/js/extensions/revolution.extension.layeranimation.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/revolution/js/extensions/revolution.extension.actions.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl . '/source/revolution/css/settings.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/source/revolution/css/layers.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/source/revolution/css/navigation.css');

$sliderImages = $this->context->images;
$cssId = $this->context->cssId;
if (isset($sliderImages) && count($sliderImages) > 0) { ?>
    <!-- Main Slider -->
    <div class="rev_slider_wrapper">
        <div id="<?= $cssId ?>" class="rev_slider" data-version="5.0">
            <ul>
                <?php foreach ($sliderImages as $image) { ?>
                    <!-- Slide 1 -->
                    <li data-transition="fadefromright">
                        <?php
                        $path = $image->getThumbPath(1250, 775, '', true);
                        echo \yii\helpers\Html::img($path, ['alt' => 'logo', 'class' => 'logo-default']);
                        ?>

                        <div class="tp-caption normal-caption bordered-caption  tp-resizeme"
                             id="slide-01-layer-02"
                             data-x="center" data-hoffset="0"
                             data-y="top" data-voffset="295"
                             data-width="['none']"
                             data-height="['none']"
                             data-transform_idle="o:1;"
                             data-transform_in="x:-50px;opacity:0;s:2000;e:Power3.easeOut;"
                             data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                             data-start="700"
                             data-responsive_offset="on">
                            <h2><?php echo $image->title; ?></h2>
                            <span><?php echo $image->description; ?></span>
                        </div>

<!--                        <div class="tp-caption normal-caption bordered-caption  tp-resizeme"-->
<!--                             id="slide-01-layer-02"-->
<!--                             data-x="center" data-hoffset="0"-->
<!--                             data-y="top" data-voffset="295"-->
<!--                             data-width="['none']"-->
<!--                             data-height="['none']"-->
<!--                             data-transform_idle="o:1;"-->
<!--                             data-transform_in="x:-50px;opacity:0;s:2000;e:Power3.easeOut;"-->
<!--                             data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"-->
<!--                             data-start="700"-->
<!--                             data-responsive_offset="on">-->
<!--                            <h2>--><?php //echo $image->title; ?><!--</h2>-->
<!--                            <span>--><?php //echo $image->description; ?><!--</span>-->
<!--                        </div>-->
                    </li>
                <?php } ?>

            </ul>
        </div>
    </div>
<?php } ?>

<?php

$script = <<< JS
    function revSliderActivator() {
        // Main Revolution Slider Settings
        $("#$cssId").length && $("#$cssId").revolution({
            // sliderType: "Auto Responsive",
            sliderType: "Full Width",
            // sliderLayout: "fullscreen",
             sliderLayout: 'auto',
             fullScreenOffset: '50%',
            fullScreenOffsetContainer: "#site-header",
            delay: 6000,
            gridwidth: 1230,
            gridheight: 600,
            navigation: {
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                onHoverStop: "on",
                arrows: {
                    style: "",
                    enable: true,
                    hide_under: 768,
                    hide_onleave: false,
                    left: {
                        h_align: "left",
                        v_align: "center"
                    },
                    right: {
                        h_align: "right",
                        v_align: "center"
                    }
                },
                bullets: {
                        enable: true,
                        style: "hesperiden",
                        hide_onleave: false,
                        h_align: "center",
                        v_align: "bottom",
                        h_offset: 0,
                        v_offset: 20,
                        space: 5
                }
            }
        })
    }            
    
    revSliderActivator();
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>
