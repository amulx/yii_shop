<?php  
namespace app\controllers;

use yii\web\Controller;

class CartController extends Controller
{
	//购物车页面
	function actionIndex()
	{
		$this->layout = 'layout1';
		return $this->render('index');
	}
}



?>