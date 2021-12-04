<?php
$menuCategories = \common\models\wrappers\CategoryWrapper::find()->where(['top' => 1, 'status' => 1, 'parent_id' => null])->all();
?>

<ul>

    <li>
        <?= \yii\bootstrap\Html::a(
            '<i class="fa fa-home" aria-hidden="true"> </i> ' .
            Yii::t(
                'app',
                'Home'
            ),
            ['/site/index']
        ) ?>
    </li>
    <?php
    foreach ($menuCategories as $categoryModel) { ?>
        <li>
        <?php
        $categoryItems = \common\models\wrappers\ItemWrapper::find()->where(['category_id' => $categoryModel->id])->all();
        if (isset($categoryItems)) {
            if (count($categoryItems) > 1) {
                ?>
                <a href="<?= $categoryModel->getUrl() ?>"><?= $categoryModel->getName() ?>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </a>
                <? echo '<div class="mega-menu mega-2">';
                foreach ($categoryItems as $item) {
                    $childThumb = $item->getThumbPath(300, 180);
                    ?>
                    <span>
                                                      <a href="<?= $item->getUrl() ?>">
                                                         <span><?= $item->title ?></span>
                                                          <img src="<?= $childThumb ?>" alt="">
                                                      </a>
                                                    </span>
                <?php }
                echo "</div>";
            } elseif (count($categoryItems) == 1) {
                $item = $categoryItems[0];
                ?>
                <li><a href="<?= $item->getUrl() ?>"><?= $item->title ?></a></li>
            <?php }
        }
        ?>
        </li>
    <?php } ?>
    <li>
        <?= \yii\bootstrap\Html::a(
            Yii::t(
                'app',
                'Galereýa'
            ),
            ['/gallery/index']
        ) ?>
    </li>
    <li>
        <?= \yii\bootstrap\Html::a(
            Yii::t(
                'app',
                'Contact us'
            ),
            ['/site/contact']
        ) ?>
    </li>
</ul>
