<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerCssFile(Yii::$app->request->baseUrl . '/source/css/jquery.fancybox.min.css');
$this->registerJsFile(Yii::$app->request->baseUrl . '/source/js/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AlbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Gallery');
$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="layer">
                    <div class="header">
                        <h3 class="headerColor">
                            <?php echo Yii::t('app', 'Gallery'); ?>
                        </h3>
                    </div>
                    <div class="row">
                        <?= \yii\widgets\ListView::widget([
                            'dataProvider' => $dataProvider,
                            'id' => 'gallery-list',
                            'itemView' => '_view',
                            'layout' => "{items}\n{pager}",
                            'viewParams' => [],
                            'itemOptions' => [
                                'tag' => false,
                            ],
                            'options' => [
                                'class' => '',
                            ],
                        ]); ?>
                    </div>
                </div>
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