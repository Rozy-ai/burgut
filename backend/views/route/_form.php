<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\RouteWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="route-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'route_no')->textInput() ?>

    <?= $form->field($model, 'from_point_id')->dropDownList($model->getPointList(), ['options' => $model->getPointOptionList()]) ?>
    <?= $form->field($model, 'to_point_id')->dropDownList($model->getPointList(), ['options' => $model->getPointOptionList()]) ?>
    <!--    --><? //= $form->field($model, 'from_point_id')->textInput() ?>


    <?= $form->field($model, 'length')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cycle_min')->textInput() ?>

    <?= $form->field($model, 'planned_period_min')->textInput() ?>
    <?= $form->field($model, 'region')->dropDownList($model->getRegionOptions()) ?>

    <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions()) ?>

    <?= $form->field($model, 'waypoints')->hiddenInput()->label(false) ?>

    <?= Html::label(Yii::t('app', 'coordination')) ?>
    <div id="map" style="height:550px;"></div>

    <div style="width:900px; text-align:center; margin:0px auto 0px auto; margin-top:10px;">
        <a href="#" class="btn btn-default" id="save_waypoints"><?= Yii::t('app', 'Save Waypoints') ?></a>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<< JS

        var startPoint;
        var endPoint;
        $('#routewrapper-from_point_id').change(function(){
          var lat=$(this).children('option:selected').data('lat');
          var lng=$(this).children('option:selected').data('lng');
          if(lat!=undefined && lng!=undefined){
            startPoint={lat:lat,lng:lng};  
            initRoute(startPoint,endPoint,true);
          }
        });
        
        $('#routewrapper-to_point_id').change(function(){
          var lat=$(this).children('option:selected').data('lat');
          var lng=$(this).children('option:selected').data('lng');
          if(lat!=undefined && lng!=undefined){
            endPoint={lat:lat,lng:lng};  
            initRoute(startPoint,endPoint,true);
          }
        });
        
        
        function initMap(){
          var startLat=$('#routewrapper-from_point_id').children('option:selected').data('lat');
          var startLng=$('#routewrapper-from_point_id').children('option:selected').data('lng');
          
          var endLat=$('#routewrapper-to_point_id').children('option:selected').data('lat');
          var endLng=$('#routewrapper-to_point_id').children('option:selected').data('lng');
          
          startPoint={lat:startLat, lng:startLng};
          endPoint={lat:endLat, lng:endLng};
          initRoute(startPoint,endPoint,false);
        }
        
        initMap();
JS;


$this->registerJsFile('https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/plugins/leaflet-routing-machine/dist/leaflet-routing-machine.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/plugins/leaflet-routing-machine/examples/Control.Geocoder.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/leaflet/config.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/leaflet/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs($script, yii\web\View::POS_READY);
?>
