<?php

use yii\db\Migration;

/**
 * Class m241007_085555_add_referral_fields_to_users_table
 */
class m241007_085555_add_referral_fields_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'referral_key', $this->string()->unique()->notNull());
        $this->addColumn('user', 'balance', $this->decimal(10, 2)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'referral_key');
        $this->dropColumn('user', 'balance');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241007_085555_add_referral_fields_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
