<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property string $ordered_at
 * @property string $return_to
 * @property int $status
 *
 * @property Book $book
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{

    const STATUS_ORDERED = 0;  //zamówiona książka, czeka na odebranie
    const STATUS_RECEIVED = 1; //książka odebrana przez czytelnika
    const STATUS_RETURNED = 2; //książka zwrócona do biblioteki

    public $newRecord = false;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id'], 'required'],
            [['user_id', 'book_id', 'status'], 'integer'],
            [['ordered_at', 'return_to'], 'safe'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function fields(){
        return ['id', 'user_id', 'user', 'book_id', 'book', 'return_to', 'status', 'status_msg', 'ordered_at'];
    }

    public function getStatus_msg(){
        switch($this->status){
            case self::STATUS_ORDERED:
                return $this->getStatusList(self::STATUS_ORDERED)[0];
                break;

            case self::STATUS_RECEIVED:
                return $this->getStatusList(self::STATUS_RECEIVED)[0];
                break;

            case self::STATUS_RETURNED:
                return $this->getStatusList(self::STATUS_RETURNED)[0];
                break;
        }
    }

    public function getStatusList($status_id = false){
        $status[self::STATUS_ORDERED] = 'Oczekuje na odbiór';
        $status[self::STATUS_RECEIVED] = 'Wypożyczona';
        $status[self::STATUS_RETURNED] = 'Zwrócona do bilioteki';

        if($status_id)
            return [$status[$status_id]];
        else
            return $status;
    }

    public function getBook(){
        $book = Book::find()->where(['id' => $this->book_id])->one();

        if(empty($book))
            return null;

        return $book->title;
    }

    public function getUser(){
        $user = User::find()->where(['id' => $this->user_id])->one();

        if(empty($user))
            return null;

        return $user->username;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'book_id' => Yii::t('app', 'Book ID'),
            'ordered_at' => Yii::t('app', 'Ordered At'),
            'return_to' => Yii::t('app', 'Return To'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public static function getBestOrdered(){
        return Book::find()
        ->innerJoin(Order::tableName(), Order::tableName().'.book_id = '.Book::tableName().'.id')
        ->select('*, COUNT(*) AS orders')
        ->groupBy('book_id')
        ->orderBy(['orders' => SORT_DESC])
        ->limit(5)
        ->all();
    }

    private function getReturnedDate($days = 14){
        return date('Y-m-d', strtotime('+'.$days.' day', strtotime(date("Y-m-d H:i:s"))));
    }

    public function beforeSave($insert){
        if($this->isNewRecord){
            $this->newRecord = true;
            $book = Book::findOne($this->book_id);
            if(!$book->canOrder())
                return false;
            $this->user_id = \Yii::$app->user->identity->id;
            $this->ordered_at = date("Y-m-d H:i:s");
            $this->return_to = $this->getReturnedDate();
            $this->status = self::STATUS_ORDERED;
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        if ($this->newRecord){
            Book::removeOne($this->book_id);
        }

        if (!$this->newRecord){
            if (isset($changedAttributes['status']) && $this->status == Order::STATUS_RETURNED)
                $data = Book::addOne($this->book_id);
        }
        return parent::afterSave($insert, $changedAttributes);
    }

}
