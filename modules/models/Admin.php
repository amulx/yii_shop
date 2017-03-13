<?php  
namespace app\modules\models;
use yii\db\ActiveRecord;
use Yii;

class Admin extends ActiveRecord
{
	public $rememberMe = true;
	public $repass;
	public static function tableName()
	{
		return '{{%admin}}';
	}

	public function attributeLabels(){
		return [
			'adminuser' => '管理员账号',
			'adminemail' => '管理员邮箱',
			'adminpass' => '管理员密码',
			'repass' => '确认密码'
		];
	}

	public function rules(){
		return [
			['adminuser','required','message'=>'管理员账号不能为空','on'=>['login','seekpass','changepass','adminadd','changeemail']],
			['adminpass','required','message'=>'管理员密码不能为空','on'=>['login','changepass','adminadd','changeemail']],
			['rememberMe','boolean','on'=>['login']],
			['adminpass','validatePass','on'=>['login','changeemail']],
			['adminemail','required','message'=>'电子邮箱不能为空','on'=>['seekpass','adminadd','changeemail']],
			['adminemail','email','message'=>'电子邮箱格式不正确','on'=>['seekpass','adminadd','changeemail']],
			['adminemail','unique','message'=>'电子邮箱已被注册','on'=>['adminadd','changeemail']],
			['adminuser','unique','message'=>'管理员账号已被注册','on'=>['adminadd']],
			['adminemail','validateEmail','on'=>['seekpass']],
			['repass','required','message'=>'确认密码不能为空','on'=>['changepass','adminadd']],
			['repass','compare','compareAttribute'=>'adminpass','message'=>'两次密码不一致','on'=>['changepass','adminadd']]
		];
	}
	//密码检验
	public function validatePass(){
		if (!$this->hasErrors()) {
			$data = self::find()->where('adminuser = :user and adminpass =:pass', [':user'=>$this->adminuser,":pass"=>md5($this->adminpass)])->one();
			if (is_null($data)) {
				$this->addError("adminpass",'用户名或者密码错误');
				return false;
			}
		}
	}
	//邮箱验证
	public function validateEmail(){
		if (!$this->hasErrors()) {
			$data = self::find()->where('adminuser = :user and adminemail =:email',[':user'=>$this->adminuser,":email"=>$this->adminemail])->one();
			// var_dump($data);exit;
			if (is_null($data)) {
				$this->addError('adminemail','管理员邮箱不匹配');
				return false;
			}
		}
	}
	//登录
	public function login($data){
		$this->scenario = 'login';
		if($this->load($data) && $this->validate()){
			$lifetime = $this->rememberMe ? 24 * 3600 : 0;
			$session = Yii::$app->session;
			session_set_cookie_params($lifetime);
			$session['admin'] = ['adminuser'=>$this->adminuser,'isLogin'=>1];
			$this->updateAll(['logintime'=>time(),'loginip'=>ip2long(Yii::$app->request->userIp)],'adminuser = :user',[':user'=>$this->adminuser]);
			return (bool)$session['admin']['isLogin'];
		}
		return false;
	}
	//找回密码
	public function seekPass($data){
		$this->scenario = 'seekpass';
		if ($this->load($data) && $this->validate()) {
			$time = time();
			$token = $this->createToken($data['Admin']['adminuser'],$time);
			$mailer = Yii::$app->mailer->compose('seekpass',['adminuser'=>$data['Admin']['adminuser'],'token'=>$token,'time'=>$time]);
			$mailer->setFrom('18979580510@163.com');
			$mailer->setTo($data['Admin']['adminemail']);
			$mailer->setSubject('找回密码');
			if ($mailer->send()) {
				return true;
			};			
		}
		return false;
	}

	function createToken($adminuser,$time){
		return md5(md5($adminuser).base64_encode(Yii::$app->request->userIp).md5($time));
	}

	function changePass($data){
		$this->scenario = 'changepass';
		if ($this->load($data) && $this->validate()) {
			return $this->updateAll(['adminpass'=>md5($this->adminpass)],'adminuser = :user',[':user'=>$this->adminuser]);
		}
		return false;
	}

	function reg($data){
		$this->scenario = 'adminadd';

		if ($this->load($data) && $this->validate()) {
			$data['Admin']['adminpass'] = md5($data['Admin']['adminpass']);
			$data['Admin']['repass'] = md5($data['Admin']['repass']);
			if ($this->save(false)) {
				return true;
			}			
		}
		return false;
	}

	public function changeEmail($data){
		$this->scenario = 'changeemail';
		if ($this->load($data) && $this->validate()) {
			return (bool)$this->updateAll(['adminemail'=>$this->adminemail],'adminuser = :user',[':user'=>$this->adminuser]);
		}
		return false;
	}
}


?>