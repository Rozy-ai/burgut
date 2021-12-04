<?php
    use yii\helpers\Html;

?>


    <div class="container">
        <div class="row">


                    <?php
                    $layoutPager = '<div class="clearfix"></div><div class="col-12"><div class="blog-post-pagination text-center">{pager}</div></div>';

                    echo \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                                           // 'class' => 'item',
                        'options' => [
                            'class' => 'row'
                        ],
                        'id' => 'item-list',
                        'itemView' => '_product_list',
                        'viewParams' => [],
                        'itemOptions' => ['class' => 'col-md-4 col-sm-6 col-12 clear3BoxItem'],
                        'layout' => "{items}" . $layoutPager,

                        'pager' => [
                            'options' => [

    'class' => 'pagination justify-content-center',
],
                            'nextPageLabel' => '<i class="fa fa-arrow-right"></i>',
                            'prevPageLabel' => '<i class="fa fa-arrow-left"></i>',
                            'maxButtonCount' => 5,
                            'disabledPageCssClass' => 'disablePager',
                        ],
                    ]);
                     ?>


</div>
</div>