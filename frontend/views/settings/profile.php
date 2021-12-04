<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
$this->params['background_color'] = 'page-container-bg-solid';

?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-12">
        <div class="profile-sidebar">
            <?= $this->render('_menu',array('model'=>$model)) ?>
        </div>
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase"><?= Html::encode($this->title) ?></span>
                                </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                      <?php $form = \yii\widgets\ActiveForm::begin([
                                            'id' => 'profile-form',
                                            'options' => ['class' => 'form-horizontal'],
                                            'fieldConfig' => [
                                                'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                                                'labelOptions' => ['class' => 'col-lg-3 control-label'],
                                            ],
                                            'enableAjaxValidation'   => true,
                                            'enableClientValidation' => false,
                                            'validateOnBlur'         => false,
                                        ]); ?>

                                        <?= $form->field($model, 'name') ?>

                                        <?= $form->field($model, 'public_email') ?>

                                        <?= $form->field($model, 'phone') ?>

                                        <?= $form->field($model, 'company') ?>

                                        <?= $form->field($model, 'address') ?>

                                        <?= $form->field($model, 'website') ?>

                                        <?= $form->field($model, 'location') ?>

                                        <?= $form
                                            ->field($model, 'timezone')
                                            ->dropDownList(
                                                \yii\helpers\ArrayHelper::map(
                                                    \dektrium\user\helpers\Timezone::getAll(),
                                                    'timezone',
                                                    'name'
                                                )
                                            ); ?>

                                        <?= $form
                                            ->field($model, 'gravatar_email')
                                            ->hint(
                                                \yii\helpers\Html::a(
                                                    Yii::t('user', 'Change your avatar at Gravatar.com'),
                                                    'http://gravatar.com'
                                                )
                                            ) ?>

                                        <?= $form->field($model, 'bio')->textarea() ?>

                                        <div class="form-group">
                                            <div class="col-lg-offset-3 col-lg-9">
                                                <?= \yii\helpers\Html::submitButton(
                                                    Yii::t('user', 'Save'),
                                                    ['class' => 'btn btn-block btn-success']
                                                ) ?><br>
                                            </div>
                                        </div>

                                        <?php \yii\widgets\ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>



                    <?php if ($model->module->enableAccountDelete): ?>
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= Yii::t('user', 'Delete account') ?></h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <?= Yii::t('user', 'Once you delete your account, there is no going back') ?>.
                                    <?= Yii::t('user', 'It will be deleted forever') ?>.
                                    <?= Yii::t('user', 'Please be certain') ?>.
                                </p>
                                <?=
                                Html::a(Yii::t('user', 'Delete account'), ['delete'], [
                                    'class' => 'btn btn-danger',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure? There is no going back'),
                                ])
                                ?>
                            </div>
                        </div>
                    <?php endif ?>


                </div>
            </div>
        </div>
    </div>
</div>
