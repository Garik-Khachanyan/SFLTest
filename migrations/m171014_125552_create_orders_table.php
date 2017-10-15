<?php

use yii\db\Migration;

/**
 * Handles the creation of table `orders`.
 */
class m171014_125552_create_orders_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('orders', [
            'orderId'      => $this->primaryKey(),
            'status'       => $this->string(64),
            'startTime'    => $this->time(),
            'deliveryTime' => $this->time(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('orders');
    }
}
