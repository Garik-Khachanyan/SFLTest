<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cafe_tables`.
 */
class m171014_124024_create_cafe_tables_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cafe_tables', [
            'tableId'       => $this->primaryKey(),
            'description'   => $this->string(64),
            'seats'         => $this->integer(11)->notNull(),
            'coordinate-x'  => $this->double(6),
            'coordinate-y'  => $this->double(6),
            'waiterId'      => $this->integer(11)
        ]);
        $this->addForeignKey('FK_cafe_tables_waiter', 'cafe_tables', 'waiterId', 'users', 'userId', 'SET NULL', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cafe_tables');
    }
}
