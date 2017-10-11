<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Betdetails */

$this->title = 'Update Betdetails: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Betdetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="betdetails-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
