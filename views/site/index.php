<?php

/* @var $this yii\web\View */
use app\models\Book;
use app\models\Order;
use app\models\Category;
use yii\helpers\Url;

$this->title = 'Biblioteka';
$bestOrders = Order::getBestOrdered();
$categories = Category::find()->all();

$page = (isset($_GET['page']) ? intval($_GET['page']) : 0);

$search = (isset($_GET['search']) ? $_GET['search'] : false);
$catId = (isset($_GET['cat_id']) ? $_GET['cat_id'] : false);

$books = Book::show($page, $search, $catId);
?>
<div class="site-index">

    <!-- <div class="jumbotron">
        <h1>Witamy na stronie biblioteki!</h1>
    </div> -->

    <div class="body-content">

        <div class="row">
            <div class="col-xs-12">
                <form class="pull-right" action="?r=site&search">
                    <label for="search">Wyszukaj książkę</label>
                    <input type="search" name="search">
                    <input type="submit" value="Szukaj">
                    <input type="reset">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2>Nowości</h2>

                <div class="col-xs-12">
                    <?php foreach ($books AS $book){ ?>
                        <?php $libary = $book->libary()->one(); ?>
                        <div class="book-container">
                            <div class="book-short-desc">
                                <b>Tytuł</b>: <?php echo $book->title ?><br/>
                                <b>Kategorie</b>: <?php echo $book->categoryTags ?><br/>
                                <b>ISBN</b> <?php echo $book->ISBN ?><br/>
                                <b>Ilość</b> <?php echo $book->amount ?><br/>
                                <b>Nazwa biblioteki</b> 
                                    <span data-toggle="tooltip" data-placement="bottom" title="<?php 
                                        echo $libary->post_code . ' ' . $libary->city . ', ' . $libary->street . ' ' . $libary->number;
                                    ?>" style="cursor:help">
                                        <?php echo $libary->name ?>
                                    </span>
                                <br/>
                                <a href="<?php echo Url::to(['book/view', 'id' => $book->id])?>" class="btn btn-xs btn-info">Przejdź</a>
                            </div>
                        </div>
                    <hr>
                    <?php } ?>

                </div>

                <div class="col-xs-12">
                    <?php if($page > 0){ ?>
                        <a href="index.php?page=<?= $page-1 ?>" class="btn btn-sm btn-default pull-left">Poprzednie</a> 
                    <?php } ?>

                    <?php if(count($books) >= Book::$bookOffset){ ?>
                        <a href="index.php?page=<?= $page+1 ?>" class="btn btn-sm btn-default pull-right">Kolejne</a>
                    <?php } ?>
                </div>
                
            </div>
        </div>

       <!--  <div class="row">
            <div class="col-xs-12">
                <h2>Nowości</h2>

                <div class="col-xs-12">
                    <?php foreach($books AS $book){ ?>
                    <div class="book-container">
                        <div class="book-short-desc">
                            <b><?php echo $book->title ?></b><br/>
                            <?php echo substr($book->ISBN, 0, 150) . '...' ?>
                            <a href="<?php echo Url::to(['book/view', 'id' => $book->id])?>">zobacz więcej</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2>Najczęściej wypożyczane</h2>
                <?php foreach($bestOrders AS $bestOrder){ ?>
                    <div class="book-container">
                        <div class="book-short-desc">
                            <b><?php echo $bestOrder->title ?></b><br/>
                            <?php echo substr($bestOrder->ISBN,0,150).'...' ?>
                            <a href="<?php echo Url::to(['book/view', 'id' => $bestOrder->id])?>">zobacz więcej</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <h2>Kategorie</h2>
                <?php foreach($categories AS $category){ ?>
                    <div class="book-container">
                        <div class="book-short-desc">
                            <b><?php echo $category->name.' ('.$category->count.')' ?></b><br/>
                            <a href="<?php echo Url::to(['category/view', 'id' => $category->id])?>">zobacz więcej</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div> -->

    </div>
</div>
