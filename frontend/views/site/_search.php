<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\SearchForm;

$model = new SearchForm();
?>

<?php $form = ActiveForm::begin(['action'=>['site/search'],'method'=>'get','id' => 'site-search-form','fieldConfig' => ['options' => ['tag' => false]]]); ?>
<div class="input-group">
    <?= $form->field($model, 'title')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','Search'),'class'=>'form-control'])->label(false) ?>
    <span class="input-group-btn">
        <?= Html::submitButton(Yii::t('app','Search'), ['class' => 'btn btn-primary', 'id'=>'site-search-button']) ?>
    </span>
</div>
<?php ActiveForm::end(); ?>

<!--<form action="#">
                            <div class="input-group">
                                <input type="text" placeholder="Search" class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Gözleg</button>
                                </span>
                            </div>
                        </form>-->
