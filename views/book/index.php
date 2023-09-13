<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Książki');
$this->params['breadcrumbs'][] = $this->title;

$isAdmin = isset(Yii::$app->user->identity) ? Yii::$app->user->identity->isAdmin() : false;

?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Dodaj książkę'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            'ISBN',
            'amount',
            'author',
            //'page_count',
            $isAdmin ? ['class' => 'yii\grid\ActionColumn'] : [],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
