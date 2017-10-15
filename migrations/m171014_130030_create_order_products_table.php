<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_products`.
 */
class m171014_130030_create_order_products_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_products', [
            'id'        => $this->primaryKey(),
            'orderId'   => $this->integer(11),
            'productId' => $this->integer(11),
        ]);
        $this->addForeignKey('FK_order_products_order', 'order_products', 'orderId', 'orders', 'orderId', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_order_products_product', 'order_products', 'productId', 'products', 'productId', 'CASCADE', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_products');
    }
}
