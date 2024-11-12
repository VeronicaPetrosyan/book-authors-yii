<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AffiliateUser $model */

$this->title = 'Create Affiliate User';
$this->params['breadcrumbs'][] = ['label' => 'Affiliate Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="affiliate-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
