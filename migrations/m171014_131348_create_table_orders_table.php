<?php

use yii\db\Migration;

/**
 * Handles the creation of table `table_orders`.
 */
class m171014_131348_create_table_orders_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('table_orders', [
            'id'        => $this->primaryKey(),
            'tableId'   => $this->integer(11),
            'orderId'   => $this->integer(11),
            'orderDate' => $this->dateTime()
        ]);
        $this->addForeignKey('FK_table_orders_tableId', 'table_orders', 'tableId', 'cafe_tables', 'tableId', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_table_orders_orderId', 'table_orders', 'orderId', 'orders', 'orderId', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('table_orders');
    }
}
