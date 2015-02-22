<?php
	
  	 session_start();
  	error_reporting(0);

  // エラーメッセージ
  $errorMessage = "";
  // 画面に表示するため特殊文字をエスケープする
  $viewUserId = htmlspecialchars($_POST["CONVERTER_USERID"], ENT_QUOTES);

  // ログインボタンが押された場合      
  if (!isset( $_SESSION["REGISTERED"]) ||  $_SESSION["REGISTERED"] != "1") {
  	header("Location: login.php");
  }
	  	session_destroy();

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
	<h1><img src="img/logo02.gif"  alt=""></h1>

	<div style="margin:0 10px 100px 10px;">
	<h2 style="font-size:22px;margin-bottom:20px;">会員登録ありがとうございました</h2>

	<p style="text-align:center;">
	入力されたアカウントID宛にメールを送信いたしました。<br><br>
	<span style="color:red;">※登録はまだ完了していません。</span><br><br>
	送信したメールのURLをクリックしていただきますと、登録が完了いたします。
	</p>

 </div>


	<p style="text-align:center;">
	Copyright, Wasabi Co.ltd
	</p>

</body>
</html>

