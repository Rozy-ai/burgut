<?php
echo \common\widgets\horizontalCalendar\HorizontalCalendarWidget::widget([
    'refresh_class' => 'event-overview'
]);
?>
<div class="event-overview event-box ">
    <?php
    echo \common\widgets\event\listview\ListWidget::widget([
        'view' => 'overview',
        'limit' => 9,
        'location_id' => $model->id,
        'show_all_url' => \yii\helpers\Url::to('item/events'),
        'show_all_title' => Yii::t('app', 'Show detailed info about events')
    ])
    ?>
</div>

