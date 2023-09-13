<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Zamówienia');
$this->params['breadcrumbs'][] = $this->title;
$user = \Yii::$app->user->identity;
$canEdit = isset($user) && (!$user->isUser());
if ($user && !$canEdit)
    $dataProvider->query = $dataProvider->query->andWhere(['user_id' => Yii::$app->user->identity->id]);

$isUser = isset(Yii::$app->user->identity);

?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php if($isUser){ ?>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                // 'user_id',
                'user',
                // 'book_id',
                'book',
                'ordered_at',
                'return_to',
                // 'status',
                'status_msg',

                $canEdit ? ['class' => 'yii\grid\ActionColumn'] : [],
        ]]); ?>
    <?php } else { ?>
        Tylko zalogowani użytkownicy mają dostęp do zamówień
    <?php } ?>
    <?php Pjax::end(); ?>
</div>
