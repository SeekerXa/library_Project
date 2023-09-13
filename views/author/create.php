<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Author */

$this->title = Yii::t('app', 'Dodaj autora');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Autorzy'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
