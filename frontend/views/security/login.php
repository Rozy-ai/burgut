<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View                   $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module           $module
 */

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<!--
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">-->
                <?php $form = ActiveForm::begin([
                    'id'                     => 'login-form',
                    'class'                     => 'login-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                ]) ?>
                <div class="input">
                <?= $form->field(
                    $model,
                    'login',
                    [
                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1','placeholder'=>$model->getAttributeLabel('Логин')],
                        'labelOptions'=>['class'=>'control-label ']
                    ]
                )->label(false) ?>
                <i class="fa fa-envelope"></i>
</div>
<div class="password">

                <?= $form
                    ->field(
                        $model,
                        'password',
                        [
                            'inputOptions' => ['class' => 'form-control', 'tabindex' => '2','placeholder'=>'пароль'],
                            'labelOptions'=>['class'=>'control-label fa fa-eye']
                        ]
                    )
                    ->passwordInput()->label(false)
         ?>
         <i class="fa fa-lock" style="font-size: 20px"></i>
         </div>
                <?= Html::submitButton(
                    Yii::t('user', 'войти'),
                    ['class' => 'btn btn-success btn-block', 'tabindex' => '3']
                ) ?>
                <br>

                <?php ActiveForm::end(); ?>
            <!--</div>-->
        <!--</div>-->
        <?php if ($module->enableConfirmation): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
            </p>
        <?php endif ?>
        <?php if ($module->enableRegistration): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
            </p>
        <?php endif ?>
        <?= Connect::widget([
            'baseAuthUrl' => ['/user/security/auth'],
        ]) ?>
    <!--</div>-->
<!--</div>-->
