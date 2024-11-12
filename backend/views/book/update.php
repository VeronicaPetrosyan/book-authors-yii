<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\book $model */

$this->title = 'Update Book: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
