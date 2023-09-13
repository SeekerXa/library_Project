<?php

use yii\db\Migration;

/**
 * Class m180619_150259_add_user_table
 */
class m180619_150259_add_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string(250)->notNull(),
            'password' => $this->string(250)->notNull(),
            'accessToken' => $this->string(250),
            'authKey' => $this->string(100),
            'libary_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-user-libary_id',
            'users',
            'libary_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180619_150258_add_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180619_150258_add_user_table cannot be reverted.\n";

        return false;
    }
    */
}
