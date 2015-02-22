<?
session_start();

// ログイン状態のチェック
$username = $_SESSION["CONVERTER_USERID"];
if (!isset($username)) {
	header("Location: https://".$_SERVER["HTTP_HOST"]."/ebay/login.php?logout=1");
	exit;
}

//SSL接続でない場合はリダイレクト
if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'http') {
	header("Location: https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
	exit;
}
?>
