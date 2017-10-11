<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userbets */

$this->title = 'Please enter the number of skins you will be betting';
$this->params['breadcrumbs'][] = ['label' => 'Userbets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userbets-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
