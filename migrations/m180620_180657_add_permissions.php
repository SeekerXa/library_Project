<?php

use yii\db\Migration;
use app\models\Permission;

/**
 * Class m180620_180657_add_permissions
 */
class m180620_180657_add_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('permissions', ['permission' => Permission::ADMIN_PERMISSION]);
        $this->insert('permissions', ['permission' => Permission::LIBRARIAN_PERMISSION]);
        $this->insert('permissions', ['permission' => Permission::USER_PERMISSION]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180620_180657_add_permissions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180620_180657_add_permissions cannot be reverted.\n";

        return false;
    }
    */
}
