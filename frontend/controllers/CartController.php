<?php


namespace frontend\controllers;


use common\models\Book;
use frontend\models\AddToCart;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;

class CartController extends Controller
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

public function actionAddToCart()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $bookId = Yii::$app->request->post('bookId');
    $quantity = Yii::$app->request->post('quantity', 1);

    if (Yii::$app->user->isGuest) {
        $cookieName = 'bookQuantities';
        $cookie = Yii::$app->request->cookies->getValue($cookieName, '[]');
        $bookQuantities = json_decode($cookie, true);

        if ($bookId && $quantity > 0) {
            if (!empty($bookQuantities[$bookId])) {
                $bookQuantities[$bookId] += $quantity;
            } else {
                $bookQuantities[$bookId] = $quantity;
            }

            $cookie = new \yii\web\Cookie([
                'name' => $cookieName,
                'value' => json_encode($bookQuantities),
            ]);
            Yii::$app->response->cookies->add($cookie);

            return ['success' => true];
        }

        return ['success' => false];
    } else {
        // For logged-in users, use cookies to store cart as well
        // In this case, we'll still use cookies for both scenarios, but with a logged-in user flag
        $cookieName = 'bookQuantities';
        $cookie = Yii::$app->request->cookies->getValue($cookieName, '[]');
        $bookQuantities = json_decode($cookie, true);

        // Add or update the book quantity in the cookie
        if ($bookId && $quantity > 0) {
            if (!empty($bookQuantities[$bookId])) {
                $bookQuantities[$bookId] += $quantity; // Update quantity if already exists
            } else {
                $bookQuantities[$bookId] = $quantity; // Add new book to cart
            }

            // Save the updated cart to the cookie
            $cookie = new \yii\web\Cookie([
                'name' => $cookieName,
                'value' => json_encode($bookQuantities),
            ]);
            Yii::$app->response->cookies->add($cookie);

            return ['success' => true]; // Return success response
        }

        return ['success' => false]; // Return failure if no book ID or invalid quantity
    }
}

    public function actionIndex()
    {
        $cookieName = 'bookQuantities';
        $cookie = Yii::$app->request->cookies->getValue($cookieName, '[]');
        $bookQuantities = json_decode($cookie, true);

        $cart = [];
        $totalPrice = 0;

        if (!empty($bookQuantities)) {
            foreach ($bookQuantities as $bookId => $quantity) {
                $book = Book::findOne($bookId);
                if ($book !== null) {
                    $cart[$bookId] = [
                        'book' => $book,
                        'quantity' => $quantity,
                    ];
                    $totalPrice += $book->price * $quantity;
                }
            }
        }

        return $this->render('index', ['cart' => $cart, 'totalPrice' => $totalPrice]);
    }


    public function actionRemoveFromCart($bookId)
    {
        $cookieName = 'bookQuantities';
        $cookie = Yii::$app->request->cookies->getValue($cookieName, '[]');
        $bookQuantities = json_decode($cookie, true);

        if (isset($bookQuantities[$bookId])) {
            unset($bookQuantities[$bookId]);

            $cookie = new Cookie([
                'name' => $cookieName,
                'value' => json_encode($bookQuantities),
            ]);
            Yii::$app->response->cookies->add($cookie);
            Yii::$app->session->setFlash('success', 'Book has been removed from cart.');
        }

        return $this->redirect(['index']);
    }

    public function actionClearCart()
    {
        $cookieName = 'bookQuantities';
        $cookie = new Cookie([
            'name' => $cookieName,
            'value' => '',
        ]);
        Yii::$app->response->cookies->add($cookie);
        Yii::$app->session->setFlash('success', 'Cart has been cleared.');
        return $this->redirect(['index']);
    }


}