<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\models\Book;


/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$isAdmin = isset(Yii::$app->user->identity) ? Yii::$app->user->identity->isAdmin() : false;

$book = Book::findOne($_GET['id']);
$canOrder = $book->canOrder();
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'author',
            'ISBN',
            // 'author',
            'category',
            'page_count',
            'amount',
        ],
    ]) ?>

    <p>
        <?php if($isAdmin) echo Html::a(Yii::t('app', 'Edytuj'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if($isAdmin) echo Html::a(Yii::t('app', 'Usuń'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Czy na pewno chcesz usunąć?'),
                'method' => 'post',
            ],
        ]) ?>
     
        <?php if(Yii::$app->user->identity){ ?>
          
            <a href="<?= $canOrder ? Url::to(['order/create', 'book_id' => $model->id]) : '#' ?>" class="btn btn-success" 
                <?php if(!$canOrder){ ?> disabled="disabled"<?php }?>  >Wypożycz</a>
               
       <?php } else { ?>

            Tylko zalogowani użytkownicy mogą wypożyczać książki

       <?php } ?>
    </p>

    

</div>
