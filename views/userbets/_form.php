<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userbets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userbets-form">

    <?php 
    $this->registerJs('
                  $("#amount-submit").click(function(){
                        $.ajax({
    							url:"site/placebet",
                                type: "POST",
                                data: $("#betamount-id").serializeArray(),
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
    		'id' => 'betamount-id',
    		'enableClientValidation' => true,
           
    ]); ?>
<div id="skin-helper">
<button type="button" id="btn-500-skins" onclick="document.getElementById('userbets-skins').value = 500;" class="btn btn-success">500 skins</button>
<button type="button" id="btn-1000-skins" onclick="document.getElementById('userbets-skins').value = 1000;" class="btn btn-success">1000 skins</button>
<button type="button" id="btn-double-skins" onclick= "document.getElementById('userbets-skins').value = document.getElementById('userbets-skins').value * 2;" class="btn btn-success">Double skins</button>
<button type="button" id="btn-triple-skins" onclick= "document.getElementById('userbets-skins').value = document.getElementById('userbets-skins').value * 3;"  class="btn btn-success">Triple skins</button>
</div>
    <?= $form->field($model, 'skins')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'betdeatail')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'options')->textInput(['type' => 'hidden'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Place Bet' : 'Update Bet', ['id'=>'amount-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
