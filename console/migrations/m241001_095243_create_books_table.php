<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m241001_095243_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'price' => $this->decimal(10,2)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
