<div class="container">
    <div class="center">
        <div class="payment-response">
            <br>
            <?php if ($result['status'] == true) { ?>
                <div class="icon">
                    <?php echo \yii\helpers\Html::img(\yii\helpers\Url::to('@web/source/img/checked.png')); ?>
                </div>
                <h2><?= $result['message'] ?></h2>

                <?php if (isset($paymentOrderInstance)) { ?>
                    <div class="payment-info">

                        <table>
                            <tbody>
                            <tr>
                                <td class="label">
                                    <label><?= Yii::t('app', 'Amount:') ?></label>
                                </td>
                                <td class="value">
                                    <span><?php
                                        $real_amount = (float)$paymentOrderInstance->amount;
                                        if (isset($real_amount) && is_numeric($real_amount)) {
                                            $real_amount = $real_amount / 100;
                                            echo $real_amount . " TMT";
                                        } ?>
                                        </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">
                                    <label><?= Yii::t('app', 'Service:') ?></label>
                                </td>
                                <td class="value">
                                    <span><?php echo $paymentOrderInstance->description; ?></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p class="note"><?php echo Yii::t('app', 'Note: Service will be activated between 2 to 120 minute period'); ?></p>
                        <p class="text-thanks"><?php echo Yii::t('app', 'Thanks for payment'); ?></p>
                    </div>

                <?php } ?>

            <?php } else { ?>
                <div class="icon">
                    <?php echo \yii\helpers\Html::img(\yii\helpers\Url::to('@web/source/img/warning.png')); ?>
                </div>

                <h2><?= Yii::t('app', 'Payment failed') ?></h2>

                <table>
                    <tbody>
                    <tr>
                        <td class="label">
                            <label><?= Yii::t('app', 'Reason:') ?></label>
                        </td>
                        <td class="value">
                            <span><?php echo $result['message'] ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="label">
                            <?= Yii::t('app', 'Try again') ?>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <p class="note"><?php echo Yii::t('app', 'Note: Please try again or contact with Administrator'); ?></p>
            <?php } ?>
            <br><br>
        </div>
    </div>
</div>


<style>
    .container {
        padding: 15px;
    }

    body {
        background: #eee;
    }

    .center {
        font-family: sans-serif;
        text-align: center;
        max-width: 980px;
        display: block;
        margin-top: 20px;
        background: #fff;
        box-shadow: 0px 1px 4px #ddd;
        border-radius: 4px;
    }

    .payment-response h2 {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    h2 {
        font-size: 16px;
        font-family: 'Open Sans', sans-serif;
    }

    h3 {
        font-size: 30px;
        color: #3d54d9;
        font-weight: 400;
    }

    table {
        border-spacing: 0;
        border-collapse: collapse;
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }

    td.label {
        padding: 5px;
        line-height: 1.42857143;
        vertical-align: top;
        width: 70px;
        text-align: left;
        font-size: 14px;
        font-weight: bolder;
    }

    td.value {
        padding: 5px;
        line-height: 1.42857143;
        vertical-align: top;
        text-align: left;
        font-size: 14px;
        font-weight: bolder;
        color: #1599ce;
    }

    .icon {
        display: block;
        margin: 0 auto;
        width: 90px;
        height: 90px;
    }

    .icon img {
        width: 100%;
    }

    .payment-response {
        padding: 5px;
    }

    .payment-info {
        padding: 5px;
    }

    p.note {
        font-size: 13px;
        text-align: left;
        color: #555;
        padding: 5px;
    }

    p.text-thanks {
        text-align: center;
        font-size: 13px;
        font-weight: bolder;
        margin-top: 25px;
    }
</style>