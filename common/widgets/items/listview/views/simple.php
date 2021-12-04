<?php
$list = $this->context->list;

if (isset($list) && count($list) > 0) { ?>
    <?php foreach ($list as $key => $model) {
        $href = $model->url;
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="sm-heading">
                    <a href="<?= $href ?>"><?= $model->title ?></a>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
