<?php

use yii\db\Migration;

/**
 * Class m241007_095201_add_referral_affiliate_to_orders_table
 */
class m241007_095201_add_referral_affiliate_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('orders', 'referral_affiliate_id', $this->integer());
        $this->addForeignKey(
            'fk_order_affiliate',
            'orders',
            'referral_affiliate_id',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_order_affiliate', 'orders');
        $this->dropColumn('orders', 'referral_affiliate_id');
    }

}
