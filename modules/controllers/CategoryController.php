<?php
namespace app\modules\controllers;
use yii\web\Controller;
use app\models\Category;
use Yii;
/**
* 
*/
class CategoryController extends Controller
{
	
	function actionList()
	{
		$this->layout = 'layout1';
		return $this->render('cates');
	}

	function actionAdd(){
		$model = new Category();
		echo '<pre>';
		$catas = $model->getData();
		$tree = $model->getTree($catas);
		print_r($tree);exit();
		$list = $model->getOptions();
		// print_r($list);
		$this->layout = 'layout1';
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			if ($model->add($post)) {
				Yii::$app->session->setFlash('info','添加成功');
			}
		}
		
		return $this->render('add',['list'=>$list,'model'=>$model]);
	}
}
?>