<?php
$itemSearch = new \common\models\search\ItemSearch();
$itemSearch->category_ids = $federationModel->cats;
if (!isset($itemSearch->category_ids) || (is_array($itemSearch->category_ids) && count($itemSearch->category_ids) == 0))
    $itemSearch->category_ids = [-1];

$federationNewsDp = $itemSearch->search([]);

\yii\widgets\Pjax::begin(['id' => 'pjax-item-list']);
echo \yii\widgets\ListView::widget([
    'dataProvider' => $federationNewsDp,
    'id' => 'item-list',
    'itemView' => '_item_view',
    'viewParams' => [],
    'itemOptions' => ['class' => 'item'],
    'layout' => "{items}\n{pager}",
]); ?>
<?php \yii\widgets\Pjax::end(); ?>

