<?php
namespace app\modules\controllers;
use yii\web\Controller;
use Yii;
use app\models\User;
use app\models\Profile;
use yii\data\Pagination;
/**
* 
*/
class UserController extends Controller
{
	
	function actionUsers()
	{
		$this->layout = 'layout1';
		$model = User::find()->joinWith('profile');//关联表
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['user'];//读取配置文件信息
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$users = $model->offset($pager->offset)->limit($pager->limit)->all();

		return $this->render('users',['users'=>$users,'pager'=>$pager]);		
	}

	function actionReg(){
		$this->layout = 'layout1';
		$model = new User;
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			if ($model->reg($post)) {
				Yii::$app->session->setFlash('info','添加成功');
			}
		}
		$model->userpass = '';
		$model->repass = '';
		return $this->render('reg',['model' =>$model]);
	}

	function actionDel(){
		try {
			$userid = (int)Yii::$app->request->get('userid');
			if(empty($userid)){
				throw new Exception("Error Processing Request", 1);				
			}
			$trans = Yii::$app->db->beginTransaction();
			if ($obj = Profile::find()->where('userid = :id',[':id'=>$userid])->one()) {
				$res = Profile::deleteAll('userid = :id',[':id' => $userid]);
				if (empty($res)) {
					throw new \Exception();
				}
			}
			if (!User::deleteAll('userid = :id',[':id'=>$userid])) {
				throw new \Exception();
			}
			$trans->commit();
		} catch (Exception $e) {
			if (Yii::$app->db->getTransaction()) {
				$trans->rollback();
			}
		}
		$this->redirect(['user/users']);
	}
}
?>