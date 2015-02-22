<?php
	
  	require_once("common/db.php");
	$db = new dbclass();
	

  $newPage = "newPw.php";

  // ログインボタンが押された場合      
  if (isset($_GET["flg"])) {
  	$auth = $_GET["flg"];
  	
  	//既に存在するかチェック
	$sql = "select * from  `user_tbl` where activate_str = '".$db->esc($auth)."' ";
	$rc = $db -> Exec($sql);
	$username = "";
	
	if($db -> NumRows($rc) <= 0) {
		$err =  "無効なURLです。";
 		$db -> close();
 		header("Location: login.php?errorMsg=".$err);
	}
	$newPage = $newPage."?flg=".$auth;
  }else{
		$err =  "無効なURLです。";
 				$db -> close();
 		header("Location: login.php?errorMsg=".$err);
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

<body id="loginBg">
        <div id="login">
	<h1><img src="img/logo02.gif" alt=""></h1>
<div style="margin:0 10px;">
<h2>登録しているメールアドレスと新しいパスワードを入力してください</h2>
<form action="<?php echo $newPage;?>" method="post">
<br><br>
メールアドレス:<br>
<input style="width:500px;" type="text" name="username" value=""><br><br>
新しいパスワード:<br>
<input style="width:500px;" type="password" maxlength="20" name="password" value=""><br><br>
<input type="submit" name="setPw" value="送信">
</form>
<br>
<a class="toLogin" href="login.php">ログイン画面へ</a>
</div>

</div>

<h2><a href="https://www.facebook.com/wasab.inc" target="_blank">Copyright, Wasabi Co.ltd</a>
　
<p id="copy">Copyright, Wasabi Co.ltd</p>

</body>
</html>

