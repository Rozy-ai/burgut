<?php
namespace common\rbac;

use common\models\AmzProduct;
use yii\rbac\Rule;
use yii\rbac\Item;

class ProductOwnerRule extends Rule
{
    public $name = 'isProductOwner';

    /**
     * @param string|integer $user   the user ID.
     * @param Item           $item   the role or permission that this rule is associated with
     * @param array          $params parameters passed to ManagerInterface::checkAccess().
     *
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $get=\Yii::$app->request->get();
        if(isset($get['id'])){
            $productModel=AmzProduct::find()->where(['id'=>$get['id']])->one();
            return isset($productModel) && isset($productModel->user_id) ? $productModel->user_id == $user : false;
        }
        return false;
    }


}