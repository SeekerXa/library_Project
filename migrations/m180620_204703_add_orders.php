<?php

use yii\db\Migration;

/**
 * Class m180620_204703_add_orders
 */
class m180620_204703_add_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'book_id' => $this->integer(11)->notNull(),
            'ordered_at' => $this->dateTime(),
            'return_to' => $this->dateTime()->notNull(),
            'status' => $this->integer(1)->defaultValue(0)
        ]);

        $this->createIndex('idx_user_id', 'orders', 'user_id');
        $this->addForeignKey('fk-order-user_id', 'orders', 'user_id', 'users', 'id', 'CASCADE');

        $this->createIndex('idx_book_id', 'orders', 'book_id');
        $this->addForeignKey('fk-order-book_id', 'orders', 'book_id', 'books', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180620_204702_add_orders cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180620_204702_add_orders cannot be reverted.\n";

        return false;
    }
    */
}
