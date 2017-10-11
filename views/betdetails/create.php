<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Betdetails */

$this->title = 'Create Betdetails';
$this->params['breadcrumbs'][] = ['label' => 'Betdetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="betdetails-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
