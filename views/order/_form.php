<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Book;
use app\models\Order;


/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */


$now = date("Y-m-d");
$returnedDate = date('Y-m-d', strtotime("+7 day", strtotime($now)));
$book_id = isset($_GET['book_id']) ? $_GET['book_id'] : null;

$order = isset($_GET['id']) ? Order::findOne($_GET['id']) : new Order;
$edit = isset($_GET['id']);
$statusList = $book_id ? 1 : '';
$isAdmin = isset(Yii::$app->user->identity) ? Yii::$app->user->identity->isAdmin() : false;
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>
    <label class="control-label" for="book_id">Książka</label>
    <?= Html::activeDropDownList($order, 'book_id',
      ArrayHelper::map( $book_id ? Book::find()->where(['id' => $book_id])->all() : Book::find()->all(), 'id', 'title'),
      ['class' => 'form-control']) ?><br/>

    <label for="ordered_at">Zamówiona dnia</label>
    <input name="ordered_at" type="text" class="form-control" disabled="disabled" value="<?= $now ?>"><br/>

    <label for="return_to">Zwrot do</label>
    <input name="return_to" type="text" class="form-control" disabled="disabled" value="<?= $returnedDate ?>"><br/>

    <label for="order-status">Status</label>
    <select id="order-status" class="form-control" name="Order[status]" <?php if($book_id || !$isAdmin){ ?> disabled="disabled" <?php } ?>>
        <?php foreach($order->getStatusList($statusList) AS $k => $status){ ?>
        <option value="<?= $k ?>" <?php if($order->status == $k) {?>  selected="selected" <?php } ?> ?><?= $status ?> </option>
        <?php } ?>
    </select><br/>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Zamów'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
