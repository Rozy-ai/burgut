<?php
namespace common\components;

use common\models\wrappers\MerchantWrapper;
use common\models\wrappers\PaymentWrapper;
use Yii;
use yii\helpers\ArrayHelper;


class HalkbankPaymentService
{

    public function register($params)
    {
//        $params = Yii::$app->request->post();
        $user = Yii::$app->user->identity;
        $paymentInstance = new PaymentWrapper();
        $errors = [];
        $response = null;
        $return_response = [];
        $register_url = null;

        if (isset($params) && isset($params['merchant_id'])) {
            $merchantInstance = MerchantWrapper::find()->where(['id' => $params['merchant_id'], 'status' => MerchantWrapper::STATUS_ACTIVE])->one();
            if ($merchantInstance) {
                $sameOrderNumberPayment = PaymentWrapper::find()->where(['merchant_order_number' => $params['merchant_order_number'], 'merchant_id' => $merchantInstance->id])->one();
                if (!isset($sameOrderNumberPayment)) {
                    $paymentInstance->payment_type_id = $params['payment_type_id'];
                    $paymentInstance->description = $params['description'];
                    $paymentInstance->merchant_order_number = $params['merchant_order_number'];
                    $paymentInstance->merchant_success_url = $params['sucess_url'];
                    $paymentInstance->merchant_failure_url = $params['failure_url'];
                    $paymentInstance->amount = (integer)$params['amount'];
                    $paymentInstance->currency_code = $merchantInstance->currency;
                    $paymentInstance->status = PaymentWrapper::STATUS_PENDING;
                    $paymentInstance->merchant_id = $merchantInstance->id;
                    $register_url = $paymentInstance->formatBankRegisterUrl();

                    if (isset($paymentInstance) && $paymentInstance->save()) {
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $register_url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_SSL_VERIFYPEER => false,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                "cache-control: no-cache"
                            ),
                        ));
                        $response = curl_exec($curl);
                        $err = curl_error($curl);
                        curl_close($curl);

                        if ($err) {
                            $errors = ArrayHelper::merge($errors, ['message' => $err]);
                        } else {
                            $response = json_decode($response, true);
                            if (isset($response) && is_array($response) && isset($response['errorCode'])) {
                                $paymentInstance->response_error_code = $response['errorCode'];

                                if ($response['errorCode'] > 0 && isset($response['errorMessage'])) {
                                    $errors = ArrayHelper::merge($errors, ['message' => $response['errorMessage']]);
                                } else {
                                    $return_response = $response;
                                    if (isset($response['orderId']) && isset($response['formUrl'])) {
                                        $paymentInstance->response_order_id = isset($response['orderId']) ? $response['orderId'] : null;
                                        $paymentInstance->response_form_url = isset($response['formUrl']) ? $response['formUrl'] : null;
                                    } else {
                                        $errors = ArrayHelper::merge($errors, ['message' => Yii::t('app', 'Error in online banking response')]);
                                    }
                                }
                            }

                            $paymentInstance->status = PaymentWrapper::STATUS_PENDING;
                            if (!$paymentInstance->update()) {
                                $errors = ArrayHelper::merge($errors, $paymentInstance->getErrors());
                            }
                        }
                    } else {
                        $errors = ArrayHelper::merge($errors, $paymentInstance->getErrors());
                    }
                } else {
                    $errors = ArrayHelper::merge($errors, ['message' => 'Order with this order number is already registered for this merchant']);
                }
            } else {
                $errors = ArrayHelper::merge($errors, ['message' => 'Active merchant was not found for this user']);
            }
        }else{
            $errors = ArrayHelper::merge($errors, ['message' => 'Merchant is empty']);
        }


        return [
            'status' => count($errors) == 0,
            'errors' => $errors,
            'data' => $return_response,
            'total' => 1,
        ];
    }


}
