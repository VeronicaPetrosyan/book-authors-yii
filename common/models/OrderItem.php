<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_items".
 *
 * @property int $id
 * @property int $order_id
 * @property int $book_id
 * @property int $quantity
 * @property float $price
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'book_id', 'quantity', 'price'], 'required'],
            [['order_id', 'book_id', 'quantity'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'book_id' => 'Book ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
        ];
    }

    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

}
