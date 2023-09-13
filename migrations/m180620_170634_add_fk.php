<?php

use yii\db\Migration;

/**
 * Class m180620_170634_add_fk
 */
class m180620_170634_add_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx_category_id', 'book_category', 'category_id');
        $this->addForeignKey('fk-book-category-category-id','book_category','category_id','category','id','CASCADE');

        $this->createIndex('idx_book_id', 'book_category', 'book_id');
        $this->addForeignKey('fk-book-category-book-id','book_category','book_id','books','id','CASCADE');
        
        $this->createIndex('idx_user_permissions_user_id', 'user_permissions', 'user_id');
        $this->addForeignKey('fk-user-permissions-user-id','user_permissions','user_id','users','id','CASCADE');

        $this->createIndex('idx_user_permissions_permission_id', 'user_permissions', 'permission_id');
        $this->addForeignKey('fk-user-permissions-permission-id','user_permissions','permission_id','permissions','id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180620_170634_add_fk cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180620_170634_add_fk cannot be reverted.\n";

        return false;
    }
    */
}
