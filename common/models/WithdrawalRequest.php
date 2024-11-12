<?php

namespace common\models;

use Yii;

const STATUS_PENDING = 0;
const STATUS_ACTIVE = 1;
const STATUS_REJECTED = 2;

/**
 * This is the model class for table "withdrawal_requests".
 *
 * @property int $id
 * @property int $affiliate_user_id
 * @property float|null $amount
 * @property string|null $status
 * @property string $created_at

 */
class WithdrawalRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'withdrawal_requests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['affiliate_user_id'], 'integer'],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
            [['status'], 'string', 'max' => 255],
            [['affiliate_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['affiliate_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'affiliate_user_id' => 'Affiliate User ID',
            'amount' => 'Amount',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[AffiliateUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAffiliateUser()
    {
        return $this->hasOne(User::class, ['id' => 'affiliate_user_id']);
    }

    public static function getStatusNames()
    {
        return [
            STATUS_PENDING => 'Pending',
            STATUS_ACTIVE => 'Active',
            STATUS_REJECTED => 'Rejected',
        ];
    }
}
