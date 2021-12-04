<div>
    <div id="dsel2"></div>
</div>

<?php
$overviewUrl = \yii\helpers\Url::to(['event/overview']);
$refresh_class = $this->context->refresh_class;
$waiting_text = Yii::t('app', 'Event waiting...');
$not_found_text = Yii::t('app', 'Event not found');

$this->registerJs('
    var calendarPicker2 = $("#dsel2").calendarPicker({
        monthNames:["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        dayNames: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        //useWheel:true,
        //callbackDelay:500,
        years:0,
        months:5.5,
        days:15,
        showDayArrows:false,
        callback:function(cal) {
            debugger;
            var refresh_class="' . $refresh_class . '";
            var waiting_text="' . $waiting_text . '";
            var not_found="' . $not_found_text . '";
            
            
            if(refresh_class && refresh_class.length>0){
                var selectedDate=cal.currentDate.toISOString().split(\'T\')[0];
                $.ajax({
                    url: "' . $overviewUrl . '",
                    type: "GET",
                    data: {
                        date:selectedDate
                    },
                    beforeSend: function() {
                        $("."+refresh_class).html("<span class=\"event_text\">"+waiting_text+"</span>");    
                    },
                    success: function (data) {
                        if($(data).length>0)
                            $("."+refresh_class).html($(data).html());
                        else
                            $("."+refresh_class).html("<span class=\"event_text\">"+not_found+"</span>");

                    },
                    error: function () {
                        debugger;
                    }
                });
    //          $("#wtf").html("Selected date: " + cal.currentDate);
            }
        }
    });',
    \yii\web\View::POS_END,
    'calendarPicker'
);
?>
