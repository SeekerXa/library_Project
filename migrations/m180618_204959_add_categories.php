<?php

use yii\db\Migration;

/**
 * Class m180618_204959_add_categories
 */
class m180618_204959_add_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book_category', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-category_id', 'book_category', 'category_id');
        $this->createIndex('idx-book_id', 'book_category', 'book_id');

        $this->addForeignKey('fk-category_id','book_category','category_id','category','id','CASCADE');
        $this->addForeignKey('fk-book_id','book_category','book_id','books','id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180618_204959_add_categories cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180618_204959_add_categories cannot be reverted.\n";

        return false;
    }
    */
}
