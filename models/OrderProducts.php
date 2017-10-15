<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class OrderProducts extends ActiveRecord
{
    public static function tableName()
    {
        return 'order_products';
    }


}
