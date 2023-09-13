<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use app\models\UserPermission;

// extends \yii\base\BaseObject implements \yii\web\IdentityInterface
class User extends ActiveRecord implements \yii\web\IdentityInterface
{

    public $isAdmin;
    public $permission_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password', 'accessToken'], 'string', 'max' => 250],
            [['authKey'], 'string', 'max' => 100],
            [['permission_id'], 'safe'],
            [['libary_id'], 'safe']
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'accessToken' => 'Access Token',
            'authKey' => 'Auth Key',
            'permission' => 'User permission',
        ];
    }

    public function fields(){
        $allFields = ['id', 'username', 'permission', 'isAdmin', 'libary_id'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPermission()
    {
        return $this->hasMany(UserPermission::className(), ['user_id' => 'id']);
    }

    public function isAdmin(){
        $permission = Permission::find() 
        ->innerJoin(UserPermission::tableName(), UserPermission::tableName().'.permission_id = '.Permission::tableName().'.id' )
        ->innerJoin(User::tableName(), User::tableName().'.id = '.UserPermission::tableName().'.user_id' )
        ->where(['user_id' => \Yii::$app->user->identity->id])
        ->one();

        if(empty($permission) && empty($permission->permission))
            return false;

        return $permission->permission == Permission::ADMIN_PERMISSION;
    }

    public function isLibrarian(){
        $permission = Permission::find() 
        ->innerJoin(UserPermission::tableName(), UserPermission::tableName().'.permission_id = '.Permission::tableName().'.id' )
        ->innerJoin(User::tableName(), User::tableName().'.id = '.UserPermission::tableName().'.user_id' )
        ->where(['user_id' => \Yii::$app->user->identity->id])
        ->one();

        if(empty($permission) && empty($permission->permission))
            return false;

        return $permission->permission == Permission::LIBRARIAN_PERMISSION;
    }

    public function isUser(){
        $permission = Permission::find() 
        ->innerJoin(UserPermission::tableName(), UserPermission::tableName().'.permission_id = '.Permission::tableName().'.id' )
        ->innerJoin(User::tableName(), User::tableName().'.id = '.UserPermission::tableName().'.user_id' )
        ->where(['user_id' => \Yii::$app->user->identity->id])
        ->one();

        if(empty($permission) && empty($permission->permission))
            return false;

        return $permission->permission == Permission::USER_PERMISSION;
    }

    public function getPermission(){
        $permission = Permission::find() 
        ->innerJoin(UserPermission::tableName(), UserPermission::tableName().'.permission_id = '.Permission::tableName().'.id' )
        ->innerJoin(User::tableName(), User::tableName().'.id = '.UserPermission::tableName().'.user_id' )
        ->where(['user_id' => $this->id])
        ->one();

        if(empty($permission) && empty($permission->permission))
            return false;

        return $permission->permission;
    }


    // /**
    //  * {@inheritdoc}
    //  */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    // /**
    //  * {@inheritdoc}
    //  */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return User::find()->where(['accessToken' => $token])->one();
    }

    // /**
    //  * Finds user by username
    //  *
    //  * @param string $username
    //  * @return static|null
    //  */
    public static function findByUsername($username)
    {
        $user = User::find()->where(['username' => $username])->one();
        return $user;
    }

    // /**
    //  * {@inheritdoc}
    //  */
    public function getId()
    {
        return $this->id;
    }

    // /**
    //  * {@inheritdoc}
    //  */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    // /**
    //  * {@inheritdoc}
    //  */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    // /**
    //  * Validates password
    //  *
    //  * @param string $password password to validate
    //  * @return bool if password provided is valid for current user
    //  */
    public function validatePassword($password)
    {
        return password_verify($password, $this->getOldAttributes()['password']);
    }

    public function beforeSave($insert){
        return parent::beforeSave($insert);
    }


    public function afterSave($insert, $changedAttributes) {
        try{
            UserPermission::add($this->id, $this->permission_id);
        } catch(Exception $e){
            var_dump($e->getMessage());
        }
        

        return parent::afterSave($insert, $changedAttributes);
    }
}
