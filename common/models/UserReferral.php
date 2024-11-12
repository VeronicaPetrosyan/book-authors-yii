<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_referrals".
 *
 * @property int $id
 * @property int|null $referrer_id
 * @property int|null $referred_by
 * @property string $created_at
 *
 * @property User $referredBy
 * @property User $referrer
 */
class UserReferral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_referrals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referrer_id', 'referred_by'], 'integer'],
            [['created_at'], 'safe'],
            [['referred_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['referred_by' => 'id']],
            [['referrer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['referrer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referrer_id' => 'Referrer ID',
            'referred_by' => 'Referred By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[ReferredBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReferredBy()
    {
        return $this->hasOne(User::class, ['id' => 'referred_by']);
    }

    /**
     * Gets query for [[Referrer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReferrer()
    {
        return $this->hasOne(User::class, ['id' => 'referrer_id']);
    }
}
