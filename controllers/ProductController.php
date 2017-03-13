<?php  
namespace app\controllers;

use yii\web\Controller;

/**
* 
*/
class ProductController extends Controller
{
	//商品列表页
	function actionIndex()
	{
		$this->layout = 'layout2';
		return $this->render('index');
	}
	//商品详情页
	function actionDetail(){
		$this->layout = 'layout2';
		return $this->render('detail');
	}
}

?>