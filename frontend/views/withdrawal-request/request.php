<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WithdrawalRequest */

$this->title = 'Request Withdrawal';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="withdrawal-request-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
