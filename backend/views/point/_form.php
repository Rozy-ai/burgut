<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\PointWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="point-wrapper-form">


    <?php $form = ActiveForm::begin(); ?>

    <?php
    $languages = $model->languages;
    if (isset($languages)) {
        $items = [];
        foreach ($languages as $lang) {
            $items[] = [
                'label' => Yii::t('app', $lang),
                'content' => $this->render('_lang', [
                    'model' => $model,
                    'form' => $form,
                    'lang' => $lang,
                ]),
            ];
        }

        echo \yii\bootstrap\Tabs::widget([
            'items' => $items
        ]);
    }
    ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model, 'latitude')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'longitude')->hiddenInput()->label(false) ?>

    <?= Html::label(Yii::t('app', 'coordination')) ?>
    <div id="map" style=""></div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<< JS
      var map, marker;


      $('#address').keypress(function(event){
        if (event.keyCode === 10 || event.keyCode === 13) {
                event.preventDefault();
                event.stopPropagation();
        }
      });
  
      $(document).on('click',"#geocodeAddress",function(event){
        event.preventDefault();
        event.stopPropagation();
        
        var address = document.getElementById('address').value;
        geocodeByAddress(address);
        initMap();
      });

      function initMap() {
            debugger;
            var action=$('#action').val() || 'create';
            var lat=$('#pointwrapper-latitude').val() || 37.9309625;
            var lng=$('#pointwrapper-longitude').val() || 58.3874814;
            // if($('#pointwrapper-latitude').val()){
              $('#map').show();
              $('#map').css({'height':400, 'margin': '10px auto'});

            // }

              var center = new google.maps.LatLng(lat, lng);
              map = new google.maps.Map(document.getElementById('map'), {
                  center: center,
                  zoom: 14,
                  'mapTypeId': google.maps.MapTypeId.ROADMAP,
                  // gestureHandling: 'greedy'
              });
          
              marker = new google.maps.Marker({
                  map: map,
                  position: center,
                  draggable: true,
              });
              
            // if(action=='create'){
                google.maps.event.addListener(marker, 'dragend', function () {
                    map.setCenter(this.getPosition()); // Set map center to marker position
                    updateFormInputs(this.getPosition().lat(), this.getPosition().lng()); // update position display
                    geocodeByLocation(this.getPosition().lat(), this.getPosition().lng());
                });
                
                google.maps.event.addListener(map, 'dragend', function () {
                    marker.setPosition(this.getCenter()); // set marker position to map center
                    updateFormInputs(this.getCenter().lat(), this.getCenter().lng()); // update position display
                    geocodeByLocation(this.getCenter().lat(), this.getCenter().lng());
                });
          // }
      }
       
      initMap();

      var geocoder = new google.maps.Geocoder;
      var infowindow = new google.maps.InfoWindow();
      var placesService = new google.maps.places.PlacesService(map);

      function geocodeByAddress(address){
          if(address===undefined || address.length==0)
            return;
        
         geocoder.geocode({'address': address}, function(results, status) {
              if (status === 'OK') {
                debugger;
                if (results[0]) {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(17);
                    marker.setPosition(results[0].geometry.location);
                    marker.setVisible(true);
                    updateFormInputs(results[0].geometry.location.lat(), results[0].geometry.location.lng()); 

                    var placeId=results[0].place_id;
                    var formatted_address=results[0].formatted_address;
                    updateInfoWindowByPlaceId(placeId,formatted_address);
                }
              } else {
                infowindow.close();
                console.log('Geocode was not successful for the following reason: ' + status);
              }
          });
      }  
      
      function geocodeByLocation(lat, lng){
          geocoder.geocode({'location': {lat:lat,lng:lng}}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
               var placeId=results[0].place_id;
               var formatted_address=results[0].formatted_address;
               updateInfoWindowByPlaceId(placeId,formatted_address);
            }
          } else {
            infowindow.close();
            console.log('Geocoder failed due to: ' + status);
          }
        });
      }  
        
    
        
        // autocomplete scripts
        // var input = document.getElementById('address');
        // var autocomplete = new google.maps.places.Autocomplete(input);
        // autocomplete.bindTo('bounds', map); 
        // autocomplete.addListener('place_changed', mapAutocomplete);
        // function mapAutocomplete(){
        //   marker.setVisible(false);
        //   var place = autocomplete.getPlace();
        //   debugger;
        //   if (!place.geometry) {
        //     // User entered the name of a Place that was not suggested and
        //     // pressed the Enter key, or the Place Details request failed.
        //     // window.alert("No details available for input: '" + place.name + "'");
        //     var address = $(this).val();
        //     geocodeByAddress(address);
        //     return;
        //   }
        //
        //   // If the place has a geometry, then present it on a map.
        //   if (place.geometry.viewport) {
        //     map.fitBounds(place.geometry.viewport);
        //   } else {
        //     map.setCenter(place.geometry.location);
        //     map.setZoom(17);  // Why 17? Because it looks good.
        //   }
        //   marker.setPosition(place.geometry.location);
        //   marker.setVisible(true);
        // 
        //   updateFormInputs(place.geometry.location.lat(), place.geometry.location.lng()); 
        //   updateInfoWindowByPlace(place);
        //   initMap();
        // }

        
        function updateInfoWindowByPlaceId(placeId, defaultValue){
           //  var lat=$('#pointwrapper-latitude').val();
           //  var lng=$('#pointwrapper-longitude').val();
           //  if(lat && lng){
           //  var pyrmont = {lat: lat, lng: lng};
           //      placesService.nearbySearch({
           //        location: pyrmont,
           //        radius: 50,
           //        // type: ['store']
           //      }, function() {
           //        debugger;
           //      });
           // }
           
            placesService.getDetails({
              placeId: placeId
            }, function(place, status) {
              if (status === google.maps.places.PlacesServiceStatus.OK) {
                  updateInfoWindowByPlace(place);
              }else{
                debugger;
                infowindow.close();
                infowindow.setContent(defaultValue);
                infowindow.open(map, marker);
                $('#address').val(defaultValue);
              }
            });
        }
        
        function updateInfoWindowByPlace(place) {
          var address = '';
          var city;
          if (place.address_components) {
            address = [
              (place.name || ''),
              (place.address_components[0] && place.address_components[0].long_name || ''),
              (place.address_components[1] && place.address_components[1].long_name || ''),
              (place.address_components[2] && place.address_components[2].long_name || ''),
              (place.address_components[3] && place.address_components[3].long_name || '')
            ].join(', ');
            
            for (var i=0; i<place.address_components.length; i++) {
              for (var b=0;b<place.address_components[i].types.length;b++) {
            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                if (place.address_components[i].types[b] == "administrative_area_level_1") {
                    //this is the object you are looking for
                    city= place.address_components[i];
                    break;
                }
              }
            }
          }
          
          address=address.replace(/(U|u)nnamed\s(Road),/g,'').trim();
          // $('#address').val(address);
          // if(city){
          //   $('#location').val(city.long_name);
          // }
          
          infowindow.close();
          var infowindowContent = document.getElementById('infowindow-content');
          if(infowindowContent!==undefined && infowindowContent!==null){
              infowindow.setContent(infowindowContent);
              infowindowContent.children['place-icon'].src = place.icon || null;
              infowindowContent.children['place-name'].textContent = place.name;
              infowindowContent.children['place-address'].textContent = address;
          }else{
            infowindow.setContent(address);
          }
          infowindow.open(map, marker);
         
        }
        
        function updateFormInputs(lat, lng) {
            if(lat && lng){
              $('#pointwrapper-latitude').val(lat);
              $('#pointwrapper-longitude').val(lng);
             }
            
        }

JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>
