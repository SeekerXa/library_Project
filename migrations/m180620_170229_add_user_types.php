<?php

use yii\db\Migration;

/**
 * Class m180620_170229_add_user_types
 */
class m180620_170229_add_user_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_permissions', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'permission_id' => $this->integer(11)->notNull(),
        ]);

        $this->createTable('permissions', [
            'id' => $this->primaryKey(),
            'permission' => $this->string(100)->notNull(),
        ]);

        $this->createIndex('idx_user_id', 'user_permissions', 'user_id');
        $this->createIndex('idx_permission_id', 'user_permissions', 'permission_id');
        $this->createIndex('idx_permissions', 'permissions', 'permission');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180620_170228_add_user_types cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180620_170228_add_user_types cannot be reverted.\n";

        return false;
    }
    */
}
