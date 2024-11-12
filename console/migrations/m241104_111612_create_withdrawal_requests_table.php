<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%withdrawal_requests}}`.
 */
class m241104_111612_create_withdrawal_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%withdrawal_requests}}', [
            'id' => $this->primaryKey(),
            'affiliate_user_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(10, 2),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp(),
        ]);

        $this->addForeignKey(
            'fk_withdrawal_affiliate',
            'withdrawal_requests',
            'affiliate_user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk_withdrawal_affiliate}}',
            '{{%withdrawal_requests}}'
        );
        $this->dropTable('{{%withdrawal_requests}}');
    }
}
