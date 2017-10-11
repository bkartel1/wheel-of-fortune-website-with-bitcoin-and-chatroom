<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BET SUMMARY';
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
<span class="question">Bets Placed</span><br><br>
<div class="skins-index">
    <p>
        <span class="admin-params">Number of bets placed: <?php echo $admindata["numberofbetsplaced"].' bets.';?></span><br>
        <span class="admin-params">Total Bet amount: <?php echo $admindata["totalbetedamount"].'skins ($'.$admindata["dtotalbetedamount"].' )';?></span><br>
    </p>
</div>
</div>
</div>
<div class="row">
<div class="col s12">
<span class="question">Results</span><br><br>
<div class="skins-index">
    <p>
        <span class="admin-params">Total Wins: <?php echo $admindata["totalresultwins"].' ($'.$admindata["dtotalresultwins"].' )';?></span><br>
        <span class="admin-params">Total losses: <?php echo $admindata["totalresultlosses"].' ($'.$admindata["dtotalresultlosses"].' )';?></span><br>
    </p>
</div>
</div>
</div>

<div class="row">
<div class="col s12">
<span class="question">Skin transfer</span><br><br>
<div class="skins-index">
    <p>
        <span class="admin-params">Total skin deposits: <?php echo $admindata["totalskindeposits"].' ($'.$admindata["dtotalskindeposits"].' )';?></span><br>
        <span class="admin-params">Total skin withdrawal: <?php echo $admindata["totalskinwithdrawal"].' ($'.$admindata["dtotalskinwithdrawal"].' )';?></span><br>
    </p>
</div>
</div>
</div>

</div>