<?php


namespace backend\controllers;


use common\models\Order;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrderController extends Controller
{

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find(),
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $order = Order::findOne($id);

        if ($order === null) {
            throw new NotFoundHttpException('The requested order does not exist.');
        }

        return $this->render('view', [
            'model' => $order,
        ]);
    }


}