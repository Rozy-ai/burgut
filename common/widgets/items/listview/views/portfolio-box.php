<?php
use yii\helpers\Html;

$list = $this->context->list;

if (isset($list) && count($list) > 0) { ?>
    <div class="section portfolio">
        <div class="row">
            <?php foreach ($list as $key => $model) {
                $href = $model->url;
                $path = $model->getThumbPath(265, 402,'w');
                ?>
                <div class="col-md-3 col-xs-12">
                    <a class="portfolio-item portfoliocat-264 "
                       href="<?= $href ?>"
                       data-path-hover="M 0,0 0,50 90,70 180,50 180,0 z">
                        <figure>
                            <div class="portfolio-img"
                            >
                                <?php echo Html::img($path) ?>
                            </div>

                            <svg viewBox="0 0 180 320" preserveAspectRatio="none">
                                <path
                                    d="M0,0C0,0,0,180,0,180C0,180,90,130,90,130C90,130,180,180,180,180C180,180,180,0,180,0C180,0,0,0,0,0"
                                    style="fill:#09ad42"></path>
                                <desc>Created with Snap</desc>
                                <defs></defs>
                            </svg>

                            <figcaption>
                                <div class="portfolio-content">
                                    <div class="seperator"></div>
                                    <h3><?= $model->title ?></h3>
                                    <p><?= $model->description ?></p>
                                </div>
                                <div class="button-container">
                                    <button><?= Yii::t('app', 'Read more') ?></button>
                                </div>
                            </figcaption>
                        </figure>
                    </a>

                </div>
            <?php } ?>
        </div>
    </div>

<?php } ?>
