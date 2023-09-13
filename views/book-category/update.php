<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BookCategory */

$this->title = 'Edytuj kategorie książki: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kategorie książki', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ecytuj';
?>
<div class="book-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
