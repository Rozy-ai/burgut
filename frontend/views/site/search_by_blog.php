<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Breadcrumbs;
$this->title = yii::t('app', 'Gözleg sahypasy');
$cateogryImage = '/uploads/cache/category/54a3fc93b079d04a9a6a8487976716cc-1024x7688.jpg';
    $style = 'background: linear-gradient(90deg, rgba(86,171,47,1) 0%, rgba(168,224,99,1) 100%) center center no-repeat;background-size: cover;
        background-attachment: fixed;'; 
?>

   <section class="breadcrumb_area_two parallaxie" data-background="<?=$cateogryImage?>" style="<?=$style?>">
        <!-- <div class="overlay"></div> -->
        <div class="container">
            <div class="breadcrumb_content">
                <?php if(isset($this->title) && !isset($this->params['no-title'])) { echo'<h1>'.$this->title.'</h1>'; } ?>
                <?php
                echo Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('app', 'Home'),
                        'url' => Yii::$app->homeUrl,
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => [
                            'class' => 'nav'
                    ]
                ]);
                ?>
            </div>
        </div>
    </section>

<!-- <section class="header_page service_list_page" style="<?=$style?>">
    <div class="breadcrumb_overlay">
        <div class="container">
            <div class="page_title">
                <div class="title_text_block">
                    <div class="title_text_decoration"></div>
                    <h1><?=$this->title?></h1>
                </div>
            </div>
        </div>
</section> -->

<section class="blog_list py-8">
    <div class="container">
        <h4 style="margin-top: 3%">Gözlenen söz: <?=$query ?></h4>
        <?php
            if (count($items) > 0):
        ?>
        <div class="row">


            <?php
                foreach ($items as $item){
                   echo $this->render('_search_view_by_blog',[
                           'model' => $item
                   ]);
                }
             ?>
            <div class="clearfix"></div>
            <div class="col-xs-12">
                <div class="blog-post-pagination text-center">
                    <?php
                    echo LinkPager::widget([
                        'pagination' => $pages,
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <?php
            endif;
        ?>
        <?php
            if (count($items) == 0):
        ?>
                <h2><?=yii::t('app', 'No results found.');?></h2>
        <?php
            endif;
        ?>
    </div>
</section>