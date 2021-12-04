<?php

use common\models\wrappers\CategoryWrapper;
use yii\helpers\Html;
use yii\helpers\Url;

$items = $this->context->items;
$title = $data->title;
?>

<?php
if (isset($items) && count($items) > 0) {?>
    <section class="our_works_section">
        <div class="title_section">
            <h1><?=$this->context->widget_title?></h1>
            <div class="divider"></div>
            <?php
            $our_works = CategoryWrapper::find()->where(['code' => 'our_works'])->one();
            echo html::a(yii::t('app', 'View All Works').' <i class="fa fa-long-arrow-right"></i>', $our_works->url, ['class' => 'view_all'])
            ?>
        </div>
        <div  class="work_list slider">
            <?php
                foreach ($items as  $item):
            ?>
                <a href="<?=$item->url?>" class="project_wrapper" >
                    <div class="work_item">
                        <div class="work_img">
                            <?=Html::img($item->getThumbPath(400 ,320 ,'w'), ['alt' => 'Works', 'class' => 'my_img'])?>
                            <div class="gradient-overlay darker"></div>
                        </div>
                        <div class="work_content">
                            <div class="eye_img">
                                <?=Html::img(Url::to('@web/source/img/eye.svg'), ['alt' => 'Eye', 'width' => '20'])?>
                            </div>
                            <div class="content_title">
                                <h4><?=$item->title?></h4>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
                endforeach;
            ?>
        </div>
        <div class="work_slider_btn">

        </div>
    </section>
<?php } ?>


<?php

echo $this->registerJS('
    $(\'.work_list\').slick({
        dots: false,
        infinite: false,
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 3,
        autoplay: false,
        prevArrow: \'<button class="slick-prev" aria-label="Previous" type="button"><img src="/source/img/png/arrow.png" alt="" width="15" style="transform: rotate(180deg)"></button>\',
        nextArrow: \'<button class="slick-next" aria-label="Next" type="button"><img src="/source/img/png/arrow.png" alt="" width="15" ></button>\',
        appendArrows:".work_slider_btn",
        cssEase: \'ease\',
          responsive: [
             {
                 breakpoint: 1024,
                 settings: {
                     slidesToShow: 3,
                     slidesToScroll: 3,
                 }
             },
             {
                 breakpoint: 768,
                 settings: {
                     slidesToShow: 2,
                     slidesToScroll: 2
                 }
             },
             {
                 breakpoint: 480,
                 settings: {
                     slidesToShow: 1,
                     slidesToScroll: 1
                 }
             }
         ]
    });
', \yii\web\View::POS_END);

?>
