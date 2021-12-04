<?php

use common\models\wrappers\ImageWrapper;
use yii\helpers\Html;
use yii\grid\GridView;

$this->registerCssFile(Yii::$app->request->baseUrl . '/source/css/jquery.fancybox.min.css');
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/js/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AlbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title . " | " . Yii::t('app', 'Gallery');
$this->params['breadcrumbs'][] = array ('url' => \yii\helpers\Url::to(['gallery/index']), 'label' => Yii::t('app', 'Gallery'));
$this->params['breadcrumbs'][] = Yii::$app->controller->truncate($model->title, 8, 65);


?>


    <!-- Item Page -->
    <div class="container">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <h1 class="page-title">
                    <?php echo $model->title; ?>
                </h1>
                <?php
                if ($model->type == ImageWrapper::IMAGE_VIDEO) {
                    $documents = $model->documents;
                    if (isset($documents) && count($documents) > 0) {
                        $document = $documents[0];
                        $thumbImageUrl = $document->resize(390, 300, 'h', true);

                        $videoDocuments = $model->videoDocuments;
                        if (isset($videoDocuments) && count($videoDocuments) > 0) {
                            $videoDocument = $videoDocuments[0];
                            $videoUrl = $videoDocument->getFullPath();

                            echo \wbraganca\videojs\VideoJsWidget::widget([
                                'options' => [
                                    'class' => 'video-js vjs-default-skin vjs-big-play-centered',
//                        'poster' => "http://www.videojs.com/img/poster.jpg",
                                    'poster' => $thumbImageUrl,
                                    'controls' => true,
                                    'preload' => 'auto',
                                    'width' => '970',
                                    'height' => '400',
                                ],
                                'jsOptions' => [
                                    'VIDEOJS_NO_DYNAMIC_STYLE' => true
                                ],
                                'tags' => [
                                    'source' => [
//                            ['src' => 'http://vjs.zencdn.net/v/oceans.mp4', 'type' => 'video/mp4'],
                                        ['src' => $videoUrl, 'type' => 'video/mp4'],
//                            ['src' => 'http://vjs.zencdn.net/v/oceans.webm', 'type' => 'video/webm']
                                    ],
                                    'track' => [
                                        ['kind' => 'captions', 'src' => 'http://vjs.zencdn.net/vtt/captions.vtt', 'srclang' => 'en', 'label' => 'English']
                                    ]
                                ]
                            ]);
                        }
                    }
                } else {
                    ?>
                    <div id="gallery-list">
                        <?php
                        $documents = $model->documents;
                        foreach ($documents as $doc) {
                            echo $this->render('_gallery_view', ["model" => $doc]);
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

<?php
$script = <<< JS
    var visible = $('.fancybox');
    $("body").on("click",".fancybox",function(e){
        e.preventDefault();
        $.fancybox.open( visible, {
            infobar : true,
            arrows  : true,
            loop : true,
            protect: true,
            image : {
                preload : "auto",
            },
            thumbs : {
                autoStart : true
            }
        }, visible.index( this ) );
    
        return false;
    });
JS;

$this->registerJs($script, yii\web\View::POS_READY);

?>