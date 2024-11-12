<?php

use common\models\Order;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$dataProvider = new ActiveDataProvider([
    'query' => Order::find()->orderBy(['created_at' => SORT_DESC]),
    'pagination' => [
        'pageSize' => 6,
    ],
]);

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'label' => 'Customer Name',
            'value' => function ($model) {
                return $model->customer->name . ' ' . $model->customer->surname;

            },
        ],
        'created_at:datetime',
        [
            'label' => 'Total Price',
            'value' => function ($model) {
                $totalPrice = 0;
                foreach ($model->orderItems as $orderItem) {
                    $totalPrice += $orderItem->price;
                }
                return '$' . $totalPrice;
            }
        ],
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('View',
                        ['/order/view', 'id' => $model->id],
                        ['class' => 'btn btn-primary']);
                },
            ],
        ],
    ],
]); ?>

<div class="pagination-container">
    <ul class="pagination justify-content-center">
        <?php
        $pagination = $dataProvider->pagination;
        $currentPage = $pagination->getPage();
        $pageCount = $pagination->getPageCount();

        ?>
    </ul>
</div>


