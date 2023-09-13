<?php

use yii\helpers\Html;
use app\models\Author;
use app\models\Libary;
use app\models\Category;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ISBN')->textInput(['maxlength' => 13]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field(
        $model, 
        'category_ids')
      ->checkboxList(
          ArrayHelper::map(Category::find()->all(), 'id', 'name'),
          [
            'item' => function($index, $label, $name, $checked, $value) use ($model) {
                $checked = in_array($value, array_keys($model->category_ids)) ? 'checked' : '';
                return "<label class='checkbox col-md-4' style='font-weight: normal;'><input type='checkbox' {$checked} name='{$name}' value='{$value}'>{$label}</label>";
            }
          ]
        )->label('Kategoria') ?>
    
    <?= Html::activeDropDownList($model, 'libary_id',
      ArrayHelper::map(Libary::find()->all(), 'id', 'name'),
      ['class' => 'form-control']) ?><br/>

    <?= $form->field($model, 'page_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Zapisz'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
