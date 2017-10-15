<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products`.
 */
class m171014_125814_create_products_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('products', [
            'productId'    => $this->primaryKey(),
            'name'         => $this->string(64),
            'description'  => $this->string(255),
            'price'        => $this->integer(11),
            'cookingTime'  => $this->integer(11),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('products');
    }
}
