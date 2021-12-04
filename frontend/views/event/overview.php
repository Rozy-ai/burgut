<?php
echo \common\widgets\event\listview\ListWidget::widget([
    'view' => 'overview',
    'event_date' => $date,
    'limit' => 4,
    'show_all_url' => \yii\helpers\Url::to(['show/index']),
    'show_all_title' => Yii::t('app', 'Show detailed info about events')
]);
?>