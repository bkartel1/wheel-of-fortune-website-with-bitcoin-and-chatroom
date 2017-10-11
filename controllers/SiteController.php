<?php

namespace app\controllers;

use app\models\User;
use nodge\eauth\ErrorException;
use nodge\eauth\openid\ControllerBehavior;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\authclient\OpenId;
use app\models\Betdetails;
use app\models\Skins;
use app\models\Userbets;
use app\controllers;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'eauth' => [
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only' => ['login'],
            ],
        ];
    } 

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex($option=1)
    {
    	//$runwheel= $this->runwheel();
    	
    	//$this->view->params['runwheel'] = $runwheel;
    	$this->view->params['is_admin'] = $this->isAdmin();
    	
    	
    	if ($option==2) {
    		return $this->renderAjax('index');
    	}    	
    	else {
        return $this->render('index');}
    }

    public function actionLogin()
    {
        /** @var $eauth \nodge\eauth\ServiceBase */
        //$eauth = Yii::$app->get('eauth')->getIdentity('steam');
    	//$eauth =68686;
        //$eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
        //$eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

        try {
          // if ($eauth->authenticate()) {
        	//$eauth='steam';
                $identity = User::findByEAuth($eauth);

                $user = User::findOne(['steamid' => 68686/*$identity->steamid*/ ]);

               if (!$user) {
                    $user = new User();
                }

                $user->username ='name';//$identity->username;
                $user->steamid =rand(638388, 3333332);//$identity->steamid;
                $user->profile_url = 'http://steamcommunity.com/profile';//= $identity->profile_url=;
                $user->avatar ='http://steamcommunity.com/profile';//= $identity->avatar;
                $user->avatar_md ='http://steamcommunity.com/profile';//= $identity->avatar_md;
                $user->avatar_lg ='http://steamcommunity.com/profile';//= $identity->avatar_lg;
                $user->generateAuthKey();

                $user->save();

                
                
                //Yii::$app->getUser()->login($identity);
                Yii::$app->getUser()->login();
                $this->redirect(array('site/index'));
               // $eauth->redirect();
            /*} else {
                $eauth->cancel();
            }  */
        } catch (ErrorException $e) {
            Yii::$app->getSession()->setFlash('error', 'EAuthException: ' . $e->getMessage());

            $eauth->redirect($eauth->getCancelUrl());
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionToken()
    {
        if (!Yii::$app->request->isAjax) {
            return 'Permission denied';
        }

        $steamid = 68686; //Yii::$app->user->identity->steamid;

        if (!$steamid) {
            return 'nologin';
        }

        $user = User::findOne(['steamid' => $steamid]);

        if (!$user) {
            return 'nologin';
        }

        $user->generateAuthKey();
        $token = $user->getAuthKey();

        $user->save();

        return '?steamid=' . $steamid . '&time=' . time() . '&token=' . $token;
    }
    
    public function newwheel(){
    	//create new wheel roll-> compute random result store in bet details table
    	$Betdetails= new Betdetails();
    	
    	$wheeltime=time();
    	$Betdetails->resulttime=$wheeltime+68;// time to run the roll
    	$Betdetails->rolltime=$wheeltime+60;
    	$Betdetails->results=rand(1,4);
    	$Betdetails->stage=1; //1->countdown, 2-> roll, 3->closed
    	$Betdetails->open=1; //1=open,0=>closed
    	
    	$Betdetails->save();    	
    	//return array['time-remaining','stage']   	
    	return ["rollid"=>$Betdetails->id,'time'=>$Betdetails->rolltime-time(),'stage'=>1,"rollid"=>$Betdetails->id];
    	// do new countdown() on client
    }
    
    public function runwheel(){
    	$ongoingroll= Betdetails::findall(['open'=>1]);
    	
    	/*there is a wheel running*/
    	$ongoingrollno = count($ongoingroll);
    	if(0<$ongoingrollno ){
    		$resulttime1=$ongoingroll[0]->rolltime-time();
    		if ($resulttime1>300) {
    			$this->actionCloseroll($ongoingroll[0]->id);
    			return $this->newwheel();
    		}
    		//$resulttime1=$ongoingroll->rolltime-time();
    		//$resulttime2=$ongoingroll[0]->resulttime-time();
    	
    		if ($ongoingroll[0]->stage==2) {
    			return ['rollid'=>$ongoingroll[0]->id,'time'=>$ongoingroll[0]->resulttime-time(),'stage'=>$ongoingroll[0]->stage, 'gameover'=>$ongoingroll[0]->results-1];
    		}    		
    		else{
	    		if ($ongoingroll[0]->stage==1) {//countdown	    			
		    		return ['rollid'=>$ongoingroll[0]->id,'time'=>$ongoingroll[0]->rolltime-time(),'stage'=>$ongoingroll[0]->stage];
	    		}
	    		elseif ($ongoingroll[0]->stage==2){//roll	    			   			  			 
	    			return ['rollid'=>$ongoingroll[0]->id,'time'=>$ongoingroll[0]->resulttime-time(),'stage'=>$ongoingroll[0]->stage, 'gameover'=>$ongoingroll[0]->results-1];    			
	    		}
	    		//start countdown timer - give back the time remaining to execution.
	    		//send to the client side result.// encrypt it somehow
    		}
    	}
    	else{
    		return $this->newwheel();
    	}  	  	
    }
    
    public function actionDoresults(){
    	//close this roll
    	//allocate all results to relevant members
    	
    	//return done- > you won,you lot, you never bet
    	//return new roll details
    	
    	//$runwheel=$this->runwheel();    	
    }
    
    public function actionCloseroll($activeroll){// only method that can change betdetails to stage 3
    	if ($activeroll) {
    		/*process all relevant betted skins********
    		 *close the bet
    		 *create new roll
    		 *return results
    		 */
    		$betdetailmodel= Betdetails::findOne($activeroll);
    		$rc=$betdetailmodel->results-1;
    		$resultcolorname=["Gray","Green","Blue","Orange"];
    		$rainbow=['#666','#32cd32','#45B5DA ','#FFC870 '];
    		
    		if ($betdetailmodel->open==1) {
    			
    		$rc=$betdetailmodel->results-1;
    		$activeuserbets=Userbets::findAll(["status"=>1]);
    		$activeuserbetsNo = count($activeuserbets);
    		
    		if ($activeuserbetsNo>0) {
    		for($i=0;$i<$activeuserbetsNo; $i++){
    			if($activeuserbets[$i]->options==$betdetailmodel->results){
    				//give them skins 
    				$skins= Skins::findOne($activeuserbets[$i]->skins);
    				$skins->time=time();
    				$skins->transdirection=1;
    				$skins->transactionid=$activeuserbets[$i]->id;
    				$skins->type=3;
    				$skins->status=1;

    				$skins->save();
    				
    				$activeuserbets[$i]->status=0;
    				$activeuserbets[$i]->save();
    			}
    			elseif($activeuserbets[$i]->options!==$betdetailmodel->results){
    				//take away skins
    				$skins= Skins::findOne($activeuserbets[$i]->skins);
    				$skins->time=time();
    				$skins->transdirection=2;
    				$skins->transactionid=$activeuserbets[$i]->id;
    				$skins->type=2;
    				$skins->status=1;
    				    				
    				$skins->save();
    				
    				//deactivate userbet
    				
    				$activeuserbets[$i]->status=0;
    				$activeuserbets[$i]->save();
    			}
    		}    		
    		}
    		//render betdetails open to false
    		$betdetailmodel->open=0;
    		$betdetailmodel->stage=3;    		
    		$betdetailmodel->resulttime=time();
    		$betdetailmodel->save();
    		
    		//create new roll
    		//return new roll details
    		$closedata=$this->newwheel();
    		$closedata['message']='<span style="color:'.$rainbow[$rc].';">'.$resultcolorname[$rc].' won!! Place your bet on the next roll to win BIG!!</span>';
    		
    		return json_encode($closedata); 
    	}
    	else {
    		$closedata['message']='<span style="color:'.$rainbow[$rc].';">'.$resultcolorname[$rc].' won!! Place your bet on the next roll to win BIG!!</span>';
    		
    		return json_encode($closedata);
    	}
    	}
    	else {
    		$closedata['message']='An error occured, Please reload the page to continue playing.';
    		
    		return json_encode($closedata);
    	}
    }
    
    
    public function actionListbetters($lastlistid){
    	$userbetunlisted =Userbets::find()->where(['>=',"id",$lastlistid])->andwhere(['=',"status",1])->all();//->where("id >$lastlistid");
    	$userbetunlistedNO=count($userbetunlisted);
    	if ($userbetunlistedNO>0) {//return json with 
    		for($i=0;$i<$userbetunlistedNO;$i++){
    			$usermodel= User::findOne($userbetunlisted[$i]->user);
    			if (isset($usermodel)) {
    				$skinsmodel[$i]=Skins::findOne($userbetunlisted[$i]->skins);
    				$betuserinfoarray[$i]=["level"=>$usermodel->level,"imageurl"=>$usermodel->avatar,"username"=>$usermodel->username,"betoption"=>$userbetunlisted[$i]->options-1,"skinamount"=>$skinsmodel[$i]->skins];
    			}
    			}
    		
    		return json_encode($betuserinfoarray);
    	}
    }
    
    public function actionWhereweat(){
    	/*jsson @todo do notification for user
    	 * 1.stage
    	 * 2.time
    	 * 3.gameover ----> result
    	 * */
    	$wheeldata=$this->runwheel();
    	if (!Yii::$app->user->isGuest){
    		$wheeldata['loggedIn']=true;
    	}
    	else
    		$wheeldata['loggedIn']=false;
    	
    	return json_encode($wheeldata);
    }
    
    public function actionRollstart(){
    	/* return jsson @todo do notification for user
    	 * 1.stage
    	* 2.time
    	* 3.gameover ----> result
    	* 4.bet id
    	* */
    	$wheeldata=$this->runwheel();
    	$ongoingroll= Betdetails::findOne(['open'=>1]);
    	$wheeldata['gameover']=$ongoingroll->results-1;
    	
    	
    	return json_encode($wheeldata);    	
    }
     
        
    public function actionPlacebet(){
//if not logged in-> make them login
    if (Yii::$app->user->isGuest) {
    	return '<h5>Please login to place a bet. click <a id="content-login" href="'.Yii::$app->getUrlManager()->createAbsoluteUrl('//site/login').'"><img></a></h5>';
    	Yii::$app->end();
    }
    	
//if place bet -> give userbet window
    if (isset($_GET["betselection"])) {
    		//return 'Your selection is '. $_GET["betselection"];
    	if (!isset($_POST['Userbets'])) {
    		// see if we are accepting bets
    		//yes
    		$ongoingrollaccept= Betdetails::findall(['open'=>1, 'stage'=>1]);
    		 
    		/*if(!$ongoingrollaccept){
    			return "Betting has been closed, please wait for next roll to place your bet";
    		}
    		else {  */ 			
    		
    		$model= new Userbets();
    		$model->skins=500;
    		$model->options=$_GET["betselection"];
    		
    		return $this->renderAjax('//userbets/create',['model'=>$model]); //\app\controllers\userbetsController\actionCreate;
    		
    	}
    }
    	
/* @todo wheel roll is ongoing and is not accepting bets
    		
    $ongoingrollaccept= Betdetails::findall(['open'=>1, 'stage'=>1]);
    		 
    if(!$ongoingrollaccept){
    	return "Betting has been closed, please wait for next roll to place your bet";
    	Yii::$app->end();
    }*/
//if skins are not enough -> skin buy
    
    if (isset($_POST['Skins'])){
    	//buy skin - enter skins with add as type
    	$data=$_POST['Skins'];
    	$data['transdirection']=1; //[1=>add,2=>subtract]
    	//$data['transactionid'];
    	$data['type']=4; //['1'=>'bet', '2'=>'betloss', '3'=>'betgain', '4'=>'deposit', '5'=>'withdrawal' ]
    	$data['status']=1;
    	
    	$this->processskins($data);
    	//transfer skins to userbet to active:: subtract form skin/ activate skin options
    	//update betuser status from transactionid to active
    	$betmodel=Userbets::findOne($data['transactionid']);
    	$betmodel->status=1;
    	$betmodel->save();
    	
    	return 'Skin has been deposted and bet placed.';
    }
    
    if (isset($_POST['Userbets'])){
    $Userbets=$_POST['Userbets'];

     //check if here is enough skins-if there isnt:store in db awaiting aproval and demand that they buy
    $skinsbal=$this->skinbal();
    
    //place bet in db
    	if ($Userbets['skins']>$skinsbal) {
    		//save the bet amount and request to buy
    		//return buyskin ajax render;
    		$requestamount=$Userbets['skins']-$skinsbal;
    		$processBetid=$this->processBet($Userbets,0);
    		
    		return $this->Buyskins($requestamount,$processBetid);
    		//Yii::$app->end();
    	}    	//if all is good and bet isplaced succesfully- return status wecool => 8, 1=>     
    	    	//end app	   	 
    	
    	// processBet == status 1=successful bet submission
    	if($this->processBet($Userbets)){
    		return 'Bet successfully placed!!';
    	}
    }
    return 'Ups! This is embarassing- we are not able to place your bet. <br>Reload the page and try again';
    }  
    
    
    public function processBet($data,$status=1){//status 1=successful bet submission, 0=unsuccessful bet submission
    	//$data['skins'],$data['option']
    	//subtract skins from the skin account put it to
    	$skins=  new Skins();
    	
    	$skins->skins=$data['skins'];
    	//$skins->time=time();
    	$skins->transdirection=2;
    	$skins->user=Yii::$app->user->id;
    	$skins->type=1;
    	$skins->status=$status;
    	$skins->save();
    	
    	/*enter user bet*/
    	$ongoingrollaccept= Betdetails::findall(['open'=>1, 'stage'=>1]);
    	
    	$userbets= New Userbets();
    	
    	$userbets->skins=$skins->id;
    	$userbets->betdeatail=$ongoingrollaccept[0]->id;
    	$userbets->options=$data['options'];
    	$userbets->user=Yii::$app->user->id;
    	$userbets->save();
    	
    	return $userbets->id;
    }
    
    public function Buyskins($requestamountadd=0,$betid=0){
    	
    		//Request 3rd party API to receive payment
    		$model = new Skins();
    		$model->skins=$requestamountadd;
    		$model->transactionid=$betid;
    		
    		if ($model->load(Yii::$app->request->post()) && $model->save()) {
    			return $this->redirectAjax(['//skins/view', 'id' => $model->id]);
    		} else {
    			return $this->renderAjax('//skins/create', [
    					'model' => $model,
    					]);
    		}
    }
    
    public function processskins($data){
    	//Request 3rd party API to receive payment
    	$model = new Skins();
    	
    	$model->skins=$data['skins'];
    	$model->time=time();
    	$model->transdirection=$data['transdirection']; //[1=>add,2=>subtract]
    	$model->transactionid=$data['transactionid'];
    	$model->user=\Yii::$app->user->id;
    	$model->type=$data['type']; //['1'=>'bet', '2'=>'betloss', '3'=>'betgain', '4'=>'deposit', '5'=>'withdrawal' ]
    	$model->status=$data['status'];
    	
    	$model->save();
    }
    
    public function actionSellskins($result){
    	$skinbal=$this->skinbal();
    	if($skinbal>0){
    		if($condition=true){
    			//enter buy skin transaction
    			//enter money transaction
    			//add skins in the user account
    		}
    		else{
    			//Show- You are unable to withdraw because of abc
    		}
    	}
    	else{
    		//@todo Show-> You skin balance is 0  please buy skins to here
    		
    	}
    }
    
   
    public function actionSkinstransactionlist()
    {
    	//show skins from the latest
    	return $this->render(['//skins/index']);
    }
    
    public function actionBetresult()
    {
    	$betresult=1;//get from bet details the results
    	//loop all placed bets and allocate skins appropriately
    	if($betresult==$userchoice) // won
    	{
    		//add bet skins in the users' account
    		//add won skins
    	}
    	elseif($betresult!==$userchoice) // lost
    	{
    		//show the bet is done and the user lost
    	}
    }
    
    public function addskins($skinaarray){
    	$skinaarrayno=count($skinaarray);
    	 
    	if($skinaarrayno==0){
    		return 0;
    	}
    	else{
    		$skinaarraytotal=0;
    		for($i=0;$i<$skinaarrayno;$i++){
    			$skinaarraytotal=$skinaarraytotal+ $skinaarray[$i]->skins;
    		}
    		return $skinaarraytotal;
    	}
    }
    
    protected function skinbal(){
    	//return skins added- skins subtracted
    	$addedskins= Skins::findAll(['transdirection'=>1]);
    	$subtractedskins= Skins::findAll(['transdirection'=>2]);
    	
   		$addedskinstotal=$this->addskins($addedskins);
    	$subtractedskinstotal=$this->addskins($subtractedskins);
	   
    	$skinbal = $addedskinstotal-$subtractedskinstotal;
    	
    	return $skinbal;
    }
    
    //collaborate in the index on staff like how it works and what not
    public function actionUser()
    {
    
    }
    
    public function actionHowitworks(){
    	return $this->renderPartial('howitworks');
    }

    public function actionTermsofservice(){
    	return $this->render('termsofservice');
    }
    
    public function actionFaq(){
    	return $this->renderPartial('faq');
    }
    
    public function isAdmin(){
    	//$usermodel= \app\models\User::findOne(Yii::$app->user->id);
    	/*$usermodel['is_admin']=1;
    	if ($usermodel['is_admin']) { */
    		return true;
    	/*}
    	else {
    		require false;
    	} */
    	
    	//return $usermodel;
    }
}