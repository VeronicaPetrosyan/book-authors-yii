<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $user_id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $address
 *
 * @property Order $order
 * @property User $user
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id'], 'integer'],
            [['name', 'surname', 'email', 'address'], 'required'],
            [['name', 'surname', 'email', 'address'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'Email',
            'address' => 'Address',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getCustomerAddress($customerId)
    {
        $customer = self::findOne(['id' => $customerId]);
        if ($customer) {
            return $customer->address;
        }
        return null;
    }

}
