<?php


namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $customer_id
 * @property Customer $customer
 */
class Order extends ActiveRecord
{
    public $user_id;
    public $name;
    public $surname;
    public $email;
    public $address;

    public static function tableName()
    {
        return 'orders';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'address'], 'string', 'max' => 255],
            [['name', 'surname', 'email', 'address'], 'filter', 'filter' => 'strip_tags'],
            [['name', 'surname', 'email', 'address'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            [['customer_id'], 'integer'],
            [['name', 'surname', 'email', 'address'], 'required', 'when' => function ($model) {
                return !$model->customer_id;
            }, 'whenClient' => "function(attribute, value){
                return !$('#existing-customer-dropdown').val();
            }"],

        ];
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }


}