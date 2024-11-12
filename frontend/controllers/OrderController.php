<?php


namespace frontend\controllers;

use common\models\User;
use common\models\UserReferral;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Cookie;
use common\models\Book;
use common\models\Customer;
use common\models\Order;
use common\models\OrderItem;


class OrderController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionMakeOrder()
    {
        $userId = Yii::$app->user->id;
        $order = new Order();

        if ($order->load(Yii::$app->request->post()) && $order->validate()) {
            if ($order->customer_id) {
                $customer = Customer::findOne(['id' => $order->customer_id]);
                if (!$customer) {
                    Yii::$app->session->setFlash('error', 'Invalid customer selection.');
                    return $this->redirect(['/order/index']);
                }
            } else {
                $customer = new Customer();
                $customer->name = $order->name;
                $customer->surname = $order->surname;
                $customer->email = $order->email;
                $customer->address = $order->address;
                $customer->user_id = $userId;
                $customer->order_id = $order->id;
                $customer->save();
            }

            $order->customer_id = $customer->id;
            $order->user_id = $userId;
            $order->save();

            $customer->order_id=$order->id;
            $customer->save();

            $cookieName = 'bookQuantities';
            $cookie = Yii::$app->request->cookies->getValue($cookieName, '[]');
            $bookQuantities = json_decode($cookie, true);
            $totalAmount = 0;

            if (!empty($bookQuantities)) {
                foreach ($bookQuantities as $bookId => $quantity) {
                    $book = Book::findOne($bookId);
                    if ($book) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id;
                        $orderItem->book_id = $book->id;
                        $orderItem->quantity = $quantity;
                        $orderItem->price = $book->price * $quantity;
                        $orderItem->save();

                        $totalAmount += $orderItem->price;
                    }
                }
            }

            $referralRecord = UserReferral::findOne(['referred_by' => $userId]);
            if ($referralRecord) {
                $referrer = User::findOne($referralRecord->referrer_id);
                if ($referrer) {
                    $order->referral_affiliate_id = $referrer->id;

                    $commission = $totalAmount * 0.1;

                    $referrer->balance += $commission;
                    $referrer->save();

                    $order->save();
                }
            }

            $cookie = new Cookie([
                'name' => $cookieName,
                'value' => '',
            ]);
            Yii::$app->response->cookies->add($cookie);

            Yii::$app->session->setFlash('success', 'Order placed successfully.');
            return $this->redirect(['/site/index']);
        }

        $existingCustomers = Customer::find()->where(['user_id' => $userId])->all();
        $existingCustomersInfo = [];
        foreach ($existingCustomers as $existingCustomer) {
            $existingCustomersInfo[$existingCustomer->id] = "{$existingCustomer->name} {$existingCustomer->surname} - {$existingCustomer->address} ({$existingCustomer->email})";
        }

        return $this->render('index', compact('order', 'existingCustomersInfo', 'order'));
    }

}