<?php

namespace frontend\controllers;

use common\components\CommonController;
use Yii;
use common\models\Cart;
use common\models\wrappers\ItemWrapper;
use common\models\Order;
use common\models\OrderItems;


class CartController extends CommonController
{
    public function actionAdd()
    {
      $id = Yii::$app->request->get('id');
      $qty = (int)Yii::$app->request->get('qty');
      $qty = !$qty || $qty < 0 ? 1 : $qty;
      $product = ItemWrapper::findOne($id);
      if(empty($product)) return false;
      $session = Yii::$app->session;
      $session->open();
      $cart = new Cart();
      $cart->addToCart($product, $qty);
      if(!Yii::$app->request->isAjax){
        return $this->redirect(Yii::$app->request->referrer);
      }
      $this->layout = false;
      return $this->render('cart-modal', compact('session'));
      
    }

    public function actionClear()
    {
      $session = Yii::$app->session;
      $session->open();
      $session->remove('cart');
      $session->remove('cart.qty');
      $session->remove('cart.sum');
      $this->layout = false;
      return $this->render('cart-modal', compact('session')); 
    }

    public function actionDelItem()
    {
      $id = Yii::$app->request->get('id');
      $session = Yii::$app->session;
      $session->open();
      $cart = new Cart();
      $cart->recalc($id);
      $this->layout = false;
      return $this->render('cart-modal', compact('session')); 
    }

    public function actionShow()
    {
      $session = Yii::$app->session;
      $session->open();
      $this->layout = false;
      return $this->render('cart-modal', compact('session'));
      
    }

    public function actionView()
    {
      $session = Yii::$app->session;
      $session->open();
      $this->setMeta('Sebet');
      $order = new Order();
      if($order->load(Yii::$app->request->post())){
        $order->qty = $session['cart.qty'];
        $order->sum = $session['cart.sum'];
        if($order->save()){
          $this->saveOrderItems($session['cart'], $order->id);
          Yii::$app->session->setFlash('success','Zakaz kabul edildi!');
          Yii::$app->mailer->compose('order' , ['session' => $session])
          ->setFrom(['rozy.jumayew@mail.ru' => 'Rozy'])
          ->setTo($order->email)
          ->setSubject('Тема сообщения')
          ->send();
          Yii::$app->mailer->compose('order' , ['session' => $session])
          ->setFrom(['rozy.jumayew@mail.ru' => 'Rozy'])
          ->setTo('jumayewrozy@gmail.com')
          ->setSubject('Тема сообщения')
          ->send();
          $session->remove('cart');
          $session->remove('cart.qty');
          $session->remove('cart.sum');
          return $this->refresh();
        } else{
          Yii::$app->session->setFlash('error','Zakaz kabul edilmedi!');
        }
      }
        // debug($session['cart.sum']);
      // $this->layout = false;
      return $this->render('view', compact('session','order'));
    }

    protected function saveOrderItems($items, $order_id){
      foreach ($items as $id => $item)  {
        $order_items = new OrderItems();
        $order_items->order_id = $order_id;
        $order_items->product_id = $id;
        $order_items->name = $item['name'];
        $order_items->price = $item['price'];
        $order_items->qty_item = $item['qty'];
        $order_items->sum_item = $item['qty'] * $item['price'];
        $order_items->save();
      }
    }

    protected function setMeta($title = null, $keywords = null, $descriptions = null){
  $this->view->title = $title;
  $this->view->registerMetaTag(['name' => 'keywords', 'content' => "$keywords"]);
  $this->view->registerMetaTag(['name' => 'description', 'content' => "$descriptions"]);
  }


}
