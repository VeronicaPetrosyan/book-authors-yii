<?php


namespace frontend\models;


use common\models\Book;
use yii\base\Model;

class AddToCart extends Model
{
    public $bookId;
    public $quantity;

    public function rules()
    {
        return [
            ['bookId', 'required'],
            [['bookId'], 'exist', 'targetClass' => Book::class, 'targetAttribute' => 'id'],

            ['quantity', 'required'],
            ['quantity', 'integer', 'min' => 1]
        ];
    }

}