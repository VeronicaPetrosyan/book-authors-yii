<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Author $model */

$this->title = 'Create Author';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
