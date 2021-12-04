<?php

$list = $this->context->list;

$area_list = [];
if (isset($list) && count($list) > 0) {
    foreach ($list as $item) {
        $area = [];
        $area['title'] = $item->title;
        $area['description'] =  Yii::$app->controller->truncate($item->description, 15, 220);;
        $area['class'] = 'item' . $item->id;
        $area['image'] = $item->getThumbPath(385, 200, 'auto');

        if (isset($item->redirectUrl) && strlen(trim($item->redirectUrl)) > 2) {
            $area['path'] = \yii\helpers\Url::base(false) . '/' . $item->redirectUrl . trim('/');
        } else {
            $area['path'] = $item->getUrl();
        }

        if (isset($item->coordinates)) {
            $area['coords'] = $item->coordinates;
        }
        if (isset($item->position)) {
            $area['position'] = $item->position;
        }

        if (isset($item->class)) {
            $area['class'] = $item->class;
        }

        if (isset($item->capacity)) {
            $area['capacity'] = $item->capacity;
        }

        if (isset($item->sports)) {
            $area['sports'] = $item->sports;
        }

        $area_list[] = $area;
    }
} ?>


<div class="map-wrapper">
    <img src="<?= \yii\helpers\Url::to('@web/source/img/map/tm_map.png') ?>" usemap="#Map" class="map">
    <map name="Map" id="Map">
    </map>
</div>
<div style="display:none;" id="ToolTipContents"></div>

<?php
$areas_json = json_encode($area_list);
$script = <<< JS
            var areas=$areas_json;
			$(document).ready(function(){
				for(i=0; i<areas.length; i++)
				{
				  if(!areas[i]['coords'])
					html = '';
    
					//create image map
					// for(b=0; b<areas[i].coords.length; b++)
					// {
						if(areas[i].path != undefined)
							$('#Map').append('<area position="'+areas[i].position+'" title="'+areas[i].title+'" class="'+areas[i].class+'" target="_blank" href="'+areas[i].path+'" shape="poly" coords="'+areas[i].coords+'" />');
						else	
							$('#Map').append('<area position="'+areas[i].position+'" title="'+areas[i].title+'" href="javascript:" shape="poly" coords="'+areas[i].coords+'" />');
					// }
					
					//add tooltip description
					if(areas[i].path != undefined)
					{
						html = '<div class="'+areas[i].class+'_content"> ';

						if(areas[i].image != undefined && areas[i].image.length>2)
							html+='<img src="'+areas[i].image+'">';
						
						if(areas[i].capacity != undefined)
							html+='<i>Sygymlylygy: '+areas[i].capacity+'</i>';
						
						html+='<b>'+areas[i].title;

						if(areas[i].sports != undefined)
							html+='<span>'+areas[i].sports+'</span>';

						html+='</b>';

						if(areas[i].description != undefined)
							html+='<p>'+areas[i].description+'</p>';

						html+='</div>';

						$("#ToolTipContents").append(html);
					
					}
				
				}

				setTimeout(function(){
					$('img[usemap="#Map"]').maphilight({
				        fill: true,
				        fillColor: 'ffffff',
				        fillOpacity: 0.4,
				        stroke: false,
				        strokeColor: 'ffffff',
				        strokeOpacity: 1,
				        shadow: true,
				        shadowX: 2,
				        shadowY: 2,
				        shadowRadius: 5,
				        shadowColor: 'ffffff',
				        shadowOpacity: 0.5,
				        shadowPosition: 'outside',
				        shadowFrom: false
				    });

				}, 3000);
				
				$('area').qtip({
                    style: {
                        classes: 'qtip'
                    },
                    position: {
                        target: 'mouse',
                        my: 'bottom center',
                        // adjust: {
                        //     x: -150,
                        //     y: -150
                        // }
                    },
                    events: {
                        show: function(event, api) {
                            if(api.elements.target.attr('class'))
                            {
                                api.set({
                                    'content.text': "<div class='popup'>" + $("."+api.elements.target.attr('class')+"_content").html() + "</div>"
                                });
            
                            } else {
                                api.set({
                                    'content.text':api.elements.target.attr('title')
                                });
                            }
                        }
                    }
                });

			});
		
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>
