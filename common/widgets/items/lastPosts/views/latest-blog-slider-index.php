<?php

use common\models\wrappers\CategoryWrapper;
use yii\helpers\Html;

$list = $this->context->list;
?>

    <?php
    if (isset($list) && count($list) > 0) { ?>
        <section class="blog_section">
            <div class="container">
                <div class="title_blog_section">
                    <h2>Latest <span>Blog</span></h2>
                    <?php
                    $blog = CategoryWrapper::find()->where(['code' => 'blog'])->one();
                    ?>
                    <?=html::a(yii::t('app', 'View All').' <i class="fa fa-long-arrow-right"></i>', $blog->url, ['class' => 'view_all'])?>
                </div>
                <div class="latest-blog-slider">
                    <?php foreach ($list as $key => $data) {
                        $href = $data->url;
                        ?>
                        <div class="blog-slider-item">
                            <div class="blog_card">
                                <div class="blog_card_img">
                                    <?=html::a(html::img($data->getThumbPath()), $data->url)?>
                                </div>
                                <div class="blog_card_caption">
                                    <div class="blog_card_title">
                                        <?=html::a('<h3>'.yii::$app->controller->truncate($data->title, 15, 50).'</h3>', $data->url)?>
                                    </div>
                                    <div class="blog_card_info">
                                        <span class="author">John</span>
                                        <span class="readed_time"><i class="fa fa-eye"></i> <?=$data->visited_count?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } ?>

<?php

echo $this->registerJS('
    $(\'.latest-blog-slider\').slick({
        dots: false,
        infinite: true,
        centerMode: true,
        centerPadding: "80px",
        initialSlide: 1,
        speed: 300,
        slidesToShow: 2.4,
        swipeToSlide: true,
        autoplay: true,
        arrows:false,
         responsive: [
             {
                 breakpoint: 1024,
                 settings: {
                     slidesToShow: 2,
                     centerPadding: "0",

                 }
             },
             {
                 breakpoint: 768,
                 settings: {
                     slidesToShow: 1,
                     centerPadding: "0",
                 }
             },
             {
                 breakpoint: 480,
                 settings: {
                     slidesToShow: 1,
                     centerPadding: "0",
                 }
             }
         ]
    });
', \yii\web\View::POS_END);

?>

