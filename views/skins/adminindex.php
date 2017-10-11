<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'MY SKINS';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if( Yii::$app->user->isGuest ){ ?>
<a id="content-login" href="<?php echo Yii::$app->getUrlManager()->createAbsoluteUrl('//site/login');?>">
<img>
</a>
<?php }?>
<div id="content-faq" class="content-style">
<div class="row content-title">
<div class="col s12">
<?= Html::encode($this->title) ?>
</div>
</div>


<div class="row">
<div class="col s12">
<span class="question">Total Skin: </span><?php echo $skinbal;?><br><br>
<div class="skins-index">

    <p>
        <?= Html::a('Deposit Skins', ['#'], ['class' => 'btn btn-success','id'=>'deposit-skins']) ?>
         <?= Html::a('Withdraw Skins', ['#'], ['class' => 'btn btn-success','id'=>'withdraw-skins']) ?>
    </p>

    <?= 
   // print_array($dataProvider);
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'skins',
            'time:datetime',
            'transdirection',
            //'transactionid',
            // 'user',
             'type',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
</div>


<div class="row">
<div class="col s12">
Something went wrong? email us at support@csgoclumsy.com <br>Please make sure to include your steam ID.
</div>
</div>
</div>