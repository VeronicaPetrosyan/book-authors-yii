<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_items}}`.
 */
class m241002_085737_create_order_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-orders_items-order_id}}',
            '{{%orders_items}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-orders_items-book_id}}',
            '{{%orders_items}}',
            'book_id',
            '{{%books}}',
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
            '{{%fk-orders_items-order_id}}',
            '{{%orders_items}}'
        );

        $this->dropForeignKey(
            '{{%fk-orders_items-book_id}}',
            '{{%orders_items}}'
        );
        $this->dropTable('{{%order_items}}');
    }
}
