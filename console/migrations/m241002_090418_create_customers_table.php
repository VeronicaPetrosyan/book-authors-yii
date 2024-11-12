<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customers}}`.
 */
class m241002_090418_create_customers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('{{%customers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
        ]);

        $this->addColumn('{{%customers}}', 'order_id', $this->integer()->after('id'));
        $this->addForeignKey(
            '{{%fk-customers-order_id}}',
            '{{%customers}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE');

        $this->addColumn('{{%customers}}', 'user_id', $this->integer()->after('order_id'));

        $this->addForeignKey(
            'fk-customers-user_id',
            '{{%customers}}',
            'user_id',
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
        $this->dropForeignKey(
            '{{%fk-customers-order_id}}',
            '{{%customers}}'
        );
        $this->dropForeignKey('fk-customers-user_id', '{{%customers}}');
        $this->dropTable('{{%customers}}');
    }
}
