<?php
	//SSL接続でない場合はリダイレクト
/*
	if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'http') {
		header("Location: https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
		exit;
	}
*/
	require_once("common/db.php");

	 session_start();

	// ログインボタンが押された場合
	$hasLoginErr = false;
	if (isset($_POST["login"])) {
		$username = $_POST["userid"];
		$password = $_POST["password"];
		$db = new dbclass();

		//既に存在するかチェック
		$sql = "select * from  `user_tbl` where username = '".$db->esc($username)."' and password = '".$db->esc($password)."'  and registered_flg = '1'";

		$rc = $db -> Exec($sql);
	// 認証成功
		if($db -> NumRows($rc) > 0) {
			// セッションIDを新規に発行する
			session_regenerate_id(TRUE);
			$_SESSION["CONVERTER_USERID"] = $_POST["userid"];
			//ログイン日時を保存
			$db -> Exec("UPDATE user_tbl SET last_login = '".date('Y-m-d H:i:s')."' WHERE username = '".$db->esc($username)."'");
			$db -> close();
			header("Location: top.php");
			exit;
		}
		else {
			$hasLoginErr = true;
			$err = "正しいアカウントIDとパスワードを入力してください。";
		}
	} else {
		session_destroy();
		// セッションIDを新規に発行する
		session_regenerate_id(TRUE);
		if(isset($_GET["errorMsg"])) {
			$hasLoginErr = true;
			$err = $_GET["errorMsg"];
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>海外ネットショップへの移行・変換なら、ebay対応の【海外販売ネットショップ商品データ移行】|ログイン</title>
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

<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-34847294-10', 'auto');
	ga('send', 'pageview');

</script>

</head>

<body id="loginBg">


<div id="login" style="color:black">
	<h1>
	<img src="img/logo02.gif" alt="" />
	</h1>
	<form action="login.php" id="UserLoginForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/>
	</div>
	<dl>
			<dt>アカウントID：</dt>
			<dd><input name="userid" value="<?php echo $_POST["userid"];?>" size="10" type="text" id="UserUsername"/></dd>
			<dt>パスワード：</dt><dd><input name="password" value="" size="10" type="password" id="UserPassword"/></dd>
		</dl>
		<?php
		if($hasLoginErr === true) {
		?>
		<div id="flashMessage" class="message"><?php echo_h($err); ?></div>
		<?php
		}
		 ?>
		<input type="submit" class="submit" value="" id="loginbtn" name="login" style="webkit-box-shadow:none;box-shadow:none;">
		<p><a href="forgot.php">パスワードを忘れた方はこちら</a></p>
		<div style="float:right;"><a href="register.php">新規アカウント登録はこちら</a></div>
		<div style="width:100%;text-align:center;color:#444;"><p>対応ブラウザ：Google Chrome / Internet Explorer10</p></div>
</div>


<p id="copy">Copyright, Wasabi Co.ltd</p>
</body>
</html>
