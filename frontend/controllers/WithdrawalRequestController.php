<?php


namespace frontend\controllers;


use common\models\User;
use common\models\WithdrawalRequest;
use Yii;
use yii\web\Controller;

class WithdrawalRequestController extends Controller
{
    public function actionRequestWithdrawal()
    {
        $model = new WithdrawalRequest();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $userId = Yii::$app->user->id;

            $user = User::findOne($userId);
            if ($user->balance >= $model->amount) {
                $withdrawal = new WithdrawalRequest();
                $withdrawal->affiliate_user_id = $userId;
                $withdrawal->amount = $model->amount;
                $withdrawal->save();

                $user->balance -= $model->amount;
                $user->save();

                Yii::$app->session->setFlash('success', 'Withdrawal request submitted successfully.');
                return $this->redirect(['request-withdrawal']);
            } else {
                Yii::$app->session->setFlash('error', 'Insufficient balance for this withdrawal.');
            }
        }

        return $this->render('request', [
            'model' => $model
        ]);
    }
}