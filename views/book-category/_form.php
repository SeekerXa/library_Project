<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;
use app\models\Book;

/* @var $this yii\web\View */
/* @var $model app\models\BookCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <label class="control-label" for="book_id">Książka</label>
    <?= Html::activeDropDownList($model, 'book_id',
      ArrayHelper::map(Book::find()->all(), 'id', 'title'),
      ['class' => 'form-control']) ?><br/>

    <label class="control-label" for="category_id">Kategoria</label>
  	<?= Html::activeDropDownList($model, 'category_id',
      ArrayHelper::map(Category::find()->all(), 'id', 'name'),
      ['class' => 'form-control']) ?><br/>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
