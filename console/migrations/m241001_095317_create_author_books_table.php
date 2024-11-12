<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author_books}}`.
 */
class m241001_095317_create_author_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author_books}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'author_id' => $this->integer(),
        ]);

         $this->addForeignKey('fk-book_id-books',
            'author_books',
            'book_id',
            'books',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey('fk-author_id-authors',
            'author_books',
            'author_id',
            'authors',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%author_books}}');
    }
}
