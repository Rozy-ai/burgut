<?php
namespace common\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord{

    //   public function behaviors()
    // {
    //     return [
    //         'image' => [
    //             'class' => 'rico\yii2images\behaviors\ImageBehave',
    //         ]
    //     ];
    // }

  public function addToCart($product, $qty = 1){
    $mainImg = $product->getThumbPath();
    if(isset($_SESSION['cart'][$product->id])){
      $_SESSION['cart'][$product->id]['qty'] += $qty;
    } else {
      $_SESSION['cart'][$product->id] = [
        'qty' => $qty,
        'name' =>$product->title,
        'price' => $product->Price,
        'img' => $mainImg,
      ];
    }
     $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ?  $_SESSION['cart.qty'] + $qty : $qty;
     $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ?  $_SESSION['cart.sum'] + $qty * $product->Price : $qty * $product->Price;
  }

  public function recalc($id)
  {
    if(!isset($_SESSION['cart'][$id])) return false;
    $qtyMinus = $_SESSION['cart'][$id]['qty'];
    $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
    $_SESSION['cart.qty'] -= $qtyMinus;
    $_SESSION['cart.sum'] -= $sumMinus;
    unset($_SESSION['cart'][$id]);
  }

}
