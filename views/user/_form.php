<?php

use yii\helpers\Html;
use app\models\Libary;
use app\models\Permission;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <label class="control-label" for="permission_id">Typ</label>
    <?= Html::activeDropDownList($model, 'permission_id',
      ArrayHelper::map(Permission::find()->all(), 'id', 'permission'),
      ['class' => 'form-control']) ?><br/>

    <label class="control-label" for="permission_id">Biblioteka</label>
    <?= Html::activeDropDownList(
      $model, 
      'libary_id',
      ArrayHelper::map(Libary::find()->all(), 'id', 'name'),
      [
        'prompt'=> '-- przydziel do biblioteki --',
        'class' => 'form-control'
      ]) ?><br/>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Zapisz'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
