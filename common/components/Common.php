<?php
namespace common\components;
use yii\base\Component;
use Yii;

class Common extends Component{

    public function sendMail($subject, $body, $to="manager@gyzylpeykam.com"){
        $body=  preg_replace("/&(?!(?:apos|quot|[gl]t|amp);|#)/",'&amp;',$body);
        $mailer = Yii::$app->mailer;
        $mailer->viewPath = '@common/mail';
        $mailer->getView()->theme = Yii::$app->view->theme;
        $sender = isset(Yii::$app->params['adminEmail']) ? Yii::$app->params['adminEmail']: 'info@gyzylpeykam.com';

		
        return $mailer->compose()
            ->setTo($to)
            ->setFrom($sender)
            ->setSubject($subject)
            ->setTextBody($body)
//            ->setHtmlBody('<b>HTML content</b>')
            ->send();
    }
    


    
    public function sendHtmlMessage($to, $subject, $view, $params = []){
        /** @var \yii\mail\BaseMailer $mailer */
        $mailer = Yii::$app->mailer;
        $mailer->viewPath = '@common/mail';
        $mailer->getView()->theme = Yii::$app->view->theme;
        $sender = isset(Yii::$app->params['adminEmail']) ? Yii::$app->params['adminEmail']: 'informer@conqueramazon.com';

        return $mailer->compose(['html' => $view], $params)
            ->setTo($to)
            ->setFrom($sender)
            ->setSubject($subject)
            ->send();
    }
    
    
    
    public function getcurl($url,$postfileds="") {
        
        $proxies = array();
        $proxies[] = 'lmorai:DvYPjJwq@172.241.142.13:29842';  // Some proxies require user, password, IP and port number
        $proxies[] = 'lmorai:DvYPjJwq@172.241.142.47:29842';  
        $proxies[] = 'lmorai:DvYPjJwq@23.80.156.153:29842';  
        $proxies[] = 'lmorai:DvYPjJwq@23.80.156.160:29842';  
        $proxies[] = 'lmorai:DvYPjJwq@23.80.156.195:29842';  
//        $proxies[] = '173.234.93.94';
//        $proxies[] = '173.234.94.90:54253'; // Some proxies require IP and port number
        
        
        if (isset($proxies)) {  
            $proxy = $proxies[array_rand($proxies)];  
        }
        
        
    	$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
    	$ch = curl_init();
        
        if (isset($proxy)) {    // If the $proxy variable is set, then
            curl_setopt($ch, CURLOPT_PROXY, $proxy);    // Set CURLOPT_PROXY with proxy in $proxy variable
        }
    	curl_setopt($ch, CURLOPT_URL,$url);
    	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// Setting cURL's option to return the webpage data
    	if($postfileds!=""){
    		curl_setopt($ch, CURLOPT_POST, 1);
    		curl_setopt($ch, CURLOPT_POSTFIELDS,$postfileds);
    	}
    	$data = curl_exec($ch);	// Executing the cURL request and assigning the returned data to the $data variable
    	curl_close($ch);	// Closing cURL
    	return $data;	// Returning the data from the function
    }








    public function getDomXPath($url){
        $link_result = Yii::$app->common->getcurl($url);
        $docDetail = new \DomDocument();
        libxml_use_internal_errors(true);
        $docDetail->loadHTML($link_result);
        $xpathDetail = new \DOMXPath($docDetail);
        return $xpathDetail;
    }







    
//    public function sendMail($subject, $text, $emailFrom="batya224@mail.ru", $nameFrom='conquerAmazon Test'){
//        $text=  preg_replace("/&(?!(?:apos|quot|[gl]t|amp);|#)/",'&amp;',$text);
//        
//        if(\Yii::$app->mail->compose()
//            ->setFrom(['batyr@hmlbc.com' => 'ConquerAmazon'])
//            ->setTo([$emailFrom => $nameFrom])
//            ->setSubject($subject)
//            ->setTextBody($text)
//            ->send()){
//                return true;
//            };
//    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

