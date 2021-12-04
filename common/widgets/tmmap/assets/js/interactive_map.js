$(document).ready(function(){
	$(".map_big").hide();
	$(".map_big").fadeIn(2000);
	
	$(".click_tip").hide();
	$(".click_tip").fadeIn(5000);

	$('area[position="leftTop"]').qtip({
		style: {
            classes: 'qtip'
        },
      	position: {
      		my: 'right center'
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

	$('area[position="bottomCenter"]').qtip({
		style: {
            classes: 'qtip'
        },
      	position: {
      		my: 'bottom center',
        	adjust: {
	        	x: -10,
	        	y: -60
	        }
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


	$('area[position="leftBottom"]').qtip({
		style: {
            classes: 'qtip'
        },
      	position: {
      		my: 'left bottom',
        	adjust: {
	        	x: 20,
	        	y: 0
	        }
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

    $('area[position="rightCenter"]').qtip({
		style: {
            classes: 'qtip'
        },
      	position: {
      		my: 'right center',
        	adjust: {
	        	x: -50,
	        	y: -20
	        }
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