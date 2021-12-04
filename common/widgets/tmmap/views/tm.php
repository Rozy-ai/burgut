<div class="map-wrapper">
    <img src="<?= \yii\helpers\Url::to('@web/source/img/tm_map.jpg') ?>" usemap="#image-map" class="map">
    <map name="image-map">
        <area target="" alt="dashoguz" data-tooltip-content="#tooltip_content_dz" class="tooltip"
              title="This is my image's tooltip message for area 1!"
              data-toggle="popover-hover" title="dashoguz"
              coords="462,20,453,32,441,31,430,30,435,37,449,57,451,67,431,46,423,48,415,63,409,75,399,94,406,100,412,112,407,125,398,130,378,134,367,128,365,118,357,118,353,100,348,105,358,132,352,155,320,160,335,193,356,231,356,258,365,270,371,274,393,271,427,264,450,260,494,276,534,280,559,279,561,312,567,317,579,316,585,320,593,324,596,314,594,249,574,248,580,185,631,183,629,168,599,170,567,153,565,132,561,113,574,113,556,91,560,86,556,70,532,67,508,67,504,47,479,42"
              shape="poly">
        <area target="" alt="lebap" class="tooltip" title="This is my image's tooltip message for area 1!"
              coords="634,175,653,176,662,166,695,178,700,195,705,223,720,241,730,285,858,388,867,382,962,446,976,442,1026,469,1017,520,964,498,949,529,896,542,892,562,803,563,807,524,822,498,784,460,757,445,646,329,598,329,594,250,577,245,584,189,631,188"
              shape="poly">
        <area target="" alt="mary" title="mary" class="tooltip"
              title="This is my image's tooltip message for area 1!"
              coords="634,334,635,346,619,349,614,371,605,382,593,396,607,437,629,468,627,496,637,534,661,569,665,601,667,638,666,650,664,676,682,691,699,688,717,699,719,708,729,702,749,706,777,681,776,672,784,667,779,651,810,644,840,637,855,625,883,599,880,589,889,566,807,562,806,522,821,498,782,457,757,445,645,330,645,332"
              shape="poly">
        <area target="" alt="ahal" title="ahal" class="tooltip"
              title="This is my image's tooltip message for area 1!"
              coords="361,275,358,318,321,416,337,423,357,438,374,463,434,485,452,493,467,488,480,494,516,508,523,532,563,544,589,583,645,582,651,669,667,677,664,571,636,529,627,471,606,438,591,394,615,363,614,349,636,341,645,330,604,329,586,322,562,315,556,286,499,280,450,260"
              shape="poly">
        <area target="" alt="balkan" title="balkan" class="tooltip"
              title="This is my image's tooltip message for area 1!"
              coords="138,522,157,523,178,513,192,505,196,489,207,477,226,461,257,453,299,457,305,441,345,443,356,438,320,420,347,321,358,316,352,281,357,251,317,168,275,161,243,168,205,119,201,108,149,67,81,81,40,113,48,144,64,202,60,230,52,251,61,278,111,285,107,305,124,329,84,329,113,347,134,373,127,465,132,496,133,510"
              shape="poly">
    </map>
    <div class="tooltip_templates" style="display: none">
        <div id="tooltip_content_dz">
            <strong><?php echo Yii::t('app', 'Dazshoguz region') ?></strong>
            <p>135 <?php echo Yii::t('app', 'sports facilities') ?></p>
            <p>43 <?php echo Yii::t('app', 'sport schools') ?></p>
            <a href="#">Doly maglumat ucin</a>
        </div>
    </div>
</div>


<?php
$script = <<< JS
        $(document).ready(function() {
          $('.tooltip').tooltipster({
            distance:1,
            // animation:'fall',
            // plugins: ['sideTip','follower'],
            trigger: 'custom',
            trackTooltip:true,
            functionBefore: function(instance, helper){
                var instances = $.tooltipster.instances();
                $.each(instances,function(indx,instance){

                // if another instance is already open
                if (instance.status().open){
                    duration = instance.option('animationDuration');
                    instance.option('animationDuration', 0);
                    instance.close();
                    instance.option('animationDuration', duration);
                    }
                });
            },
            triggerOpen: {
                mouseenter: true
            },
             triggerClose: {
                 // mouseleave: true,
                originClick: true,
                touchleave: true
            },
            theme: ['tooltipster-noir', 'tooltipster-noir-customized']
          });
          
           $('.map').maphilight({
             strokeColor:'6bcc9d',
             strokeWidth:2,
             fillColor: '6bcc9d',
             fillOpacity: 0.6,
           });
        });
JS;

$this->registerJs($script, yii\web\View::POS_READY);

?>

<style>
    .tooltipster-sidetip.tooltipster-noir.tooltipster-noir-customized .tooltipster-box {
        background: #dff5fe;
        border: 1px solid #98c0d0;
        border-radius: 4px;
        box-shadow: 1px 1px 7px 0 rgba(0, 0, 0, 0.2);
    }

    .tooltipster-sidetip.tooltipster-noir.tooltipster-noir-customized .tooltipster-content {
        color: #222;
        padding: 15px;
    }

    .tooltipster-sidetip.tooltipster-noir.tooltipster-noir-customized.tooltipster-bottom .tooltipster-arrow-background {
        border-bottom-color: #dff5fe;
        top: 2px;
    }

    .tooltipster-sidetip.tooltipster-noir.tooltipster-noir-customized.tooltipster-bottom .tooltipster-arrow-border {
        border-bottom-color: #98c0d0;
    }

    .tooltipster-sidetip.tooltipster-noir.tooltipster-noir-customized.tooltipster-top .tooltipster-arrow-background {
        border-top-color: #dff5fe;
        top: -2px;
    }

    .tooltipster-sidetip.tooltipster-noir.tooltipster-noir-customized.tooltipster-top .tooltipster-arrow-border {
        border-top-color: #98c0d0;
    }

    .tooltipster-base {
        pointer-events: auto;
    }

    .tooltipster-box p {
        margin: 0px;
    }

    .tooltipster-content strong {
        color: #6988ff;
    }

    .tooltipster-content {
        font-size: 13px;
    }

    .tooltipster-content a {
        color: #12309c;
        font-size: 13px;
        margin: 5px 0px;
        display: inline-block;
    }
</style>
