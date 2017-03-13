<p>尊敬的admin，您好：</p><?php echo $adminuser;?>
<p>您的找回密码链接如下：</p>
<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['admin/manage/mailchangepass','token'=>$token,'adminuser'=>$adminuser,'whtchtime'=>$time,]) ?>
<p><?php echo $url; ?></p>