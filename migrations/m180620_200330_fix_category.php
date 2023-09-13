<?php

use yii\db\Migration;

/**
 * Class m180620_200330_fix_category
 */
class m180620_200330_fix_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('category', 'name', $this->string(200)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180620_200330_fix_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180620_200330_fix_category cannot be reverted.\n";

        return false;
    }
    */
}
