<?php include('header.php'); 
	$username = $_SESSION["CONVERTER_USERID"];

//楽天CSV取込み
$db = new dbclass();
	$sql = "select * from `ebay_result_tbl` where username = '".$db->esc($username)."'";
	
	$rc = $db -> Exec($sql);
    // 変換
    include ('common/upload_ebay_img.php'); 
	require_once('common/SC_eBay.php');
	require_once('common/EBAY_CONS.php');
    $errorMsg = "";
    $new_id = 0;
    $new_log_id = 0;
    $success_cnt = 0;
	$ebayClass = new SC_eBay(API_DEV_NAME,API_APP_NAME,API_CERT_NAME,AUTH_TOKEN,EBAY_SERVER);
	while ($obj = $db -> fetch_object($rc)) {

		$itemID=$obj -> item_id;
		$xmlResponse = $ebayClass->endItem($itemID);
		// Verify that the xml response object was created
		$ebay_msg="";
		if ($xmlResponse) {
			// Check for call success
			if ($xmlResponse->Ack == "Success" || $xmlResponse->Ack == "Warning") {
				echo "Successssssssssssssssssssssss!" ;
			}else{
				echo $xmlResponse;
			}
		}
	}
		$db -> close();


?>

<!-- /header -->
<div id="bread">
	<ul>
		<li><img src="img/icon_home.gif" width="26" height="25" alt="" /></li>
		<li><a href="menu.php"><?php echo STORE_NAME;?></a> > <span>メインメニュー</span></li>
	</ul>
</div>
<!-- /bread -->

	<!-- /mainCol -->
<?php include('left.php'); ?>

	<!-- /leftCol -->


<!-- /content -->


<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
