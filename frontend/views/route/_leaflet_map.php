<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\RouteWrapper */
/* @var $form yii\widgets\ActiveForm */

$title = Yii::t('app', 'Route No') . ":" . $model->route_no . '  -  ('.$model->fromPoint->name . " - " . $model->toPoint->name . ')';
?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?= $title ?></h4>
</div>
<div class="modal-body">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'waypoints')->hiddenInput()->label(false) ?>
    <div class="leafler-map">
        <div id="map" style="height:550px;"></div>
    </div>

    <?php ActiveForm::end(); ?>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
</div>

<?php
$script = <<< JS
        var map = L.map('map');
        var wpSource = [];
        var control;
        
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        initRoute = function (start, end, ingorePrevious=false) {
          var previousVal = $('#routewrapper-waypoints').val();
          if (previousVal)
            var os = JSON.parse(previousVal);
        
          if (os !== undefined && os != null && !ingorePrevious) {
            for (var i = 0; i < os.waypoints.length; i++)
              wpSource[i] = L.latLng(os.waypoints[i][0], os.waypoints[i][1]);
          } else {
            if (control !== undefined && control.getWaypoints().length > 0) {
              control.spliceWaypoints(0, control.getWaypoints().length);
              wpSource = [];
            }
            if (start == undefined && end == undefined) {
              wpSource.push(L.latLng(37.97, 58.31));
              wpSource.push(L.latLng(37.91, 58.44));
            } else {
              wpSource.push(L.latLng(start.lat, start.lng));
              wpSource.push(L.latLng(end.lat, end.lng));
            }
          }
        
          control = L.Routing.control(L.extend(window.lrmConfig, {
            waypoints: wpSource,
            // geocoder: L.Control.Geocoder.nominatim(),
            routeWhileDragging: false,
            reverseWaypoints: false,
            showAlternatives: false,
            createMarker: function (i, wp, total) {
              if (i > 0 && i < (total-1))
                return null;
              else {
                var options = {
                    draggable: this.draggableWaypoints
                  },
                  marker = L.marker(wp.latLng, options);
                return marker;
              }
            },
            lineOptions: {
              styles: [{color: 'blue', opacity: 0.5, weight: 5}],
            },
            altLineOptions: {
              styles: [
                {color: 'black', opacity: 0.15, weight: 9},
                {color: 'white', opacity: 0.8, weight: 6},
                {color: 'blue', opacity: 0.5, weight: 2}
              ]
            }
          })).addTo(map);
        
          L.Routing.errorControl(control).addTo(map);
        }
        initRoute();
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>


