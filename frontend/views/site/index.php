<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>


<div class="row" style="display: flex; flex-direction: column">
    <?php if (Yii::$app->user->isGuest) { ?>
        <h5 style="padding-left: 15px"><a href="site/login">Login</a> to get a referral key.</h5>
        <?php
    } else { ?>
        <h4 style="padding-left: 15px">Referral Key: <?php echo Yii::$app->user->identity->referral_key ?></h4>
        <?php
    }
    ?>
    <div style="display: flex; flex-direction: row">
        <?php foreach ($books as $book): ?>
            <div class="col-md-4">
                <div class="book-item card">
                    <div class="card-body">
                        <h2 class="card-title"><?= Html::encode($book->name) ?></h2>
                        <p class="card-text">Price: <?= Html::encode($book->price) ?></p>
                        <div class="add-to-cart-form">
                            <label>
                                <input type="number" value="1" min="1" name="quantity" class="quantity-input">
                            </label>
                            <button class="add-to-cart-btn btn btn-primary" data-book-id="<?= $book->id ?>">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php
$addToCartUrl = Url::to(['cart/add-to-cart']);
$loginUrl = Url::to(['site/login']);

$js = <<<JS
$('.add-to-cart-btn').on('click', function(e) {
    e.preventDefault();
    var bookId = $(this).data('book-id');
    var quantity = $(this).closest('.add-to-cart-form').find('.quantity-input').val();
    
    $.ajax({
        url: '$addToCartUrl',
        type: 'POST',
        data: {
            bookId: bookId,
            quantity: quantity,
            _csrf: yii.getCsrfToken()
        },
        success: function(response) {
            if (response.success) {
                alert('Book added to cart successfully!');
            } else {
                alert('You need to login first!');
                window.location.href = '$loginUrl';
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error details: ", textStatus, errorThrown, jqXHR.responseText);
            alert('An error occurred. Please try again. Status: ' + textStatus);
        }
    });
});
JS;

$this->registerJs($js);
?>
