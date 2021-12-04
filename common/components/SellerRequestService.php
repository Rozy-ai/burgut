<?php
namespace common\components;
use common\models\search\AmzSellerRequestSearch;
use common\models\AmzSellerRequest;


class SellerRequestService{
    
   public function schedule(){

        $searchModel = new AmzSellerRequestSearch();
        $matchedModels = $searchModel->filterScheduled();
        
        $fake_emails=['batya224@mail.ru','lincolnmorais@gmail.com'];
        
        
        foreach ($matchedModels as $amzSellerRequest){
            
            if(isset($amzSellerRequest->coupons_array) && is_array($amzSellerRequest->coupons_array)){
                $not_sent_reviewers=$this->getNotSentReviewers($amzSellerRequest->id);
                $counts=[
                            count($not_sent_reviewers),  
                            count($amzSellerRequest->coupons_array),  
                            $amzSellerRequest->reviews_per_day
                        ];  
                echo "<pre>";
                print_r($counts);
                echo "</pre>";
                $iterate_count= min($counts);
                
                for($i=0; $i<$iterate_count; $i++){
                    $reviewer_id= array_shift($not_sent_reviewers);
                    $coupon= array_shift($amzSellerRequest->coupons_array);
                    $unique_key=  bin2hex(openssl_random_pseudo_bytes(16));
                    $activation_url=  \Yii::$app->urlManager->createAbsoluteUrl(['seller/amz-request/activate','key'=>$unique_key]);
                    $body="Please review product with ASIN:". $amzSellerRequest->product_asin." to get coupon code for review follow this url: ".$activation_url;
                    
                    $reviewer = \common\models\AmzReviewer::find()
                            ->where(['reviewer_id' => $reviewer_id])
                            ->one();
                    $email=$reviewer->email;
                    
                    
                    echo "<pre> Original Reviewer Should be: ";
                    print_r($reviewer->name);
                    echo ' email: ';
                    print_r($reviewer->email);
                    echo "</pre>";
                    echo "Activation URL: ".$activation_url;
                    
                    $email=$fake_emails[array_rand($fake_emails, 1)];
                    echo "After fake email email is ".$email;
                    
                    if(\Yii::$app->common->sendMail('Amazon product review',$body, $email)){
                        $amzRequest=new \common\models\AmzRequest();
                        $amzRequest->seller_request_id=(int)$amzSellerRequest->id;
                        $amzRequest->coupon_code=$coupon;
                        $amzRequest->unique_key=$unique_key;
                        $amzRequest->status=1;
                        $amzRequest->sent_date=date('Y-m-d H:i:s');
                        $amzRequest->amz_reviewer_id=$reviewer_id;
                        $amzRequest->email=$email;
                        if($amzRequest->save()){
                            echo "SAVED: ";
                        }else
                            print_r ($amzRequest->errors);
                    }else{
                        echo "NOT SEND EMAIL: FAILED";
                    }
                }
            }
            
            
            $amzSellerRequest->coupons=implode(PHP_EOL, $amzSellerRequest->coupons_array);
            $amzSellerRequest->last_scheduled_date=date('Y-m-d H:i:s');
            if($amzSellerRequest->save(true)){
                echo "</br>SELLER REQUEST UPDATED";
            }else{
                echo "</br>FAILED TO UPDATE SELLER REQUEST";
            }
            
        }
    }  
    
    
    
    
     
    
    public function getNotSentReviewers($sellerRequestId){
        $modelSellerRequest = $this->findModel($sellerRequestId);
        $all_reviewers=$modelSellerRequest->reviewers_array;
        
        $sendRequests= \common\models\AmzRequest::find()
        ->where([
            'seller_request_id' => $sellerRequestId,
            'status' => 1
        ])
//        ->andWhere(['not in', 'contract_id', $contracts])
        ->select(['amz_reviewer_id'])
        ->all();
        
        $sent_reviewers=  \yii\helpers\ArrayHelper::getColumn($sendRequests,'amz_reviewer_id');
        
        $not_sent_reviewers=array();
        if(isset($sent_reviewers) && is_array($sent_reviewers) && isset($all_reviewers) && is_array($all_reviewers)){
            foreach ($all_reviewers as $reviewer_id) {
                $sent=false;
                foreach ($sent_reviewers as $sent_reviewer_id){
                    if(strcmp($sent_reviewer_id, $reviewer_id)==0)
                            $sent=true;
                }
                
                if($sent==false){
                    $not_sent_reviewers[]=$reviewer_id;
                }
            }
            
        }
        
        return $not_sent_reviewers;
    }

    
    
    protected function findModel($id){
        if (($model = AmzSellerRequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}
