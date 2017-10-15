<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Products extends ActiveRecord
{
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAllProducts()
    {
        return self::find()->all();
    }

}
