<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ImageWrapper */

$this->title = Yii::t('backend', 'Document Cropper');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap/bootstrap.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/plugins/cropperjs/cropper.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/plugins/cropperjs/main.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/plugins/cropperjs/tether.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<div class="image-wrapper-view" xmlns="http://www.w3.org/1999/html">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo \yii\bootstrap\Html::hiddenInput('id', $model->id, ['id' => 'imageId']); ?>
    <?php echo \yii\bootstrap\Html::hiddenInput('returnUrl', $returnUrl, ['id' => 'returnUrl']); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crop & Save'), \yii\helpers\Url::to(['document/ajax-crop']), ['class' => 'btn btn-success', 'id' => 'cropSave']) ?>
    </p>

    <hr/>

    <div class="row">
        <div class="col-md-9">
            <!-- <h3>Demo:</h3> -->
            <div class="img-container">
                <?php
                $path = $model->getThumb();
                echo \yii\helpers\Html::img($path, ['alt' => '', 'class' => '']);
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <!-- <h3>Preview:</h3> -->
            <div class="docs-preview clearfix">
                <div class="img-preview preview-lg"></div>
<!--                <div class="img-preview preview-md"></div>-->
<!--                <div class="img-preview preview-sm"></div>-->
<!--                <div class="img-preview preview-xs"></div>-->
            </div>

            <!-- <h3>Data:</h3> -->

            <div class="docs-data">
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataX">X</label>
                    <input type="text" class="form-control" id="dataX" placeholder="x">
                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataY">Y</label>
                    <input type="text" class="form-control" id="dataY" placeholder="y">
                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataWidth">Width</label>
                    <input type="text" class="form-control" id="dataWidth" placeholder="width">
                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataHeight">Height</label>
                    <input type="text" class="form-control" id="dataHeight" placeholder="height">
                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataRotate">Rotate</label>
                    <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                    <span class="input-group-addon">deg</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataScaleX">ScaleX</label>
                    <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataScaleY">ScaleY</label>
                    <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                </div>
            </div>
        </div>
    </div>


    <div class="row" id="actions">
        <div class="col-md-9 docs-buttons">
            <!-- <h3>Toolbar:</h3> -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
              <span class="fa fa-arrows"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
              <span class="fa fa-crop"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
              <span class="fa fa-search-plus"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
              <span class="fa fa-search-minus"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="move" data-option="-10"
                        data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
              <span class="fa fa-arrow-left"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0"
                        title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
              <span class="fa fa-arrow-right"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0"
                        data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
              <span class="fa fa-arrow-up"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10"
                        title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
              <span class="fa fa-arrow-down"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45"
                        title="Rotate Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
              <span class="fa fa-rotate-left"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="45"
                        title="Rotate Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
              <span class="fa fa-rotate-right"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1"
                        title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
              <span class="fa fa-arrows-h"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1"
                        title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
              <span class="fa fa-arrows-v"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.crop()">
              <span class="fa fa-check"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.clear()">
              <span class="fa fa-remove"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.disable()">
              <span class="fa fa-lock"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.enable()">
              <span class="fa fa-unlock"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.reset()">
              <span class="fa fa-refresh"></span>
            </span>
                </button>
                <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                    <input type="file" class="sr-only" id="inputImage" name="file"
                           accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                    <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
              <span class="fa fa-upload"></span>
            </span>
                </label>
                <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.destroy()">
              <span class="fa fa-power-off"></span>
            </span>
                </button>
            </div>

            <button type="button" class="btn btn-primary" data-method="moveTo" data-option="0">
          <span class="docs-tooltip" data-toggle="tooltip" title="cropper.moveTo(0)">
            0,0
          </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="zoomTo" data-option="1">
          <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoomTo(1)">
            100%
          </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="rotateTo" data-option="180">
          <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotateTo(180)">
            180°
          </span>
            </button>
            <!--            <input type="text" class="form-control" id="putData"-->
            <!--                   placeholder="Get data to here or set data with this value">-->

        </div><!-- /.docs-buttons -->

        <div class="col-md-3 docs-toggles">

            <?php if (isset($ratios) && count($ratios) > 0) { ?>
                <div class="btn-group docs-aspect-ratios" data-toggle="buttons">

                    <?php
                    $active = false;
                    foreach ($ratios as $key => $ratio) {
                        $rat = (float)$ratio['width'] / (float)$ratio['height'];
                        ?>
                        <label class="btn btn-primary <?php echo $active == false ? 'active' : ''; ?>">
                            <input type="radio" class="sr-only" id="aspectRatio<?= $key ?>" name="aspectRatio"
                                   value="<?= $rat ?>">
                            <span class="docs-tooltip" data-toggle="tooltip"
                                  title="aspectRatio: <?php echo $ratio['width'] . '/' . $ratio['height']; ?> "><?php echo $ratio['width'] . ':' . $ratio['height']; ?> </span>
                        </label>
                    <?php
                    $active=true;
                    } ?>
                    <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN">
                        <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">Free</span>
                    </label>
                </div>
            <?php } ?>


            <div class="btn-group docs-view-modes" data-toggle="buttons">
                <label class="btn btn-primary active">
                    <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
                    <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
              VM0
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
                    <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
              VM1
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
                    <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
              VM2
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
                    <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
              VM3
            </span>
                </label>
            </div>

            <!--            <div class="dropdown dropup docs-options">-->
            <!--                <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">-->
            <!--                    Toggle Options-->
            <!--                    <span class="caret"></span>-->
            <!--                </button>-->
            <!--                <ul class="dropdown-menu" role="menu" aria-labelledby="toggleOptions">-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="responsive" checked>-->
            <!--                            responsive-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="restore" checked>-->
            <!--                            restore-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="checkCrossOrigin" checked>-->
            <!--                            checkCrossOrigin-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="checkOrientation" checked>-->
            <!--                            checkOrientation-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!---->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="modal" checked>-->
            <!--                            modal-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="guides" checked>-->
            <!--                            guides-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="center" checked>-->
            <!--                            center-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="highlight" checked>-->
            <!--                            highlight-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="background" checked>-->
            <!--                            background-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!---->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="autoCrop" checked>-->
            <!--                            autoCrop-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="movable" checked>-->
            <!--                            movable-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="rotatable" checked>-->
            <!--                            rotatable-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="scalable" checked>-->
            <!--                            scalable-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="zoomable" checked>-->
            <!--                            zoomable-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="zoomOnTouch" checked>-->
            <!--                            zoomOnTouch-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="zoomOnWheel" checked>-->
            <!--                            zoomOnWheel-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="cropBoxMovable" checked>-->
            <!--                            cropBoxMovable-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="cropBoxResizable" checked>-->
            <!--                            cropBoxResizable-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                    <li role="presentation">-->
            <!--                        <label class="checkbox-inline">-->
            <!--                            <input type="checkbox" name="toggleDragModeOnDblclick" checked>-->
            <!--                            toggleDragModeOnDblclick-->
            <!--                        </label>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </div><!-- /.dropdown -->

            <!--            <a class="btn btn-secondary btn-block" data-toggle="tooltip"-->
            <!--               href="https://fengyuanchen.github.io/photo-editor" title="An advanced example of Cropper.js">Photo-->
            <!--                Editor</a>-->

        </div><!-- /.docs-toggles -->
    </div>
</div>

</div>
