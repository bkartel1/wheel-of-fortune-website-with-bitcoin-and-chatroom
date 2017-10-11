<?php

namespace app\controllers;

use Yii;
use app\models\Skins;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SkinsController implements the CRUD actions for Skins model.
 */
class SkinsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Skins models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Skins::find(),
        ]);

        return $this->renderAjax('index', [
            'dataProvider' => $dataProvider,
        	'skinbal'=>$this->skinbal(),
        ]);
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
    /**
     * Displays a single Skins model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Skins model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Skins();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Skins model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Skins model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Skins model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Skins the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Skins::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionAdmin(){
    	$betactive_skin_trans=Skins::findAll(["type"=>1]);
    	$betloss_skin_trans=Skins::findAll(["type"=>2]);
    	$betgain_skin_trans=Skins::findAll(["type"=>3]);
    	
    	$skindeposit_trans=Skins::findAll(["type"=>4]);
    	$skinwithdraw_trans=Skins::findAll(["type"=>5]);
    	
    	$betactive_skin_transcount=count($betactive_skin_trans);
    	$betloss_skin_transcount=count($betloss_skin_trans);
    	$betgain_skin_transcount=count($betgain_skin_trans);
    	
    	$totalresultwins=$this->addskins($betgain_skin_trans);
    	$totalresultlosses=$this->addskins($betloss_skin_trans);
    	$totalresultactive=$this->addskins($betactive_skin_trans);
    	
    	$totalskindeposits=$this->addskins($skindeposit_trans);
    	$totalskinwithdrawal=$this->addskins($skinwithdraw_trans);
    	
    	$totalbetedamount=$totalresultwins+$totalresultlosses+$totalresultactive;
    	
    	$all_skin_transcount=$betactive_skin_transcount+$betloss_skin_transcount+$betgain_skin_transcount;
    	
    	$admindata=[
    	"numberofbetsplaced"=>$all_skin_transcount,
    	"totalbetedamount"=>$totalbetedamount,
    	"totalresultwins"=>$totalresultwins,
    	"totalresultlosses"=>$totalresultlosses,
    	"totalskindeposits"=>$totalskindeposits,
    	"totalskinwithdrawal"=>$totalskinwithdrawal,
		];
    	
    	//$admindata["dnumberofbetsplaced"]=$admindata["numberofbetsplaced"]/1000;
    	$admindata["dtotalbetedamount"]=$admindata["totalbetedamount"]/1000;
    	$admindata["dtotalresultwins"]=$admindata["totalresultwins"]/1000;
    	$admindata["dtotalresultlosses"]=$admindata["totalresultlosses"]/1000;
    	$admindata["dtotalskindeposits"]=$admindata["totalskindeposits"]/1000;
    	$admindata["dtotalskinwithdrawal"]=$admindata["totalskinwithdrawal"]/1000;
    	
    	return $this->renderPartial('admin',["admindata"=>$admindata]);
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
    
    public function actionAdminindex(){
    	 $dataProvider = new ActiveDataProvider([
            'query' => Skins::find(),
        ]);

        return $this->renderAjax('index', [
            'dataProvider' => $dataProvider,
        	'skinbal'=>$this->skinbal(),
        ]);
    }
}
