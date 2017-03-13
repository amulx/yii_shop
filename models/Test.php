<?php  
namespace app\models;
use yii\db\ActiveRecord;

class Test extends ActiveRecord
{
	//指定表名
	public static function tableName()
	{
		return "{{%test}}";
	}
}

?>