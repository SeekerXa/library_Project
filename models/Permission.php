<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permissions".
 *
 * @property int $id
 * @property string $permission
 *
 * @property UserPermission[] $UserPermission
 */
class Permission extends \yii\db\ActiveRecord
{
    const ADMIN_PERMISSION = 'admin';
    const LIBRARIAN_PERMISSION = 'librarian';
    const USER_PERMISSION = 'user';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permission'], 'required'],
            [['permission'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'permission' => 'Permission',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPermission()
    {
        return $this->hasMany(UserPermission::className(), ['permission_id' => 'id']);
    }
}