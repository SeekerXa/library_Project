<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book_category".
 *
 * @property int $id
 * @property int $category_id
 * @property int $book_id
 *
 * @property Book $book
 * @property Category $category
 */
class BookCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */    public static function tableName()
    {
        return 'book_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'book_id'], 'required'],
            [['category_id', 'book_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function fields(){
        return ['id', 'book', 'book_id', 'category', 'category_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'book_id' => 'Book ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        $book = Book::findOne($this->book_id);
        if(empty($book))
            return null;

        return $book->title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        $category = Category::findOne($this->category_id);
        if(empty($category))
            return null;

        return $category->name;
    }
}
