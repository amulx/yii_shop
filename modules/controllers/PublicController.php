<?php  
namespace app\modules\controllers;
use Yii;
use yii\web\Controller;
use app\modules\models\Admin;
/**
* 
*/
class PublicController extends Controller
{
	//后台登录	
	function actionLogin()
	{
		$model = new Admin;
		$this->layout = false;
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			if ($model->login($post)) {
				$this->redirect(['default/index']);
				Yii::$app->end();
			}
		}
		return $this->render('login',['model'=>$model]);
	}
	//后台退出
	function actionLogout(){
		Yii::$app->session->removeAll();
		if (!isset(Yii::$app->session['admin']['isLogin'])) {
			$this->redirect(['public/login']);
			Yii::$app->end();
		}
		$this->goback();
	}
	//后台找回密码
	function actionSeekpassword(){
		$model = new Admin();
		$this->layout = false;
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			if ($model->seekPass($post)) {
				Yii::$app->session->setFlash('info','电子邮件已经发送成功,请查收');
			};
		}
		return $this->render("seekpassword",['model'=>$model]);
	}
}

?>