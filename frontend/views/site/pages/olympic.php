<?php
$category_code = 'olympic';
$sportFacilityCategory = \common\models\wrappers\CategoryWrapper::find()->where(['code' => $category_code])->one();
if (isset($sportFacilityCategory)) { ?>
    <div style="margin: 0 auto;display: block;width: 1156px;position: relative;text-align: center;">
        <!--        <div class="row next-block">-->
        <!--            <div class="col-md-12">-->
        <div class="map-header-olympic">
            <h2><?php echo $sportFacilityCategory->name ?></h2>
            <h4><?php echo $sportFacilityCategory->description ?></h4>
        </div>
        <?php
        echo \common\widgets\tmmap\TmMap::widget([
            'category' => $category_code,
            'view' => 'olympic',
            'limit' => 50,
        ]);
        ?>
        <!--            </div>-->
        <!--        </div>-->
        <div class="clear"></div>
        <img class="loc loc_1" src="<?= \yii\helpers\Url::to('@web/source/img/map/loc_1.gif') ?>">
        <img class="loc loc_2" src="<?= \yii\helpers\Url::to('@web/source/img/map/loc_1.gif') ?>">
        <img class="loc loc_3" src="<?= \yii\helpers\Url::to('@web/source/img/map/loc_1.gif') ?>">
        <img class="loc loc_4" src="<?= \yii\helpers\Url::to('@web/source/img/map/loc_1.gif') ?>">
        <img class="loc loc_5" src="<?= \yii\helpers\Url::to('@web/source/img/map/loc_1.gif') ?>">

        <div class="media_menu">
            <p><?= Yii::t('app', 'More detailed info:') ?></p>
            <ul>
                <li><a target="_blank" href="<?= $sportFacilityCategory->getUrl() ?>">
                        <img
                            src="<?= \yii\helpers\Url::to('@web/source/img/map/page.png') ?>"><?= $sportFacilityCategory->name ?>
                    </a></li>
                <li><a target="_blank" download="Olympic_complex_price_list.pdf"
                       href="<?= \yii\helpers\Url::to('@web/source/download_files/price_list.pdf') ?>">
                        <img
                            src="<?= \yii\helpers\Url::to('@web/source/img/map/price.png') ?>"><?= Yii::t('app','Price list') ?>
                    </a></li>
            </ul>
        </div>
        <img src="<?= \yii\helpers\Url::to('@web/source/img/map/click_tm.png') ?>" class="click_tip"
             style="display: inline;">
    </div>
<?php } ?>