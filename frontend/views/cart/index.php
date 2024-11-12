<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $cart array */

$this->title = 'Cart';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-cart">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (empty($cart)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Book Name</th>
                    <th>Quantity</th>
                    <th>Price per Book</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $bookId => $item): ?>
                    <tr>
                        <td><?= Html::encode($item['book']->name) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= $item['book']->price ?></td>
                        <td>$<?= $item['book']->price * $item['quantity'] ?></td>
                        <td>
                            <?= Html::a('Remove', ['cart/remove-from-cart', 'bookId' => $bookId], ['class' => 'btn btn-danger']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-price">
            <h4>Total Price: $<?= $totalPrice ?></h4>
        </div>

        <div class="cart-actions">
            <?= Html::a('Clear Cart', ['cart/clear-cart'], ['class' => 'btn btn-danger']) ?>
            <?= Html::a('Order', ['order/make-order'], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>
</div>



