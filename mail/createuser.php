<p>恭喜您，您的账号已经申请成功！</p>
<p>您的用户名是：  <span style="color: red;font-weight: 700"><?php echo $username; ?></span></p>
<p>您的密码是： <span style="color: red;font-weight: 700"><?php echo $userpass; ?></span></p>
<p>登录地址： <?php echo Yii::$app->urlManager->createAbsoluteUrl(['member/auth']); ?></p>