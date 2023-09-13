<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\base\Model;

/**
 * This is the model class for table "user_permissions".
 *
 * @property int $id
 * @property int $user_id
 * @property int $permission_id
 *
 * @property Permissions $permission
 * @property User $user
 */
class UserPermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'permission_id'], 'required'],
            [['user_id', 'permission_id'], 'integer'],
            [['permission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Permission::className(), 'targetAttribute' => ['permission_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'permission_id' => 'Permission ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermission()
    {
        return $this->hasOne(Permissions::className(), ['id' => 'permission_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public static function add($user_id, $permission_id){
        $exists = UserPermission::find()->where(['user_id' => $user_id])->one();
        $permission = ($exists ? $exists : new UserPermission);
        $permission->user_id = $user_id;
        $permission->permission_id = $permission_id;
        if(!$permission->save())
            throw new \Exception("Nie udało się zapisać uprawnień", 1);
            
        return true;
    }
}
