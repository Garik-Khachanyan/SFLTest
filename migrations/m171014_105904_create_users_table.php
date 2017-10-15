<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m171014_105904_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'userId'   => $this->primaryKey(),
            'userType' => $this->string(64),
            'userName' => $this->string(64)->unique(),
            'password' => $this->string(64)->notNull()
        ]);
        /**
         * USERNAME TestMAnager
         * PASSWORD 123456
         */
        $this->insert('users',['userType' => 'manager','userName' => 'TestManager','password' => 'e10adc3949ba59abbe56e057f20f883e']);


    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
