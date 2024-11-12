<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Order Processing';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($order, 'customer_id')->dropdownList($existingCustomersInfo, ['prompt' => 'Select an option', 'id' => 'existing-customer-dropdown']) ?>

    <div class="form-group" id="new-customer-fields" style="display: none;">
        <?= $form->field($order, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($order, 'surname')->textInput(['maxlength' => true]) ?>
        <?= $form->field($order, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($order, 'address')->textInput(['maxlength' => true]) ?>
    </div>

    <?= Html::button('Create New Customer', ['class' => 'btn btn-success', 'id' => 'create-new-customer-btn']) ?>

    <div class="form-group">
        <?= Html::submitButton('Process Order', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS
    document.getElementById('create-new-customer-btn').addEventListener('click', function() {
        document.getElementById('new-customer-fields').style.display = 'block';
        document.getElementById('existing-customer-dropdown').value = '';
        this.style.display = 'none';
    });
JS;

$this->registerJs($script);
?>

