<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\RouteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Route');
$this->params['breadcrumbs'][] = $searchModel->getTypeText();
?>


    <!-- Item Page -->
    <!--<div class="container white">-->
    <div class="routes">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <!--                <div class="page-header">-->
                <h1 class="page-title">
                    <?php
                    echo $this->title;
                    ?>
                </h1>

                <ul id="route-region-list">
                    <?php foreach (\common\models\wrappers\RouteWrapper::getRegionOptions() as $regionOptionId => $regionOptionName) {
                        $class = isset($searchModel->region) && $searchModel->region == $regionOptionId ? 'selected' : '';
                        ?>
                        <li class="<?= $class ?>">
                            <a href="<?= \yii\helpers\Url::to(['route/index', 'region' => $regionOptionId]) ?>"><?= $regionOptionName ?></a>
                        </li>
                    <?php } ?>
                </ul>

                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="divider">
                    <div class="strong-border"></div>
                </div>

<!--                <div class="leafler-map">-->
<!--                    <div id="map" style="height:550px;"></div>-->
<!--                </div>-->

                <div class="routes-table">
                    <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'tableOptions' => ['class' => 'table table-striped table-hover table-condensed '],
                        'layout' => "{items}\n{pager}",
                        'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'format' => 'html',
                                'value' => function ($data) {
                                    return $data->getBusImage();
                                },
                                'options' => ['width' => '40px']
                            ],
                            [
                                'attribute' => 'route_no',
                                'value' => function ($data) {
                                    return $data->route_no;
                                },
                                'format' => 'html',
                                'options' => ['width' => '80px']
                            ],
                            [
                                'attribute' => 'from_point_id',
                                'filter' => $searchModel->getPointList(),
                                'value' => function ($data) {
                                    $fromPoint = $data->fromPoint;
                                    $toPoint = $data->toPoint;
                                    if (isset($fromPoint))
                                        return $fromPoint->name;
                                },
                                'format' => 'html',
                            ],
                            [
                                'attribute' => 'to_point_id',
                                'filter' => $searchModel->getPointList(),
                                'value' => function ($data) {
                                    $toPoint = $data->toPoint;
                                    if (isset($toPoint))
                                        return $toPoint->name;
                                },
                                'format' => 'html',
                            ],
                            [
                                'attribute' => 'length',
                                'value' => function ($data) {
                                    return (float)$data->length . ' ' . Yii::t('app', 'km');
                                },
                                'format' => 'html',
                                'options' => ['width' => '120px']
                            ],
                            [
                                'attribute' => 'cycle_min',
                                'value' => function ($data) {
                                    return $data->cycle_min . ' ' . Yii::t('app', 'min');
                                },
                                'format' => 'html',
                                'options' => ['width' => '120px']
                            ],
                            [
                                'attribute' => 'planned_period_min',
                                'value' => function ($data) {
                                    return $data->planned_period_min . ' ' . Yii::t('app', 'min');
                                },
                                'format' => 'html',
                                'options' => ['width' => '120px']
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{avg_review_keyword} {important_keywords}',
                                'header' => Yii::t('app','On map'),
                                'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                                'contentOptions' => ['style' => 'text-align:right'],
                                'buttons' => array(
                                    'important_keywords' => function ($url, $model) {
                                        if (isset($model->waypoints) && strlen(trim($model->waypoints)) > 10) {
                                            return Html::a('<i class="fa fa-map-o"> </i>',
                                                ['/route/map', 'id' => $model['id']],
                                                [
                                                    'title' => '',
                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#modalmap',
                                                ]
                                            );
                                        }
                                        return false;
                                    }
                                ),
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <!--</div>-->

    <div class="modal remote fade" id="modalmap">
        <div class="modal-dialog">
            <div class="modal-content loader-lg"></div>
<!---->
<!--            <div class="leafler-map">-->
<!--                <div id="map" style="height:550px;"></div>-->
<!--            </div>-->
        </div>
    </div>


<?php
$script = <<< JS
        // $('#modalmap').on('loaded.bs.modal', function (e) {
        //     debugger;
        //   initRoute();
        // });
        $('#modalmap').on("hidden.bs.modal", function (e) {
            $(e.target).removeData("bs.modal").find(".modal-content #map").empty();
        });

        // var map;
        // var wpSource = [];
        // var control;

        // function initMap(){
        //   debugger;
        //   // var startLat=$('#routewrapper-from_point_id').children('option:selected').data('lat');
        //   // var startLng=$('#routewrapper-from_point_id').children('option:selected').data('lng');
        //   //
        //   // var endLat=$('#routewrapper-to_point_id').children('option:selected').data('lat');
        //   // var endLng=$('#routewrapper-to_point_id').children('option:selected').data('lng');
        //   //
        //   // startPoint={lat:startLat, lng:startLng};
        //   // endPoint={lat:endLat, lng:endLng};
        //   initRoute(startPoint,endPoint,false);
        // }

JS;

$this->registerJs($script, yii\web\View::POS_READY);

$this->registerJsFile('https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/js/leaflet/leaflet-routing-machine/dist/leaflet-routing-machine.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/js/leaflet/leaflet-routing-machine/src/Control.Geocoder.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/js/leaflet/config.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile(Yii::$app->request->baseUrl . '/source/js/leaflet/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>