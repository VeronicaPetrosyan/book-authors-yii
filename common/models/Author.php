<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property AuthorBook[] $authorBooks
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[AuthorBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorBooks()
    {
        return $this->hasMany(AuthorBook::class, ['author_id' => 'id']);
    }

    public static function getAllAuthors()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }
}
