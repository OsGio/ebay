<?php
	require_once("common/auth.php");
	require_once("common/db.php");
	require_once('common/SC_eBay.php');
	require_once('common/EBAY_CONS.php');

	$username = $_SESSION["CONVERTER_USERID"];

	//error_reporting(0);
	 session_start();
	DEFINE("STORE_NAME",'使える！簡単！海外販売ネットショップ 商品データ移行');
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
<h2>eBay認証</h2>
</div>

<?php

$results = '';
$results .= "<DIV ALIGN=CENTER> \n";


if (isset($_POST['loginPending'])) {
    // Note we can only successfully go looking for the token after the user has
    // hit Continue - meaning it's OK to continue and look for the token
    $results .= "<form	name=\"form_auth2\" method=\"post\" action=\"VerifyToken.php\" >";
    $results .= "<table><tr>\n<td>eBay用ユーザID:</td> <td align=\"left\">"
             .  "<input	type=\"text\" name=\"ebayusername\" size=\"50\" maxlength=\"20\"></td>\n";
    $results .= "<td><INPUT TYPE=\"submit\" NAME=\"ContinueToVerifyToken\" VALUE=\"  認証確認  \">";
    $results .= "</td></tr></table>\n";
} else {
    if (@!$_SESSION['sid']) {        // @ to suppress warnings
        $_SESSION['sid'] = md5(uniqid(rand(), true));  // secret ID for FetchToken request
    }
	$ebayClass = new SC_eBay(API_DEV_NAME,API_APP_NAME,API_CERT_NAME,'',EBAY_SERVER,RU_NAME);
	$xmlResponse = $ebayClass->getAuthSessionId();

	$sesId = urlencode($_SESSION['ebSession']);
	$runame = RU_NAME;
	$loginURL = LOGIN_URL;
    $results .= "<form	name=\"form_auth\" method=\"post\" action=\"ebayAuth1.php\" >";
    // loginURL and runame in next line comes from the required keys.php file
	$results .= '<p style="text-align:center;margin:20px 0;">本サービスとebayの出品APIとをつなぎます。<br>認証が完了すると、ワンクリック出品がご利用いただけます。</p>';
    $results .= "<INPUT TYPE=\"image\" NAME=AUTHORIZE VALUE=\"eBayへ認証させる\" "
            .  "onclick=\"window.open('$loginURL?SignIn&runame=$runame&SessID=$sesId');\" src=\"img/btn_go_ebay.gif\">\n";
    // use hidden field to retain fact that we're waiting on outcome of Auth and Auth call
    $results .= "<input type=\"hidden\" name=\"loginPending\" value=\"true\">\n";

}

$results .= "</form>\n";
$results .= "</DIV> \n";

print $results;

?>

<?php
	require_once("common/auth.php");
	
	 session_start();
?>

</body>
</html>

