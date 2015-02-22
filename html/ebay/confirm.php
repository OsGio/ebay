<?php
	
  	require_once("common/db.php");
	require_once("common/SC_transAPI.php");
	
	$db = new dbclass();
	

  // エラーメッセージ
  $errorMessage = "";

  // ログインボタンが押された場合      
  if (isset($_GET["flg"])) {
  	$auth = $_GET["flg"];
  	
  	//既に存在するかチェック
	$sql = "select * from  `user_tbl` where activate_str = '".$db->esc($auth)."' and registered_flg = 0 ";
	$rc = $db -> Exec($sql);
	$username = "";
	
	if($db -> NumRows($rc) <= 0) {
		
		$err =  "無効なURLです。";
 		header("Location: login.php?errorMsg=".$err);
		
	} else {
		
		$row = $db -> Fetch_Object($rc);
		$username = $row -> username;
				
		//適当なパスワード生成
		$password = substr(md5($username.time()), 0, 12);
		
		//翻訳APIインスタンス生成
		$trans = new SC_transAPI('203916a788aa313171d9c22e85b82cf9');

		//翻訳API代表者登録
		$res = $trans->regist($username, $password, $username, $username);

		if ($res) {
			
			if ($res->code == 200) {
				
				//認証できたこととAPIキーを保存
				$sql = "UPDATE  `user_tbl` SET trans_api_key = '".$db->esc($res->data->api_key)."', trans_api_secret_key = '".$db->esc($res->data->api_secret)."', activate_str = '', registered_flg = 1  WHERE activate_str = '".$db->esc($auth)."' AND registered_flg = 0 ";
				$db -> Exec($sql);	
				
				//完了メールを送信
				$db -> sendmail($username,2,"");
				$db -> senddone3($username);				
				
			} else {
				
				//既に翻訳APIに登録済みのメアドだった場合、発行済みのAPIキーを取得
				if ($res->code == 2003) {
					
					$res2 = $trans->get_keys($username);

					if ($res2) {

						if ($res2->code == 200) {

							//認証できたこととAPIキーを保存
							$sql = "UPDATE  `user_tbl` SET trans_api_key = '".$db->esc($res2->data->api_key)."', trans_api_secret_key = '".$db->esc($res2->data->api_secret)."', activate_str = '', registered_flg = 1  WHERE activate_str = '".$db->esc($auth)."' AND registered_flg = 0 ";
							$db -> Exec($sql);	

							//完了メールを送信
							$db -> sendmail($username,2,"");
							$db -> senddone3($username);				

						} else {
							//取得失敗
							header("Location: login.php?errorMsg=".$res2->message);
						}

					} else {
						//登録失敗
						$err =  "登録に失敗しました。";
						header("Location: login.php?errorMsg=".$err);
					}					
					
				} else {
					//登録失敗
					header("Location: login.php?errorMsg=".$res->message);
				}
			}
			
		} else {
			//登録失敗
			$err =  "登録に失敗しました。";
			header("Location: login.php?errorMsg=".$err);
		}
	}
	
  } else {
		$err =  "無効なURLです。";
 		header("Location: login.php?errorMsg=".$err);
  }
	
	$db -> close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<title>
		アイテムコンバーター	</title>
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
	ご登録情報の確認が完了いたしました。<br>
	ご登録ありがとうございました。<br>
	<br>
	<a class="toLogin" href="login.php">ログイン画面へ</a>
	</div>
</div>

<h2><a href="https://www.facebook.com/wasab.inc" target="_blank">Copyright, Wasabi Co.ltd</a>
　
<p id="copy">Copyright, Wasabi Co.ltd</p>

</body>
</html>

