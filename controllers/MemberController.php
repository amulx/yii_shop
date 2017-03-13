<?php  
namespace app\controllers;
use yii\web\Controller;

/**
* 
*/
class MemberController extends Controller
{
	
	function actionAuth()
	{
		$this->layout = 'layout2';
		return $this->render('auth');
	}
}

?>