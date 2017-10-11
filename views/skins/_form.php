<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Skins */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="skins-form">

    <?php 
    $this->registerJs('
                  $("#skinamount-submit").click(function(){
                        $.ajax({
    							url:"site/placebet",
                                type: "POST",
                                data: $("#skinbetamount-id").serializeArray(),
                                success: function (data) {
    								//console.log(data);
			                        popupcent(data);
                                },
                        });
                       return false;
                  });
                '
    		/*yii\base\View::POS_END, 'comment-form'*/);
    
    $form = ActiveForm::begin([
    		'id' => 'skinbetamount-id',
    		'enableClientValidation' => true,
    ]); 
    
    ?>

    <?= $form->field($model, 'skins')->textInput() ?>

    <?= $form->field($model, 'time')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'transdirection')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'transactionid')->textInput(['maxlength' => true,'type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'user')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'type')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'status')->textInput(['type' => 'hidden'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Buy' : 'Update', ['id'=>'skinamount-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
