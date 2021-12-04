<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */


$href = $model->url;
$contentModel = $model->loadContent();
$currentSeason = $model->season;
$path = $contentModel->getThumbPath(260, 150, 'auto');
$this->title = $contentModel->title;


$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competitions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::$app->controller->truncate($this->title, 8, 65);

?>
<!-- product-details-area are start-->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="layer">
                <div class="header">
                    <h3 class="headerColor">
                        <?php
                        echo Html::encode($contentModel->title);
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php if (isset($path) && strlen(trim($path)) > 0) { ?>
                <div class="ep-img">
                    <?php
                    echo \yii\helpers\Html::img($path, ['alt' => '', 'class' => '']);
                    ?>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-8">
            <?php if (isset($contentModel) && isset($contentModel->description) && strlen(trim($contentModel->description)) > 0) { ?>
                <div class="row">
                    <div class="col-md-4">
                        <label><?php echo $contentModel->getAttributeLabel('description') ?></label>
                    </div>
                    <div class="col-md-8">
                        <?php echo $contentModel->description; ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (isset($currentSeason) && isset($currentSeason->name) && strlen(trim($currentSeason->name)) > 0) { ?>
                <div class="row">
                    <div class="col-md-4">
                        <label><?php echo $model->getAttributeLabel('season_id') ?></label>
                    </div>
                    <div class="col-md-8">
                        <?php echo $currentSeason->name; ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($model->getTeamCount() > 0) { ?>
                <div class="row">
                    <div class="col-md-4">
                        <label><?php echo Yii::t('app', 'Competition team count') ?></label>
                    </div>
                    <div class="col-md-8">
                        <?php echo $model->getTeamCount(); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($model->getAthleteCount() > 0) { ?>
                <div class="row">
                    <div class="col-md-4">
                        <label><?php echo Yii::t('app', 'Competition athlete count') ?></label>
                    </div>
                    <div class="col-md-8">
                        <?php echo $model->getAthleteCount(); ?>
                    </div>
                </div>
            <?php } ?>


        </div>
    </div>

    <div class="layer">
        <div class="row">
            <div class="col-md-12">
                <?php \yii\widgets\Pjax::begin(['id' => 'pjax-competition-tabs', 'timeout' => 5000]); ?>

                <?php
                $items = [
                    [
                        'label' => Yii::t('app', 'News'),
                        'tab' => '_tab_news',
                        'id' => 'news',
                        'visible' => (isset($model->tagIds) && count($model->tagIds) > 0)
                    ],
                    [
                        'label' => Yii::t('app', 'Calendar'),
                        'tab' => '_tab_calendar',
                        'id' => 'calendar',
                    ],
                    [
                        'label' => Yii::t('app', 'Result'),
                        'tab' => '_tab_result',
                        'id' => 'result',
                    ],
                ];


                if (isset($items) && count($items) > 0) {
                    foreach ($items as $item) {
                        if (isset($item['visible']) && !$item['visible'])
                            continue;
                        if (!isset($tab) || strlen($tab) == 0)
                            $tab = $item['id'];
                    }
                    ?>
                    <ul class="nav nav-tabs">
                        <?php foreach ($items as $item) {
                            if (isset($item['visible']) && !$item['visible'])
                                continue;
                            $css_class = '';
                            if ($item['id'] == $tab)
                                $css_class = 'active'
                            ?>
                            <li class="<?= $css_class ?>">
                                <a href="<?= \yii\helpers\Url::to(['competition/view', 'id' => $model->id, 'tab' => $item['id']]) ?>"><?= $item['label'] ?></a>
                            </li>
                        <?php } ?>
                    </ul>


                    <?php foreach ($items as $item) {
                        if (isset($item['visible']) && !$item['visible'])
                            continue;
                        if ($item['id'] == $tab) { ?>
                            <div class="tab-content">
                                <?php echo $this->render($item['tab'], [
                                    'model' => $model,
                                ]); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <?php \yii\widgets\Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>
