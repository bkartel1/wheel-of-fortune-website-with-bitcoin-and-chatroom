<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Moneys';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Money', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'transactionid',
            'amount',
            'currency',
            'skins',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
