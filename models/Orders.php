<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;

class Orders extends ActiveRecord
{
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * Check for Pending order in given Table
     * @param $tableId
     * @return bool
     */
    public static function checkExistingOrder($tableId)
    {
        $existingOrder = self::findAll(['tableId' => $tableId,'status' => 'pending']);
        if(!empty($existingOrder)){
            return false;
        }
        return true;
    }

    /**
     * Creates order with given product List
     * @param $tableId
     * @param $products
     * @return bool
     * @throws Exception
     */
    public static function createOrderWithProducts($tableId, $products)
    {
        if(!self::checkExistingOrder($tableId)){
            return false;
        }
        $transaction = self::getDb()->beginTransaction();
        try{

            $data = [
                'tableId' => $tableId,
                'status' => 'pending',
                'startTime' => date('H:i:s'),
                'deliveryTime'   =>  date('H:i:s',strtotime("+30 minutes"))
            ];
            $order = new Orders($data);
            $order->save();
            $orderId = $order->getAttribute('orderId');
            foreach($products as $key => $value){
                $toInsert = [
                    'orderId' => $orderId,
                    'productId' => $key
                ];
                $orderProduct = new OrderProducts($toInsert);
                $orderProduct->save();
            }
            $transaction->commit();
            return true;
        }catch (Exception $e){
            $transaction->rollback();
            return false;
        }
    }

}
