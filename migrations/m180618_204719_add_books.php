<?php

use yii\db\Migration;

/**
 * Class m180618_204719_add_books
 */
class m180618_204719_add_books extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('books', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'ISBN' => $this->string(13)->notNull(),
            'amount' => $this->integer()->defaultValue(0),
            'author' => $this->string()->notNull(),
            'page_count' => $this->integer()->null(),
            'cover' => $this->string(500)->null(),
            'libary_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-book-libary_id',
            'books',
            'libary_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180618_204715_add_books cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180618_204715_add_books cannot be reverted.\n";

        return false;
    }
    */
}
