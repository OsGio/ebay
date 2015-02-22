<?php
	require_once("common/auth.php");
	require_once("common/db.php");
	require_once('common/SC_eBay.php');
	require_once('common/EBAY_CONS.php');
	//error_reporting(0);
	 session_start();
	DEFINE("STORE_NAME",'使える！簡単！海外販売ネットショップ 商品データ移行');
	
	$ebayusername = $_POST['ebayusername'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">

<title>使える！簡単！海外販売ネットショップ 商品データ移行｜コンバーターforWORLD</title>

<link href="/favicon.png" type="image/png" rel="icon" />
<link href="/favicon.png" type="image/png" rel="shortcut icon" />

<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/jquery-ui-timepicker-addon.css" />

<script src="http://code.jquery.com/jquery-1.11.0.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js" type="text/javascript"></script>
<script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
<script src="js/jquery.ui.datepicker-ja.js" type="text/javascript"></script>
<script src="js/cpick.js" type="text/javascript"></script>
<script src="js/jquery.easing.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/template.css">


<!-- /header -->



<div id="dataedit">
<h2>eBay認証確認</h2>
</div>

<?php


$theID = $_SESSION['ebSession'];

$ebayClass = new SC_eBay(API_DEV_NAME,API_APP_NAME,API_CERT_NAME,'',EBAY_SERVER,RU_NAME);
$token = $ebayClass->getToken($ebayusername,$theID);

// Check for existence of something that looks like a token
// Should be character string of length greater than 500 chars
// This is stronger verification of a token than simply checking for existence
$db = new dbclass();
	$sqle = "update `user_tbl` set token='".$db->esc($token)."' where username = '".$db->esc($username)."' ";
	
	$db -> Exec($sqle);
    
    $results .= "<form	name=\"form_auth\" method=\"post\" action=\"menu.php\" >";
    $results .= "認証成功！<a href='convert.php' target='_parent'>「コンバート」画面</a>からeBay登録を実行できます。";


$results .= "</form>\n";
$results .= "</DIV> \n";

print $results;


?>


<!-- /content -->

<?php
	require_once("common/auth.php");
	
	 session_start();
?>

</body>
</html>

