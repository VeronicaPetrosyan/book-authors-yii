<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $price
 *
 * @property AuthorBook[] $authorBooks
 */
class Book extends \yii\db\ActiveRecord
{
    public $authorIds = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['price'], 'required'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
            ['authorIds', 'required'],
            ['authorIds', 'each', 'rule' => ['exist', 'targetClass' => Author::class, 'targetAttribute' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[AuthorBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorBooks()
    {
        return $this->hasMany(AuthorBook::class, ['book_id' => 'id']);
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->via('authorBooks');
    }

    public function saveOrUpdateAuthorIds()
    {
        AuthorBook::deleteAll(['book_id' => $this->id]);
        foreach ($this->authorIds as $authorId) {
            $authorBook = new AuthorBook();
            $authorBook->book_id = $this->id;
            $authorBook->author_id = $authorId;
            $authorBook->save();
        }
        return true;
    }
}
