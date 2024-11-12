<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AffiliateUser $model */

$this->title = 'Update Affiliate User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Affiliate Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="affiliate-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
