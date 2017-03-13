<?php  
namespace app\controllers;

use yii\web\Controller;

/**
* 
*/
class OrderController extends Controller
{
	//订单中心
	function actionIndex(){
		$this->layout = 'layout2';
		return $this->render('index');
	}
	//结算页面
	function actionCheck()
	{
		$this->layout = 'layout1';
		return $this->render('check');
	}
}



?>