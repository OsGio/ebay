<?php
	require_once("common/db.php");
	
  

  // ログインボタンが押された場合      
  $hasErr = false;
  $checked = "";
  $err = "";
  if (isset($_POST["forgetBtn"])) {
  	//画面チェック
	$username = $_POST["username"];
	if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $username)) {
	    	$err = $err . "正しいメールアドレスを入力してください";
	    	$hasErr = true;
	}else{
			$db = new dbclass();
			
			//既に存在するかチェック
			$sql = "select * from  `user_tbl` where username = '".$db->esc($username)."' ";
			
			$rc = $db -> Exec($sql);
			if($db -> NumRows($rc) == 0) {
	    		$hasErr = true;
				$err = "登録がありませんでした。最初にアカウント登録をしてください。";
				$db -> close();
			}else{
				// ランダム文字列生成
				$str = $db -> ran();
				$sql = "update  `user_tbl` set activate_str = '".$db->esc($str)."'  where username = '".$db->esc($username)."' ";
				$db -> Exec($sql);
				$db -> close();
			
				$db -> sendmail($username,3,$str);
				
			}

	}
  }
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>
		アイテムコンバータ	</title>
	<link href="/favicon.ico" type="image/x-icon" rel="icon" />
	<link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" />
	<link rel="stylesheet" type="text/css" href="css/cake.generic.css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="css/jquery-ui-timepicker-addon.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
<script src="js/jquery.ui.datepicker-ja.js" type="text/javascript"></script>
<script src="js/cpick.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/login.css">

<script type="text/javascript">
  $(function(){
    $(".menu").click(function(){
      var action = $(this).attr('data-action');
      var url = "/mypage/" + action;
      location.href = url;
    });
  });
</script>
</head>
<?php

?>
<body id="loginBg">

        <style type="text/css">
  .message {
    margin:0 auto;
  }
</style>
<div id="login">

	<h1>
	<img src="img/logo02.gif" alt="" />
	</h1>

		<?php 
		if($hasErr) {
		?>
		<div id="flashMessage" class="message"><?php echo_h($err); ?></div>	
		<?php 
		} elseif (isset($_POST["forgetBtn"])) {
		 ?>
		 <div style="margin:10px;">
メールを送信しました。<br>
		<?php 
		} else {
		 ?>

	<h2>登録しているメールアドレスを入力してください</h2>
<div style="margin:0 10px;">
	<form action="forgot.php" method="post">
	メールアドレス:<br />
	<input style="width:500px;" type="text" name="username" value=""><br /><br />
	<input type="submit" name="forgetBtn" value="送信">
	</form>
		<?php 
		} 
		 ?>
<br />

<p align="center">
<a class="toLogin" href="login.php">ログイン画面へ</a>
</p>

</div>
</div>


　
<p id="copy">Copyright, Wasabi Co.ltd</p>


</body>
</html>

