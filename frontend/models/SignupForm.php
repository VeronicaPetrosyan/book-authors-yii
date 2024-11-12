<?php

namespace frontend\models;

use common\models\UserReferral;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $referral_key;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['referral_key', 'string', 'max' => 255],
            ['referral_key', 'validateReferralCode'],
        ];
    }

    public function validateReferralCode($attribute, $params)
    {
        if (!empty($this->$attribute) && !User::findOne(['referral_key' => $this->$attribute])) {
            $this->addError($attribute, 'The referral key is invalid.');
        }
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->referral_key = User::generateReferralKey();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        if ($user->save()) {
            if (!empty($this->referral_key)) {
                $referrer = User::findOne(['referral_key' => $this->referral_key]);
                if ($referrer) {
                    $userReferral = new UserReferral();
                    $userReferral->referrer_id = $referrer->id;
                    $userReferral->referred_by = $user->id;
                    $userReferral->save();
                }
            }
            return $this->sendEmail($user);
        }
        return null;
    }


    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected
    function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
