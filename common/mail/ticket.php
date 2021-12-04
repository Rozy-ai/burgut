<?php
/* @var $this yii\web\View */
?>

<div style="background-color:#f3f3f3;min-width:600px">
    <table cellpadding="0" width="100%" height="100%" cellspacing="0"
           style="background-color: #f3f3f3;
            min-width: 600px;
            font-family: Arial,serif;
            min-height: 500px;
            vertical-align: top;">
        <tbody>
        <tr>
            <td style="vertical-align:top">
                <div style="height:137px;background-color:#00a652;width:100%"></div>
            </td>
            <td style="vertical-align:top;min-width:600px;width:600px">
                <div style="background-color:#00a551">
                    <table cellpadding="0" style="text-align:center" cellspacing="0" width="100%" height="103">
                        <tbody>
                        <tr>
                            <td style="text-align:center;vertical-align:middle;">
                                <table cellpadding="0" cellspacing="0" style="text-align:center;">
                                    <tbody>
                                    <tr>
                                        <td style="font-size: 28px;color: #fff;">TURKMENTEATRLARY</td>
                                        <td style="">
                                            <div
                                                style="margin: 0px 15px;width:2px;height: 24px;background: #e8fff3;"></div>
                                        </td>
                                        <td style="white-space:nowrap;color: #ffffff;font-size: 17px;">
                                            Elektron petegi
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>


                <div
                    style="background-color:#fff;padding:40px 20px 50px 20px;color:#777;line-height:21px;width:600px;font-size:14px;border-top: 4px solid #eecf1f;border-bottom: 4px solid #00a652;">

                    <div style="width: 100%;border-bottom: 1px solid #dddddd;">
                        <h3 style="margin: 3px 5px;font-size: 18px;font-family: Arial,sans-serif;"><?php echo Yii::t('app', 'Petek barada maglumat') ?></h3>
                    </div>

                    <div
                        style="width: 100%;padding: 20px 0px 30px;margin-bottom: 30px;border-bottom: 1px solid #bbbbbb;display: inline-block;">
                        <div
                            style="float: left;max-width: 400px;display: inline-block;margin-top: 15px;margin-right: 17px;">
                            <?php
                            $attributes = [];
                            $eventModel = $model->event;
                            if (isset($eventModel)) {
                                $eventContent = $eventModel->loadContent();
                                if (isset($eventContent)) {
                                    $attributes = \yii\helpers\ArrayHelper::merge($attributes, [[
                                        'label' => $eventModel->getAttributeLabel('title'),
                                        'value' => $eventContent->title,
                                    ], [
                                        'label' => $eventModel->getAttributeLabel('event_start_day'),
                                        'value' => $model->formatDate($eventModel->start_time, 'dd.MM.yyyy'),
                                    ], [
                                        'label' => $eventModel->getAttributeLabel('event_start_hour'),
                                        'value' => $model->formatDate($eventModel->start_time, 'H:i'),
                                    ]]);
                                }
                            }

                            $locationModel = $model->location;
                            if (isset($locationModel)) {
                                $attributes[] = [
                                    'label' => $locationModel->getAttributeLabel('title'),
                                    'value' => $locationModel->fullTitle,
                                ];
                            }

                            $eventSeats = $model->getEventSeatNames();
                            if (isset($eventSeats)) {
                                $attributes[] = [
                                    'label' => $model->getAttributeLabel('event_to_seats'),
                                    'value' => implode($eventSeats, ','),
                                ];
                            }
                            $paymentModel = $model->payment;
                            if (isset($paymentModel)) {
                                $total_payment = $paymentModel->amount ? $paymentModel->amount / 100 : 0;
                                $attributes[] = [
                                    'label' => $paymentModel->getAttributeLabel('total_amount'),
                                    'value' => $total_payment . ' ' . Yii::t('app', 'manat'),
                                ];
                            }

                            $attributes = \yii\helpers\ArrayHelper::merge($attributes, [
                                [
                                    'label' => $model->getAttributeLabel('fullname'),
                                    'value' => $model->getFullName(),
                                ], [
                                    'label' => $model->getAttributeLabel('phone'),
                                    'value' => $model->phone,
                                ], [
                                    'label' => $model->getAttributeLabel('email'),
                                    'value' => $model->email,
                                ],
                            ]);

                            echo \yii\widgets\DetailView::widget([
                                'model' => $model,
                                'attributes' => $attributes,
                                'template' => '<tr>
                                        <th style="padding-bottom:10px;font-size:13px; font-weight:normal; width: 100px; padding-right: 20px; color: #888; text-align: left">{label}:</th>
                                        <td style="font-size:15px; font-weight:bolder; color: #222; text-align: left">{value}</td>
                                    </tr>'
                                //                    'template' => '<div style="display: block; width: 100%; margin-bottom: 10px">
                                //                                    <div style="font-size:13px; width: 100px; float: left; padding-right: 20px; color: #888">{label}:</div>
                                //                                    <div style="font-size:16px;min-width: 300px;float: left;font-family: sans-serif;">{value}</div>
                                //                                </div>',
                                //                    'options' => [
                                //                        'tag' => 'div',
                                //                    ]
                            ])
                            ?>
                        </div>

                        <div style="float:left;max-width: 170px;display: inline-block;margin-top: 20px;">
                            <div
                                style="font-size: 16px;text-transform: uppercase;font-weight: bolder;margin-bottom: 6px;"><?php echo $model->getAttributeLabel('ticket_id') . ":"; ?></div>
                            <div
                                style="border: 1px solid #222;font-size: 19px;font-weight: bold;padding: 7px;text-transform: uppercase;margin-bottom: 8px;"><?php echo $model->unique_code; ?></div>
                            <div
                                class="ticker_qr_code"><?php echo \yii\helpers\Html::img($model->getQrCodePath()); ?></div>
                        </div>
                    </div>
                    <div
                        style="width: 100%;padding: 20px 15px;border: 2px solid #404040;display: inline-block;box-sizing: border-box;font-size: 13px;margin-bottom: 30px;">
                        <h3 style="margin: 0px"><?= Yii::t('app', 'Pay Attention') ?></h3>
                        <div>
                            <?= Yii::t('app', 'ticket_attention_text') ?>
                        </div>
                    </div>

                    <div style="width: 100%; display: inline-block; font-size: 13px;">
                        @ <?= \yii\helpers\Html::a('Turkmenteatrlary.gov.tm ', 'https://turkmenteatrlary.gov.tm') ?><?php echo date('Y') . '.' . Yii::t('app', 'All rights reserved') ?>
                    </div>
                </div>
            </td>
            <td style="vertical-align:top">
                <div style="height:137px;background-color:#00a652;width:100%"></div>
            </td>
        </tr>
        </tbody>
    </table>
</div>

