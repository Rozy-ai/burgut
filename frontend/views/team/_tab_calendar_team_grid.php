<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="event-to-seat-wrapper-index">


    <?php Pjax::begin(['id' => 'pjax-competition-event-grid', 'timeout' => 5000]); ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $searchModel->search([]),
        'tableOptions' => ['class' => 'table table-striped'],
        "filterSelector" => "#" . Html::getInputId($searchModel, 'season_id'),
//            'filterModel' => $searchModel,
        'columns' => [
            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'start_time',
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'homeTeam',
                'value' => function ($model) {
                    $canditateName = $model->getSideCanditate(0);
                    if (isset($canditateName)) {
                        return Html::a($canditateName, ['event/view', 'id' => $model->id]);
                    }
                },
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'score',
                'value' => function ($model) {
                    $eventSides = $model->getEventSides();
                    if (isset($eventSides) && isset($eventSides[0]) && isset($eventSides[1])) {
                        return Html::a($eventSides[0]->score_for . ' - ' . $eventSides[1]->score_for, ['event/view', 'id' => $model->id]);
                    }
                },
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'awayTeam',
                'value' => function ($model) {
                    $canditateName = $model->getSideCanditate(1);
                    if (isset($canditateName)) {
                        return Html::a($canditateName, ['event/view', 'id' => $model->id]);
                    }
                },
                'format' => 'html',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>


<?php
$script = <<< JS
    //message dialog
    $("body").on("beforeSubmit", "form#dynamic-form", function () {
        var form = $(this);
        if (form . find(".has-error") . length) {
            return false;
        }
        $.ajax({
                url    : form . attr("action"),
                type   : "post",
                data   : form . serialize(),
                success: function (response) {
        debugger;
        response = $.parseJSON(response);
        if (response !== undefined) {
            if (response . status == 'success') {
                $.pjax . reload({container: '#pjax-price-grid', async: false});
                            $("#modalevent") . modal("toggle");
                          } else {
                window . alert(response . message);
            }
        }
    },
                error  : function ()
    {
        //console.log("internal server error");
    }
        });
        return false;
    });
  
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>

