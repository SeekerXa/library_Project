<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $name
 *
 * @property BookCategory[] $bookCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function fields(){
        $allFields = ['id', 'name', 'count'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookCategories()
    {
        return $this->hasMany(BookCategory::className(), ['category_id' => 'id']);
    }

    public function getCount(){
        return BookCategory::find()->where(['category_id' => $this->id])->count();
    }
}
