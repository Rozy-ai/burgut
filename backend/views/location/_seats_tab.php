<?php

use yii\helpers\Html;

?>
<div class="event-to-seat-wrapper-index">

    <h1><?= Yii::t('app', 'Seats') ?></h1>

    <?php
    if (isset($model) && isset($model->id)) {
        echo Html::a('<i class="fa fa-chair"> </i> Add Seat',
            \yii\helpers\Url::to(['/seat/dialog', 'location_id' => $model->id]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalseat',
            ]
        );

        echo Html::a('<i class="fa fa-chairs"> </i> Add Seat Range',
            \yii\helpers\Url::to(['/seat/dialog-range', 'seat_group_id' => $model->id]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalseatrange',
            ]
        );

        echo Html::a('<i class="fa fa-ball-pill"> </i> Add Seat Group',
            \yii\helpers\Url::to(['/seat-group/dialog', 'location_id' => $model->id]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalseatgroup',
            ]
        );

        $seatSearch = new \common\models\search\SeatSearch();
        $seatSearch->location_id = $model->id;

        echo $this->render('/seat/_seat_grid', [
            'seatSearch' => $seatSearch,
        ]);

    } else {
        echo Yii::t('app', 'You should first create event to set prices');
    } ?>


</div>
