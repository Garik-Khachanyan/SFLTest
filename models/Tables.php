<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Tables extends ActiveRecord
{
    public static function tableName()
    {
        return 'cafe_tables';
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAllTables()
    {
       return self::find()->all();
    }

}
