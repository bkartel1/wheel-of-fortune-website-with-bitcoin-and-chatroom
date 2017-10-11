<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\HandlebarsAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
//HandlebarsAsset::register($this);
if(!Yii::$app->user->isGuest){
$this->registerJs('
var STEAMID = "' . Yii::$app->user->identity->steamid .'";
var USERNAME = "' . Yii::$app->user->identity->username . '";
');
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::$app->name ?> - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <meta name="description" content="CSGO clumsy is a Wheel of Fortune website. Deposit skins and Win big!">
<meta name="keywords" content="CSGO,clumsy,wheel,fortune,skins,giveaway,high,tier,bet,betting,win,lucky,counter-strike,global,offensive,game,money,coins,free,prizes,reward,referral">
<meta name="robots" content="index">
<link rel="icon" type="image/png" sizes="32x32" href="">
<link rel="stylesheet" href="./CSGO500 - Wheel of Fortune_files/materialize.min.css">
<link href="./CSGO500 - Wheel of Fortune_files/interface-style-v8.css" rel="stylesheet">
<script src="./CSGO500 - Wheel of Fortune_files/scripts-obf-v8.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if(Yii::$app->user->isGuest){ ?>
<script>
				loggedIn = false;				
			</script>
<?php } ?>

</head>
<body>
<form>
 <input class="callTime" type="hidden">
</form>
<?php //$this->beginBody() ?>
<div id="interface-wrapper">
<div id="login-background" style="opacity: 1; display: none;">
<div id="login-content">
<div class="login-title">Welcome,</div>
<div class="login-big-block">
<div class="login-block" style="border-right: 2px solid #32cd32">
<span class="login-subtitle">Free <b>1,000</b> coins</span><br>
<img class="login-bucks2" src="./CSGO500 - Wheel of Fortune_files/x3.png"><br>
<span class="login-subsubtitle">50 coins / referral</span>
</div>
<div class="login-block">
<span class="login-subtitle">Earn <b>Daily</b> Rewards</span><br>
<img class="login-bucks" src="./CSGO500 - Wheel of Fortune_files/card.png"><br>
<span class="login-subsubtitle">Up to <b>2,500</b> coins daily</span>
</div>
</div>
<div class="login-terms">By clicking "Got it", you agree to the <a style="color: #32cd32; text-decoration: underline;" href="./CSGO500 - Wheel of Fortune_files/terms.txt" target="_blank">Terms of Service</a>.</div><br>
<div id="gotit-btn" class="gotit-btn noselect" style="margin-top: 20px;">
Got it
</div>
</div>
</div>
<div id="chat-wrapper">
<div id="chat-logo">
<img src="./CSGO500 - Wheel of Fortune_files/logo.png">
</div>
<div id="social">
<a href="https://twitter.com/" target="_blank">
<img class="social-logo" src="./CSGO500 - Wheel of Fortune_files/twitter.png">
</a>
<a href="http://steamcommunity.com/groups/csgoclumsy" target="_blank">
<img class="social-logo" src="./CSGO500 - Wheel of Fortune_files/steam.png">
</a>
</div>
<div id="chat-players" style="display: block;">
<span id="online">2,068</span> <i id="online-icon" class="material-icons">person</i>
</div>
<div id="chat">
    
                            <?php foreach (\app\models\Message::find()->limit(8)->orderBy('date DESC')->all() as $msg): ?>
                                <div class="chat-post" data-steamid="<?= $msg->steamid ?>">
                                    <a href="<?= $msg->user->profile_url ?>" target="_blank">
                                        <img class="chat-avatar img-circle" src="<?= $msg->user->avatar_md ?>">
                                    </a>
                                    <dl class="chat-body">
                                        <dt class="username"><a href="<?= $msg->user->profile_url ?>"
                                                                target="_blank"><?= $msg->user->username ?></a></dt>
                                        <dd class="message"><?= \yii\helpers\Html::encode($msg->message) ?></dd>
                                    </dl>
                                </div>
                            <?php endforeach ?>
                            </div>
                            <div id="chat-input-wrapper">
                           <div class="panel-footer">
                        <form id="send">
                            <div class="input-group">
                            <?php if (Yii::$app->user->isGuest) { ?>  
                            <input type="text" class="form-control" id="message" placeholder="Login to chat..."  autocomplete="off">              	
                            <?php }else {?>
                                <input type="text" class="form-control" id="message" placeholder="Message..."
                                       autocomplete="off">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Send</button>
                                </span>
                                <?php }?>
                            </div>
                        </form>
                    </div> </div>
                           
                            
<div id="nav-wrapper">
	<ul id="nav-custom">
	<div id="nav-border"></div>
		<li href="#" id="nav-wheel-roll" class="nav-element-active noselect">
			<i class="nav-icon material-icons"><a href="">Wheel</a></i>
		</li>
		<li href="#" id="nav-how-it-works" class="nav-element noselect">
			<i class="nav-icon material-icons">Guide</i>
		</li>
		<li href="#" id="nav-faq" class="nav-element noselect">
			<i class="nav-icon material-icons">FAQs</i>
		</li>
		<?php if (!Yii::$app->user->isguest) {?>
		<li href="#" id="nav-skins" class="nav-element noselect">
			<i class="nav-icon material-icons">Skins</i>
		</li>
		<?php }?>
		<?php if (!Yii::$app->user->isguest && $this->params['is_admin'] ) {
		
			
			?>
		<li href="#" id="nav-admin" class="nav-element noselect">
			<i class="nav-icon material-icons">Admin</i>
		</li>
		<?php }?>
	</ul>
</div> 
</div>
<div id="content-wrapper">
        <?= $content ?>
        
</div>
        
    
<?php //$this->endBody() ?>
<div class="hiddendiv common"></div><span id="buffer-extension-hover-button" style="display: none; position: absolute; z-index: 8685309; width: 100px; height: 25px; opacity: 0.9; cursor: pointer; top: 337px; left: 438.016px; background-image: url(&quot;chrome-extension://noojglkidnpfjbincgijbaiedldjfbhh/data/shared/img/buffer-hover-icon@1x.png&quot;); background-size: 100px 25px;"></span>
<div id="toast-container">
</div>

<div id="betplace">
</div>

<script id="chat-post" type="text/x-handlebars-template">
    <div class="chat-post" data-steamid="{{steamid}}" data-messageid="{{id}}">
        <a href="{{profile_url}}" target="_blank">
            <img class="chat-avatar img-circle" src="{{avatar}}">
        </a>
        <dl class="chat-body">
            <dt class="username"><a href="{{profile_url}}" target="_blank">{{username}}</a></dt>
            <dd class="message">{{message}}</dd>
        </dl>
    </div>
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
