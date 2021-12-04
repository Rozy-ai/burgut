<?php
namespace common\components;

use common\models\wrappers\EventToSeatWrapper;
use common\models\wrappers\PaymentWrapper;
use common\models\wrappers\TicketWrapper;
use kartik\mpdf\Pdf;
use Yii;
use yii\db\conditions\InCondition;
use yii\helpers\ArrayHelper;


class TicketService
{

    public function finishPaymentProcess($paymentOrderInstance)
    {
        $errors = [];
        $status = false;

        if (isset($paymentOrderInstance)) {

            $ticketModel = TicketWrapper::find()->where(['payment_id' => $paymentOrderInstance->id])->one();
            if (isset($ticketModel)) {
                if ($paymentOrderInstance->status == PaymentWrapper::STATUS_SUCCESS) {
                    $ticketModel->status = TicketWrapper::STATUS_SUCCESS;
                    $ticketModel->date_approved = \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
                } else
                    $ticketModel->status = TicketWrapper::STATUS_FAILED;

                $eventToSeats = $ticketModel->eventToSeats;
                $is_seats_booked = true;
                if (isset($eventToSeats) && count($eventToSeats) > 0) {
                    foreach ($eventToSeats as $eventToSeat) {
                        if ($paymentOrderInstance->status == PaymentWrapper::STATUS_SUCCESS)
                            $eventToSeat->status = EventToSeatWrapper::STATUS_BOOKED;
                        else
                            $eventToSeat->status = EventToSeatWrapper::STATUS_AVAILABLE;

                        if (!$eventToSeat->update())
                            $is_seats_booked = false;
                    }
                }

                if ($is_seats_booked) {
                    if (!isset($ticketModel->email_alerted_date)) {
//                    if (isset($ticketModel->email_alerted_date)) {
                        if ($this->sendEmail($ticketModel))
                            $ticketModel->email_alerted_date = \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
                    }

                    if ($ticketModel->save()) {
                        $status = true;
                    }
                }
            } else {
                $errors = ArrayHelper::merge($errors, ['message' => Yii::t('app', 'Ticket not found')]);
            }
        } else {
            $errors = ArrayHelper::merge($errors, ['message' => Yii::t('app', 'Payment order not found')]);
        }


        return [
            'status' => $status,
            'errors' => $errors,
        ];
    }


    public function registerPayment($data = array())
    {
        $errors = [];
        $model = new TicketWrapper();
        $user = Yii::$app->user->identity;

        unset($data['location'], $data['event'], $data['user'], $data['payment']);

        $model->load($data, '');
        $model->unique_code = strtoupper(uniqid());
        $model->status = TicketWrapper::STATUS_PENDING;

        if (isset($user)) {
            if (!isset($model->email))
                $model->email = $user->email;
            $model->user_id = $user->id;
        }

        if (!$model->location) {
            $event = $model->event;
            if (isset($event))
                $model->location_id = $event->location_id;
        }


        if ($model->validate()) {
            //check if all requested seats are available
            $model->seats = [];

            $errors = [];
            if (isset($data['seats']) && is_array($data['seats']) && count($data['seats']) > 0) {
                $seatIds = $data['seats'];
                $eventToSeats = EventToSeatWrapper::find()->where(['event_id' => $model->event_id])->andWhere(new InCondition('seat_id', 'IN', $seatIds))->all();
                if (isset($eventToSeats) && count($eventToSeats) > 0) {
                    foreach ($eventToSeats as $key => $eventToSeat) {
                        if (!$eventToSeat->isSeatAvailable()) {
                            $eventToSeat->addError('seat_id', Yii::t('app', 'Seat is already booked'));
                            $errors = ArrayHelper::merge($errors, ['message' => Yii::t('app', 'Seat is already booked')]);
                        }
                        $model->seats[] = $eventToSeat;
                        $model->total_price += isset($eventToSeat->price) ? $eventToSeat->price : 0;
                        $model->total_discount += isset($eventToSeat->discount) ? $eventToSeat->discount : 0;
                    }
                } else
                    $errors = ArrayHelper::merge($errors, ['message' => 'No available seats']);

            } else
                $errors = ArrayHelper::merge($errors, ['message' => Yii::t('app', 'No seats selected')]);


            if (count($errors) == 0) {
                $paymentTotalConverted = ($model->total_price - $model->total_discount) * 100;
                if (!isset($paymentTotalConverted) || $paymentTotalConverted == 0) {
                    $errors = ArrayHelper::merge($errors, ['message' => Yii::t('app', 'Payment amount is zero')]);
                }
            }

            if (count($errors) == 0) {
                if ($model->save()) {
                    $seats_booked = true;
                    foreach ($model->seats as $eventToSeat) {
                        $eventToSeat->ticket_id = $model->id;
                        $eventToSeat->status = EventToSeatWrapper::STATUS_PENDING_PAYMENT;
                        $eventToSeat->status_change_time = \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
                        if (!$eventToSeat->save()) {
                            $errors = ArrayHelper::merge($errors, ['message' => 'Error in seat booking save']);
                            $seats_booked = false;
                        }
                    }


                    if ($seats_booked) {

                        $paymentOrderInstance = null;
                        $paymentType = $model->paymentType;
                        if (isset($paymentType)) {
                            $payment_params = [];
                            $payment_params['description'] = $model->getTicketPaymentDescription();
                            $payment_params['merchant_order_number'] = strtoupper(uniqid());
                            $payment_params['sucess_url'] = "";
                            $payment_params['failure_url'] = "";
                            $payment_params['amount'] = $paymentTotalConverted;
                            $payment_params['merchant_id'] = $model->location->merchant_id;
                            $payment_params['payment_type_id'] = $paymentType->id;

                            switch ($paymentType->code) {
                                case 'halkbank_online':
                                    $paymentService = new HalkbankPaymentService();
                                    $payment_response = $paymentService->register($payment_params);      //creates Payment instance when did request

                                    if (isset($payment_response) && isset($payment_response['status']) && $payment_response['status']) {
                                        $data = $payment_response['data'];
                                        $data = ArrayHelper::merge($data, ['merchant_order_number' => $payment_params['merchant_order_number']]);
                                        $data = ArrayHelper::merge($data, ['ticket_unique_code' => $model->unique_code]);
                                        $paymentOrderInstance = PaymentWrapper::find()->where(['response_order_id' => $data['orderId']])->one();
                                    } else {
                                        $errors = ArrayHelper::merge($errors, $payment_response['errors']);
                                    }
                                    break;
                                case 'cash':
                                case 'terminal':
                                    $paymentOrderInstance = new PaymentWrapper();
                                    $paymentOrderInstance->payment_type_id = $payment_params['payment_type_id'];
                                    $paymentOrderInstance->description = $payment_params['description'];
                                    $paymentOrderInstance->merchant_order_number = $payment_params['merchant_order_number'];
                                    $paymentOrderInstance->merchant_success_url = $payment_params['sucess_url'];
                                    $paymentOrderInstance->merchant_failure_url = $payment_params['failure_url'];
                                    $paymentOrderInstance->amount = (integer)$payment_params['amount'];
                                    $paymentOrderInstance->currency_code = "934";
//                                    $paymentOrderInstance->merchant_id = ;
                                    $paymentOrderInstance->status = PaymentWrapper::STATUS_SUCCESS;
                                    if ($paymentOrderInstance->save()) {
                                        $data = ArrayHelper::merge($data, ['merchant_order_number' => $payment_params['merchant_order_number']]);
                                        $data = ArrayHelper::merge($data, ['ticket_unique_code' => $model->unique_code]);
                                    } else {
                                        $errors = ArrayHelper::merge($errors, $paymentOrderInstance->getErrors());
                                    }
                            }


                            if (count($errors) == 0 && isset($paymentOrderInstance)) {
                                $model->payment_id = $paymentOrderInstance->id;
                                if ($model->update()) {
                                    return [
                                        'status' => true,
                                        'data' => $data
                                    ];
                                }
                            }

                        } else
                            $errors = ArrayHelper::merge($errors, ['message' => 'No payment type selected']);

                    } else {
                        //free seats in case of payment error
                        foreach ($model->seats as $eventToSeat) {
                            $eventToSeat->ticket_id = null;
                            $eventToSeat->status = EventToSeatWrapper::STATUS_AVAILABLE;
                            $eventToSeat->status_change_time = \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
                            $eventToSeat->save();
                        }
                        $errors = ArrayHelper::merge($errors, ['message' => 'Seats are not booked']);
                    }
                } else {
                    $errors = ArrayHelper::merge($errors, $model->getErrors());
                }
            }
        } else {
            echo "In ticket validation";
            echo "<pre>";
            print_r($model->attributes);
            echo "</pre>";
            $errors = ArrayHelper::merge($errors, $model->getErrors());
        }

        return [
            'status' => count($errors) == 0,
            'errors' => $errors,
            'total' => 1
        ];
    }


    public function sendEmail($ticketModel)
    {
        if (isset($ticketModel) && isset($ticketModel->email) && strlen(trim($ticketModel->email)) > 0) {
            $pathToPdfFile = $ticketModel->getPdfPath();

            $view = 'ticket';
            $email = $ticketModel->email;
            $subject = Yii::t('app', 'TurkmenTeatrlary Elektron bilet: ' . $ticketModel->unique_code);
            $params = ['model' => $ticketModel];


            $mailer = Yii::$app->mailer;
            $mailer->viewPath = '@common/mail';
            $mailer->getView()->theme = Yii::$app->view->theme;
            $sender = isset(Yii::$app->params['adminEmail']) ? Yii::$app->params['adminEmail'] : 'hasaphesip@gmail.com';


            return $mailer->compose(['html' => $view], $params)
                ->attach($pathToPdfFile, [
                    'fileName' => $ticketModel->fullName . ".pdf",
                    'contentType' => 'application/pdf'
                ])
                ->setTo($email)
                ->setFrom($sender)
                ->setSubject($subject)
                ->send();
        }
    }


    public function generatePdf($ticketModel)
    {
        $uploadPath = Yii::getAlias('@uploads');
        $ticketFolderName = 'tickets';
        $filename = $ticketModel->unique_code . '.pdf';
        $ticketPdfUploadFolder = $uploadPath . DIRECTORY_SEPARATOR . $ticketFolderName;
        $fullPath = $ticketPdfUploadFolder . DIRECTORY_SEPARATOR . $filename;

        //create direcroty if nof found
        if (!is_dir($ticketPdfUploadFolder)) {
            mkdir($ticketPdfUploadFolder, 0755, true);
        }

        if (!isset($ticketModel->pdf_path) || !file_exists($fullPath)) {
            // get your HTML raw content without any layouts or scripts
            $content = Yii::$app->controller->renderPartial('@backend/views/ticket/_pdf_content', ['model' => $ticketModel]);

            // setup kartik\mpdf\Pdf component
            $pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_UTF8,
                // A4 paper format
                'format' => Pdf::FORMAT_A4,
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // stream to browser inline
//                'destination' => Pdf::DEST_FILE,
                // your html content input
//                'content' => $content,
                // format content from your own css file if needed or use the
                // enhanced bootstrap css built by Krajee for mPDF formatting
//            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
//            'cssFile' => '@webroot/css/bootstrap.min.css',
                // any css to be embedded if required
//                'cssInline' => '.kv-heading-1{font-size:18px} ',
                // set mPDF properties on the fly
                'options' => ['title' => $ticketModel->fullName],
                // call mPDF methods on the fly
                'methods' => [
//                'SetHeader' => ['Krajee Report Header'],
//                'SetFooter' => ['{PAGENO}'],
                ],
//            'marginLeft'=>0,
//            'marginRight'=>0,
//            'marginTop'=>0,
//            'marginBottom'=>0,
            ]);

            // return the pdf output as per the destination setting
//        return $pdf->render();

            $pdf->output($content, $fullPath, Pdf::DEST_FILE);

            if (file_exists($fullPath)) {
                $ticketModel->pdf_path = $filename;
                if ($ticketModel->save())
                    return $fullPath;
            }

            return null;
        } else {
            return $fullPath;
        }
    }


    public function generateQrCode($ticketModel, $isReturnUrl = true)
    {
        $uploadsUrl = Yii::getAlias('@uploadsUrl');
        $uploadPath = Yii::getAlias('@uploads');
        $qrFolderName = 'tickets' . DIRECTORY_SEPARATOR . 'qrCodes';
        $filename = $ticketModel->unique_code . '.png';
        $ticketQrCodeUploadFolder = $uploadPath . DIRECTORY_SEPARATOR . $qrFolderName;
        $fullPath = $ticketQrCodeUploadFolder . DIRECTORY_SEPARATOR . $filename;
        $fullUrl = $uploadsUrl . '/tickets/qrCodes/' . $filename;

        //create direcroty if nof found
        if (!is_dir($ticketQrCodeUploadFolder)) {
            mkdir($ticketQrCodeUploadFolder, 0755, true);
        }

        if (!isset($ticketModel->qr_code_path) || !file_exists($fullPath)) {
            $qrCode = (new \Da\QrCode\QrCode($ticketModel->unique_code))
                ->setSize(180)
                ->setMargin(0)
                ->useForegroundColor(0, 0, 0);

            $qrCode->writeFile($fullPath);
            if (file_exists($fullPath)) {
                $ticketModel->qr_code_path = $filename;
                if ($ticketModel->save()) {
                    return $isReturnUrl ? $fullUrl : $fullPath;
                }
            }

            return null;
        } else {
            return $isReturnUrl ? $fullUrl : $fullPath;
        }
    }

}
