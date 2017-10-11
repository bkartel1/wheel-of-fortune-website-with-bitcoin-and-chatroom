<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Skins */

$this->title = 'Buy Skins to bet';
$this->params['breadcrumbs'][] = ['label' => 'Skins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skins-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
