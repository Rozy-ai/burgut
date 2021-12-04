<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $model->unique_code;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ticket Wrappers'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php if ($model->status == \common\models\wrappers\TicketWrapper::STATUS_SUCCESS) { ?>
    <p>
        <?= Html::a(Yii::t('app', 'Download'), $model->getPdfDownloadUrl(), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Resend Email'), ['send-email', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
<?php } ?>

<div
    style="max-width: 800px;background: #fff;font-family: Arial, sans-serif;box-shadow: 0px 0px 5px #ddd;padding: 15px;">

    <div style="display: block;width: 100%; ">
        <div style="display: block;font-size: 24px;color: #888;padding-top: 30px;">
            <span style="font-weight: normal;">TURKMENTEATRLARY</span> |
            <span style="font-size: 18px">Elektron petegi</span>
        </div>
    </div>


    <div
        style="display: block; border-top: 3px solid #444;border-bottom: 4px solid #3e3e3e;margin: 10px auto;padding: 20px 25px;">

        <div style="width: 100%; padding: 20px 0px;  margin-bottom: 20px;">
            <div style="float: left;width: 60%; border: 0px solid #f45; display: inline-block">
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
                        'value' => $locationModel->title,
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
                    ], [
                        'label' => $model->getAttributeLabel('status'),
                        'value' => $model->statusText,
                    ],
                ]);

                echo \yii\widgets\DetailView::widget([
                    'model' => $model,
                    'attributes' => $attributes,
                    'template' => '<div style="display: block; width: 100%; margin-bottom: 8px">
                                    <div style="font-size:13px;width: 150px;padding-right: 20px;color: #888;display: inline-block;">{label}:</div>
                                    <div style="font-size:15px;color:#000;font-weight: bold;font-stretch: semi-expanded;max-width: 250px;font-family: Verdana, Arial, sans-serif;display: inline-block;">{value}</div>
                                </div>',
                    'options' => [
                        'tag' => 'div',
                    ]
                ])
                ?>
            </div>


            <div style="float:right;width: 180px;display: inline-block;margin-top: 0px;">
                <div
                    style="font-size: 16px;text-transform: uppercase;font-weight: bolder;margin-bottom: 2px;"><?php echo $model->getAttributeLabel('ticket_id') . ":"; ?></div>
                <div
                    style="border: 1px solid #222;font-size: 18px;font-weight: bold;padding: 7px;text-transform: uppercase;margin-bottom: 20px; float: left;"><?php echo $model->unique_code; ?></div>
                <div
                    class="ticker_qr_code"><?php echo \yii\helpers\Html::img($model->getQrCodePath(true)); ?></div>
            </div>
        </div>

        <?php if ($model->status == \common\models\wrappers\TicketWrapper::STATUS_SUCCESS && isset($paymentModel) && isset($paymentModel->status_response_json)) { ?>
            <?php
            $payment_status_response = json_decode($paymentModel->status_response_json, true);
            if (isset($payment_status_response)) { ?>

                <div
                    style="width: 100%;border-bottom: 1px solid #dddddd;margin-bottom: 15px;display: inline-block;margin-top: 37px;">
                    <h3 style="margin: 3px 5px;font-size: 18px;font-family: Arial,sans-serif;"><?php echo Yii::t('app', 'Töleg maglumatlary') ?></h3>
                </div>

                <table width="100%" style="margin-bottom: 45px; font-size: 12px;">
                    <thead>
                    <tr>
                        <th style="border-bottom: 1px solid #dddddd">№</th>
                        <th style="border-bottom: 1px solid #dddddd">Töleg nomeri</th>
                        <th style="border-bottom: 1px solid #dddddd">Möçberi</th>
                        <th style="border-bottom: 1px solid #dddddd">Maglumatlar</th>
                        <th style="border-bottom: 1px solid #dddddd">Senesi</th>
                        <th style="border-bottom: 1px solid #dddddd">Sagady</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <?php
                            if (isset($payment_status_response['OrderNumber']))
                                echo $payment_status_response['OrderNumber'];
                            ?>
                        </td>
                        <td>
                            <?php
                            if (isset($payment_status_response['Amount']))
                                echo $payment_status_response['Amount'] / 100;
                            ?>
                        </td>
                        <td>
                            <?php
                            $infoStr = "";
                            if (isset($payment_status_response['cardholderName'])) {
                                $infoStr = strtoupper($payment_status_response['cardholderName']);
                            }
                            if (isset($payment_status_response['Pan'])) {
                                $infoStr = $infoStr . " " . $payment_status_response['Pan'];
                            }

                            echo $infoStr;
                            ?>
                        </td>
                        <td>
                            <?php
                            if (isset($paymentModel->date_created))
                                echo $paymentModel->formatDate($paymentModel->date_created, 'dd.MM.yyyy');
                            ?>
                        </td>
                        <td>
                            <?php
                            if (isset($paymentModel->date_created))
                                echo $paymentModel->formatDate($paymentModel->date_created, 'H:i');
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            <?php } ?>
        <?php } ?>


        <div
            style="width: 100%;padding: 15px;border: 1px solid #555555;margin-bottom: 25px;margin-top: 25px; display: inline-block;">
            <h3 style="margin: 5px 3px"><?= \yii\helpers\Html::encode(Yii::t('app', 'Pay Attention')) ?></h3>
            <div style="font-size: 12px"><?= Yii::t('app', 'ticket_attention_text') ?></div>
        </div>

        <div style="width: 100%; display: inline-block; font-size: 13px;">
            @ <?= \yii\helpers\Html::a('Turkmenteatrlary.gov.tm ', 'https://turkmenteatrlary.gov.tm') ?><?php echo date('Y') . '.' . Yii::t('app', 'All rights reserved') ?>
        </div>
    </div>
</div>

