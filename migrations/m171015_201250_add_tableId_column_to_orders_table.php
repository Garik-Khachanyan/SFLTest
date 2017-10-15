<?php

use yii\db\Migration;

/**
 * Handles adding tableId to table `orders`.
 */
class m171015_201250_add_tableId_column_to_orders_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('orders', 'tableId', $this->integer(11));
        $this->addForeignKey('FK_orders_tableId', 'orders', 'tableId', 'cafe_tables', 'tableId', 'CASCADE', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('orders', 'tableId');
    }
}
