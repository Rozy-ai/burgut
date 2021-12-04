<?php

use yii\helpers\Html;

?>
<div class="event-to-seat-wrapper-index">

    <h1><?= Yii::t('app', 'Seats') ?></h1>

    <?php
    if (isset($model) && isset($model->id)) {
        echo Html::a('<i class="fa fa-chair"> </i> Add Seat',
            \yii\helpers\Url::to(['/seat/dialog', 'seat_group_id' => $model->id]),
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


        $seatSearch = new \common\models\search\SeatSearch();
        $seatSearch->seat_group_id = $model->id;

        echo $this->render('/seat/_seat_grid', [
            'seatSearch' => $seatSearch,
        ]);

    } else {
        echo Yii::t('app', 'You should first create seat group to set seats');
    } ?>


</div>
