<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * ContactForm is the model behind the contact form.
 */
class Book extends ActiveRecord
{
    public static $bookOffset = 9;

    public static function tableName() {
        return 'books';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['title', 'ISBN', 'author', 'libary_id'], 'required'],
            [['title', 'ISBN', 'amount', 'author', 'page_count', 'libary_id', 'category_ids'], 'safe'],
        ];
    }

    public function fields() {
        return ['id', 'title', 'ISBN', 'amount', 'author', 'page_count', 'category', 'category_ids'];
    }

    public function libary() : ?ActiveQuery
    {
        return $this->hasOne(Libary::className(), ['id' => 'libary_id']);
    }

    public function getAuthor(){
        $author = Author::find()->where(['id' => $this->author])->one();

        if(empty($author))
            return null;

        return $author->name;
    }

    public function getCategories(){
        return Category::find()
            ->innerJoin(BookCategory::tableName(), BookCategory::tableName().'.category_id = '.Category::tableName().'.id')
            ->innerJoin(Book::tableName(), Book::tableName().'.id = '.BookCategory::tableName().'.book_id')
            ->where([BookCategory::tableName().'.book_id' => $this->id])
            ->all();
    }

    public function getCategory_ids()
    {
        $categories = $this->getCategories();
        return !empty($categories) ? ArrayHelper::map($categories, 'id', 'name') : [];
    }

    public function setCategory_ids($categoryIds)
    {
        $categories = $this->getCategories();
        if (!empty($categories))
        {
            $categoryies = ArrayHelper::map($categories, 'id', 'name');

            $bookCategories = BookCategory::find()->where(['in', 'book_id', $this->id])
                ->andWhere(['in', 'category_id', array_keys($categoryies)])->all();

            if (!empty($bookCategories))
            {
                foreach ($bookCategories as $cat)
                {
                    $cat->delete();
                }
            }
        }

        if (!empty($categoryIds))
        {
            foreach ($categoryIds as $categoryId)
            {
                $bookCategory = new BookCategory();
                $bookCategory->category_id = $categoryId;
                $bookCategory->book_id = $this->id;
                $bookCategory->save();
            }
        }
    }

    public function getCategory(){
        $categories = $this->getCategories();

        $categoryNames = [];
        foreach($categories AS $category){
            $categoryNames[] = $category->name;
        }
        return implode(', ', $categoryNames);
    }

    public function getCategoryTags(){
        $categories = $this->getCategories();

        $categoryTags = [];
        foreach($categories AS $category){
            $categoryTags[] = '<a href="/index.php?cat_id='.$category->id.'">'.$category->name.'</a>';
        }
        return implode(', ', $categoryTags);
    }


    public function beforeSave($insert){
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) {
        return parent::afterSave($insert, $changedAttributes);
    }

    public function canOrder(){
        $can = 1;
        $can *= ($this->amount > 0 ? 1 : 0);
        $can *= !$this->isUserOrderingThisBook() ? 1 : 0;
        return $can;
    }

    public function isUserOrderingThisBook(){
        if(empty(\Yii::$app->user->identity))
            return false;

        return Order::find()->where(['user_id' => \Yii::$app->user->identity->id, 'book_id' => $this->id])
        ->andWhere(['<>', 'status', Order::STATUS_RETURNED])->count();
    }

    public static function show($page = 0, $search = false, $catId = null){
        $query = Book::find()
            ->limit(self::$bookOffset)
            ->offset(self::$bookOffset * $page)
            ->orderBy(['id' => SORT_DESC]);

        if ($search)
        {
            $query = $query->andWhere(['LIKE', 'title', $search]);
        }

        if ($catId)
        {
            $query = $query->innerJoin(BookCategory::tableName(), BookCategory::tableName().'.book_id = '.Book::tableName().'.id')
                ->andWhere([BookCategory::tableName().'.category_id' => $catId]);
        }
        
        return $query->all();
    }

    public static function removeOne($book_id){
        $book = Book::findOne($book_id);
        $book->amount = $book->amount - 1;
        return $book->save(); 
    }

    public static function addOne($book_id){
        $book = Book::findOne($book_id);
        $book->amount = $book->amount + 1;
        return $book->save();
    }

}
