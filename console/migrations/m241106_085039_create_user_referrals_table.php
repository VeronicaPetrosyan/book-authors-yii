<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_referrals}}`.
 */
class m241106_085039_create_user_referrals_table extends Migration
{
     /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_referrals}}', [
            'id' => $this->primaryKey(),
            'referrer_id' => $this->integer(),
            'referred_by' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-user_referrals-referrer_id',
            '{{%user_referrals}}',
            'referrer_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_referrals-referred_by',
            '{{%user_referrals}}',
            'referred_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_referrals-referrer_id', '{{%user_referrals}}');
        $this->dropForeignKey('fk-user_referrals-referred_by', '{{%user_referrals}}');

        $this->dropTable('{{%user_referrals}}');
    }
}
