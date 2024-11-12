<?php


use common\models\Order;
use yii\widgets\DetailView;

/* @var Order $model */

$this->title = 'Order Details';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'label' => 'Customer Name',
            'value' => function ($model) {
                return $model->customer->name . ' ' . $model->customer->surname;
            },
        ],
        'created_at:datetime',
        [
            'label' => 'Product Details',
            'value' => function ($model) {
                $details = '';
                $totalPrice = 0;
                foreach ($model->orderItems as $orderItem) {
                    $details .= '<strong>Book Name: </strong>' . $orderItem->book->name . '<br>';
                    $details .= '<strong>Quantity</strong>: ' . $orderItem->quantity . '<br>';
                    $details .= '<strong>Price</strong>: ' . '$' . $orderItem->price . '<br>';
                    $totalPrice += $orderItem->price;
                    $details .= '<br>';
                }
                $details .= '<strong>Total Price</strong>: ' . '$' . $totalPrice . '<br>';
                return $details;
            },
            'format' => 'html',
        ],
        [
            'label' => 'Customer Address',
            'value' => function ($model) {
                return $model->customer->getCustomerAddress($model->customer_id);
            },
            'format' => 'raw',
        ],
    ],


]) ?>
