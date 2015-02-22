<?php include('header.php'); 
	$username = $_SESSION["CONVERTER_USERID"];
	$uploaddir = 'csv/';
	$uploadfile = $uploaddir .$username."_". $_FILES['item']['name'];
	function transferIframe($desc){
		$patterns[0] = '/<iframe src/';
		$patterns[1] = '/<\/iframe>/';		
		$replacements[0] = '<object data';
		$replacements[1] = '<\/object>';		
		$desc = preg_replace($patterns, $replacements,$desc);
		return $desc;
	}
//楽天CSV取込み
$db = new dbclass();
if (isset($_GET["exec"]) && $_GET["exec"] == "1") {
	if($_FILES['item']['name'] <> "") {


		if (move_uploaded_file($_FILES['item']['tmp_name'], $uploadfile)) {
		    insert_data($db,realpath($uploadfile));
			insert_rk_dir($db);		//未登録の楽天ディレクトリIDをあらかじめInsert
		} else {
		    echo "ファイルアップロード失敗した!\n";
		}
	}
}elseif (isset($_GET["exec"]) && $_GET["exec"] == "2") {
	//変換
	$sql = "select * from  `setting_tbl` where username = '".$db->esc($username)."'";
	
	$rc1 = $db -> Exec($sql);
	$PayPal_Accepted = 1;
	$PayPal_Email_Address = "";
	$location = "";
	$Dispatch_Time_Max = 3;
	$Returns_Accepted_Option = "ReturnsAccepted";
	$format = "FixedPrice";
	if ($obj1 = $db -> fetch_object($rc1)) {
		$PayPal_Accepted = $obj1 -> use_paypal;
		$PayPal_Email_Address =  $obj1 -> paypal_mail;
		$location = $obj1 -> location;
		$Dispatch_Time_Max = $obj1 -> max_dispatch_time;
		$Returns_Accepted_Option = $obj1 -> return_accept;
		$format = $obj1 -> format;
	}
	$sql = "delete from  `log_tbl` where username = '".$db->esc($username)."'";
	
	$rc = $db -> Exec($sql);
	if(!rc) {
		$message = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $sql;
		die($message);
	}
	
	$sql = "delete from  `ebay_result_tbl` where username = '".$db->esc($username)."'";
	
	$rc = $db -> Exec($sql);
	if(!rc) {
		$message = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $sql;
		die($message);
	}

	$sql = "select * from  `rakuten_item_tbl` where username = '".$db->esc($username)."'";
	
	$rc = $db -> Exec($sql);
    // 変換
    $new_id = 1;
    $new_log_id = 1;
    require_once ('common/modifier.trans2en_ver2.php'); 
    require_once ('common/modifier.trans2en.php'); 
    $errorMsg = "";
    
    $rate="100";
    $action="Add";
	$Condition_ID="3000";
	$Format="FixedPrice";
	$Duration="10";
	$Quantity="1";
	$PayPal_Accepted="1";
	$PayPal_Email_Address="";
	$Immediate_Pay_Required="";
	$Payment_Instructions="";
	$Location="Kyoto";
	$Shipping_Service1_Option="ExpeditedShippingFromOutsideUS";
	$Shipping_Service1_Cost="0";
	$Dispatch_Time_Max="3";
	$Returns_Accepted_Option="ReturnsAccepted";
	$Returns_Within_Option="Days_14";
	$Refund_Option="MoneyBack";
	$Shipping_Cost_Paid_By="Buyer";
	$Return_Detail="";
	$Restocking_Fee_Value_Option="NoRestockingFee";
	$Intl_Shipping_Service1_Additional_Cost="0";
	$Intl_Shipping_Service1_Option="ExpeditedInternational";
	$Intl_Shipping_Service1_Cost="0";
	$Intl_Shipping_Service1_Locations="Worldwide";
	$Intl_Shipping_Service1_Priority="1";
	$postage  = 0;

	$sql_set = "select * from  `setting_tbl` where username = '".$db->esc($username)."' ";

	$rcset = $db -> Exec($sql_set);

	if($db -> NumRows($rcset) > 0) {
		$objset = $db -> fetch_object($rcset);
		
		$rate=$objset -> rate;
		$action=$objset -> action;
		$Condition_ID=$objset -> Condition_ID;
		$Format=$objset -> Format;
		$Duration=$objset -> Duration;
		$Quantity=$objset -> Quantity;
		$PayPal_Accepted=$objset -> PayPal_Accepted;
		$PayPal_Email_Address=$objset -> PayPal_Email_Address;
		$Immediate_Pay_Required=$objset -> Immediate_Pay_Required;
		$Payment_Instructions=$objset -> Payment_Instructions;
		$Location=$objset -> Location;
		$Shipping_Service1_Option=$objset -> Shipping_Service1_Option;
		$Shipping_Service1_Cost=$objset -> Shipping_Service1_Cost;
		$Dispatch_Time_Max=$objset -> Dispatch_Time_Max;
		$Returns_Accepted_Option=$objset -> Returns_Accepted_Option;
		$Returns_Within_Option=$objset -> Returns_Within_Option;
		$Refund_Option=$objset -> Refund_Option;
		$Shipping_Cost_Paid_By=$objset -> Shipping_Cost_Paid_By;
		$Return_Detail=$objset -> Return_Detail;
		$Restocking_Fee_Value_Option=$objset -> Restocking_Fee_Value_Option;
		$Intl_Shipping_Service1_Additional_Cost=$objset -> Intl_Shipping_Service1_Additional_Cost;
		$Intl_Shipping_Service1_Option=$objset -> Intl_Shipping_Service1_Option;
		$Intl_Shipping_Service1_Cost=$objset -> Intl_Shipping_Service1_Cost;
		$Intl_Shipping_Service1_Locations=$objset -> Intl_Shipping_Service1_Locations;
		$Intl_Shipping_Service1_Priority=$objset -> Intl_Shipping_Service1_Priority;
		$postage  = $objset -> postage;
	}
	while ($obj = $db -> fetch_object($rc)) {
		$category = changeCat($db,$obj -> directory_id);
			$new_username = $userid;
			$id = $new_id++;
			$custom_label = $obj -> product_no;
			$Store_Category = "";
			$Title = '';
			$Title = translateText($obj -> product_name);
			$Title = str_replace("'","''",$Title);
			$Pic_URL = $obj -> img_url;
			$Description = 'item Description';
			$Description = smarty_modifier_trans2en($obj -> pc_promote);
			$Description = transferIframe($Description);
			$intrate = intval($rate);
			if($intrate != 0) {
				$Start_Price = intval($obj -> sell_price) / $intrate;
			}else{
				$Start_Price = $obj -> sell_price;
			}
			$Start_Price = $Start_Price + $postage;
			$C_Brand = "";
			$C_Style = "";
			$C_Material = "";
			$C_Color = "";
			$C_Size = "";
			$C_Country_Manufacture = "";
			
			$sql2 = "select * from  `condition_mst` where tag_id = substr('".$obj -> tag_id."',9,15)";
			
			$rcc = $db -> Exec($sql2);
			if ($objc = $db -> fetch_object($rcc)) {
				$Condition_Description = $objc -> condition_des;
				$Condition_ID = $objc -> ebay_condition_id;
			}else{
				$Condition_Description = "New : Never Used / Unused.";
				$Condition_ID = '1000';
			}
						
			$sql = "insert into ebay_result_tbl (
			username,
			id,
			action,
			custom_label,
			category,
			Store_Category,
			Title,
			Condition_ID,
			Pic_URL,
			Description,
			Format,
			Duration,
			Start_Price,
			Quantity,
			PayPal_Accepted,
			PayPal_Email_Address,
			Immediate_Pay_Required,
			Payment_Instructions,
			Location,
			Shipping_Service1_Option,
			Shipping_Service1_Cost,
			Shipping_Service2_Option,
			Shipping_Service2_Cost,
			Dispatch_Time_Max,
			Promotional_Shipping_Discount,
			Shipping_Discount_ProfileID,
			Domestic_Rate_Table,
			Returns_Accepted_Option,
			Returns_Within_Option,
			Refund_Option,
			Shipping_Cost_Paid_By,
			Additional_Details,
			Restocking_Fee_Value_Option,
			Use_Tax_Table,
			Intl_Shipping_Service1_Additional_Cost,
			Intl_Shipping_Service1_Option,
			Intl_Shipping_Service1_Cost,
			Intl_Shipping_Service1_Locations,
			Intl_Shipping_Service1_Priority,
			C_Brand,
			C_Style,
			C_Material,
			C_Color,
			C_Size,
			C_Country_Manufacture,
			Condition_Description) values( 
			'".$db->esc($username)."',
			".$db->esc($id).",
			'".$db->esc($action)."',
			'".$db->esc($custom_label)."',
			'".$db->esc($category)."',
			'".$db->esc($Store_Category)."',
			'".$db->esc($Title)."',
			'".$db->esc($Condition_ID)."',
			'".$db->esc($Pic_URL)."',
			'".$db->esc($Description)."',
			'".$db->esc($Format)."',
			'".$db->esc($Duration)."',
			'".$db->esc($Start_Price)."',
			'".$db->esc($Quantity)."',
			'".$db->esc($PayPal_Accepted)."',
			'".$db->esc($PayPal_Email_Address)."',
			'".$db->esc($Immediate_Pay_Required)."',
			'".$db->esc($Payment_Instructions)."',
			'".$db->esc($Location)."',
			'".$db->esc($Shipping_Service1_Option)."',
			'".$db->esc($Shipping_Service1_Cost)."',
			'".$db->esc($Shipping_Service2_Option)."',
			'".$db->esc($Shipping_Service2_Cost)."',
			'".$db->esc($Dispatch_Time_Max)."',
			'".$db->esc($Promotional_Shipping_Discount)."',
			'".$db->esc($Shipping_Discount_ProfileID)."',
			'".$db->esc($Domestic_Rate_Table)."',
			'".$db->esc($Returns_Accepted_Option)."',
			'".$db->esc($Returns_Within_Option)."',
			'".$db->esc($Refund_Option)."',
			'".$db->esc($Shipping_Cost_Paid_By)."',
			'".$db->esc($Return_Detail)."',
			'".$db->esc($Restocking_Fee_Value_Option)."',
			'".$db->esc($Use_Tax_Table)."',
			'".$db->esc($Intl_Shipping_Service1_Additional_Cost)."',
			'".$db->esc($Intl_Shipping_Service1_Option)."',
			'".$db->esc($Intl_Shipping_Service1_Cost)."',
			'".$db->esc($Intl_Shipping_Service1_Locations)."',
			'".$db->esc($Intl_Shipping_Service1_Priority)."',
			'".$db->esc($C_Brand)."',
			'".$db->esc($C_Style)."',
			'".$db->esc($C_Material)."',
			'".$db->esc($C_Color)."',
			'".$db->esc($C_Size)."',
			'".$db->esc($C_Country_Manufacture)."',
			'".$db->esc($Condition_Description)."'
			) ";
			$rc2 = $db -> Exec($sql);
			if(!rc2) {
				$message = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $sql;
				die($message);
			}
		if($category == "") {
			//ログ記録
			$column=$obj -> column_name;
			$sql = "insert into log_tbl (
			username,
			log_id,
			msg_flg,
			msg,
			column_name)
			values(
			'".$db->esc($username)."',
			".$db->esc($new_log_id).",
			4,
			'楽天ディレクトリID".$obj -> directory_id."とeBayCategoreIDが紐づいていない',
			'".$db->esc($column)."')";
			$rc3 = $db -> Exec($sql);
			if(!rc3) {
				$message = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $sql;
				die($message);
			}
			$errorMsg = $errorMsg."<br>楽天ディレクトリID".$obj -> directory_id."がeBayカテゴリIDと紐づいていません。";
			$new_log_id++;
		}
	}
	$all = $new_id + $new_log_id -2;
	$new_id=$new_id-1;
	echo "<font color='red'>".$errorMsg."</font><br>";
	echo $new_id."件中".$new_id."件のデータが正常変換しました！";
}elseif (isset($_GET["exec"]) && $_GET["exec"] == "3") {
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
    
    //token取得
	$sqle = "select * from `user_tbl` where username = '".$db->esc($username)."' ";
	$token = '';
	$rce = $db -> Exec($sqle);
	if ($obj = $db -> fetch_object($rce)) {
		$token = $obj -> token;
	}
	$ebayClass = new SC_eBay(API_DEV_NAME,API_APP_NAME,API_CERT_NAME,$token,EBAY_SERVER,RU_NAME);
	$sql = "delete from  `log_tbl` where username = '".$db->esc($username)."'";
	$db -> Exec($sql);
	while ($obj = $db -> fetch_object($rc)) {
		$new_id++;
		$Pic_URL = $obj -> Pic_URL;

		$product = array();
		$images = explode(" ",$Pic_URL);
		$product['product_name'] = $obj -> Title;
		$product['CustomLabel'] = $obj -> custom_label;
		$product['ConditionID'] = $obj -> Condition_ID;
		$product['ConditionDescription'] = $obj -> Condition_Description;
		$desc = $obj -> Description;
		$desc = preg_replace('/<iframe .*?>(.*?)<\/iframe>/','',$desc);
		$product['product_description'] = $desc;
		$product['Category'] = $obj -> category;
		$product['Location'] = $obj -> Location;
		$product['Quantity'] = $obj -> Quantity;
		$product['StartPrice'] = $obj -> Start_Price;
		$product['Duration'] = "Days_" . $obj -> Duration;
		$product['DispatchTimeMax'] = $obj -> Dispatch_Time_Max;
		$product['ShippingService-1:Option'] = $obj -> Shipping_Service1_Option;
		$product['ShippingService-1:Cost'] = $obj -> Shipping_Service1_Cost;
		$product['ShippingDiscountProfileID'] = $obj -> Shipping_Discount_ProfileID;
		$product['IntlShippingService-1:Cost'] = $obj -> Intl_Shipping_Service1_Additional_Cost;
		$product['IntlShippingService-1:Option'] = $obj -> Intl_Shipping_Service1_Option;
		$product['IntlShippingService-1:Priority'] = $obj -> Intl_Shipping_Service1_Priority;
		$product['IntlShippingService-1:Locations'] = $obj -> Intl_Shipping_Service1_Locations;
		$product['ReturnsAcceptedOption'] = $obj -> Returns_Accepted_Option;
		$product['RefundOption'] = $obj -> Refund_Option;
		$product['ReturnsWithinOption'] = $obj -> Returns_Within_Option;
		$product['ShippingCostPaidBy'] = $obj -> Shipping_Cost_Paid_By;
		$product['AdditionalDetails'] = $obj -> Additional_Details;
		//$product['AdditionalDetails'] = 'additional description';
		$product['RestockingFeeValueOption'] = $obj -> Restocking_Fee_Value_Option;
		$product['PayPalEmailAddress'] = $obj -> PayPal_Email_Address;
		$product['PictureURL'] = $images[0];
		$product['C:Brand'] = $obj -> C_Brand;
		$product['C:Style'] = $obj -> C_Style;
		$product['C:Material'] = $obj -> C_Material;
		$product['C:Color'] = $obj -> C_Color;
		$product['C:Size'] = $obj -> C_Size;
		$product['C:Country of Manufacture'] = $obj -> C_Country_Manufacture;

		$itemID="";
		// Convert the xml response string in an xml object
		$xmlResponse = false;
		$xmlResponse = $ebayClass->addItem($product);
		// Verify that the xml response object was created
		$ebay_msg="";
		if ($xmlResponse) {
			// Check for call success
			if ($xmlResponse->Ack == "Success" || $xmlResponse->Ack == "Warning") {
				$itemID= $xmlResponse->ItemID ;
			}else{
				$ebay_msg=$xmlResponse->Errors->ShortMessage;
			}
		}
		if($itemID=="") { 
			$new_log_id++;
			//ログ記録
			$column=$obj -> column_name;
			$msg = 'eBayカテゴリID'.$obj -> category.'は商品画像アップロードする時失敗した';
			if($ebay_msg <> ""){
				$msg = $msg.'。原因：'.$ebay_msg;
			}
			$sql = "insert into log_tbl (
			username,
			log_id,
			msg_flg,
			msg,
			column_name)
			values(
			'".$db->esc($username)."',
			".$db->esc($new_log_id).",
			2,
			'".$db->esc($msg)."',
			'".$db->esc($column)."')";
			$rc3 = $db -> Exec($sql);
			if(!rc3) {
				$message = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $sql;
				die($message);
			}
			$errorMsg = $errorMsg."<br>".$msg;
		}else{
			$success_cnt++;
			$Pic_URL = getEbayImg($Pic_URL,$itemID);
			$id=$obj -> id;
			$sql = "update ebay_result_tbl set
			Pic_URL = '".$db->esc($Pic_URL)."' ,item_id = '".$db->esc($itemID)."' where  username = '".$db->esc($username)."' and id='".$db->esc($id)."'";
			$rc2 = $db -> Exec($sql);
			if(!rc2) {
				$message = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $sql;
				die($message);
			}
		}
	}
	echo "<font color='red'>".$errorMsg."</font><br>";
	echo $new_id."件中".$success_cnt."件のデータが正常にeBayへ登録しました！";
}
		$db -> close();
function changeCat($db,$rk_dir_id) {
	$userid = $_SESSION["CONVERTER_USERID"];
	$sql = "select * from  `change_mst_tbl` where username = '".$db->esc($userid)."' and rk_dir_id = '".$db->esc($rk_dir_id)."' ";
	
	$rc = $db -> Exec($sql);
	
	if($obj = $db -> fetch_object($rc)) {
		return $obj -> ebay_cat_id;
	}else{
		return "";
	}

}

function insert_data($db,$uploadfile) {

//$uploadfile="E:/develop/wasabi/ebay/rakuten_item.csv";

	$username = $_SESSION["CONVERTER_USERID"];
	//既存データ削除
	$sql = "delete from rakuten_item_tbl where username='$username'"; 
	$db -> Exec($sql);
	$db -> Exec("set character_set_database=sjis");

	//最新取込み
	$doubleQ = '"';
		$sql = "LOAD DATA LOCAL INFILE '$uploadfile' REPLACE 
INTO TABLE rakuten_item_tbl
FIELDS TERMINATED BY ',' ENCLOSED BY '".$doubleQ."'
 LINES TERMINATED BY '\r\n' 
 IGNORE 1 LINES (@column_name,
@product_url,
@product_no,
@directory_id,
@tag_id,
@pc_tag_line,
@mobile_tag_line,
@product_name,
@sell_price,
@show_price,
@tax,
@postage,
@warehouse,
@layout,
@pc_introduce,
@mobile_introduce,
@sp_introduce,
@pc_promote,
@img_url,
@img_name,
@sell_duration,
@stock_type,
@stock_quantity,
@header,
@order_name,
@small_introduce,
@loss_leader,
@big_introduce,
@review,
@foreign_no)
SET  username='".$db->esc($username)."',
column_name=@column_name,
product_url=@product_url,
product_no=@product_no,
directory_id=@directory_id,
tag_id=@tag_id,
pc_tag_line=@pc_tag_line,
mobile_tag_line=@mobile_tag_line,
product_name=@product_name,
sell_price=@sell_price,
show_price=@show_price,
tax=@tax,
postage=@postage,
warehouse=@warehouse,
layout=@layout,
pc_introduce=@pc_introduce,
mobile_introduce=@mobile_introduce,
sp_introduce=@sp_introduce,
pc_promote=@pc_promote,
img_url=@img_url,
img_name=@img_name,
sell_duration=@sell_duration,
stock_type=@stock_type,
stock_quantity=@stock_quantity,
header=@header,
order_name=@order_name,
small_introduce=@small_introduce,
loss_leader=@loss_leader,
big_introduce=@big_introduce,
review=@review,
foreign_no=@foreign_no";
	
		$result = $db -> Exec($sql);
		if (!$result) {
$message = 'Invalid query: ' . mysql_error() . "\n";
$message .= 'Whole query: ' . $sql;
die($message);
}else{
	echo "データ取込成功！";
}

//		$db -> close();

	}


//未登録のディレクトリIDをeBayカテゴリIDを空欄のまま登録
function insert_rk_dir($db) {

	$username = $_SESSION["CONVERTER_USERID"];
	
	//登録済みのディレクトリIDの対応表を取得
	$sql = "SELECT rakuten_item_tbl.directory_id, change_mst_tbl.rk_dir_id, change_mst_tbl.ebay_cat_id FROM rakuten_item_tbl LEFT JOIN change_mst_tbl ON rakuten_item_tbl.directory_id = change_mst_tbl.rk_dir_id AND change_mst_tbl.username = '".$db->esc($username)."' WHERE rakuten_item_tbl.username = '".$db->esc($username)."'"; 
	$rc = $db -> Exec($sql);
	
	$insert_array = array();
	while ($obj = $db -> fetch_object($rc)) {
		if (!$obj->rk_dir_id) {
			$insert_array[] = "('$username', '$obj->directory_id', '')";
		}
	}
	
	//未登録のディレクトリIDをeBayカテゴリIDを空欄のまま登録
	if (count($insert_array)) {
		$sql = 'INSERT INTO change_mst_tbl (username, rk_dir_id, ebay_cat_id) VALUES '.implode(',', $insert_array);
		$db->Exec($sql);
	}
}
?>

<script type="text/javascript">
  $(function(){
    $(".menu").click(function(){
      var action = $(this).attr('data-action');
      var url = "/mypage/" + action;
      location.href = url;
    });
  });
  
  function importcsv(){
  	if(document.frm.item.value == "") {
  		alert("商品ファイルを選択してください");
  		document.frm.item.focus();
 		return;
  	}
  	document.frm.action = "menu.php?exec=1";
  	document.frm.submit();
  }
  function doChange(){
  	if(confirm("実行してよろしいですか？")) {
	  	document.frm.action = "menu.php?exec=2";
	  	document.frm.submit();
  	}
  }
    function doDl(){
  	if(confirm("CSVをダウンロードしますか？")) {
	  	document.frm.action = "csv.php";
	  	document.frm.submit();
  	}
  }
  function doAuth(){
	  	document.frm.action = "ebayAuth1.php";
	  	document.frm.submit();
  }
  function doUp(){
  	if(confirm("実行してよろしいですか？")) {
	  	document.frm.action = "menu.php?exec=3";
	  	document.frm.submit();
  	}
  }

</script>
<!-- /header -->
<div id="bread">
	<ul>
		<li><img src="img/icon_home.gif" width="26" height="25" alt="" /></li>
		<li><a href="menu.php"><?php echo STORE_NAME;?></a> > <span>メインメニュー</span></li>
	</ul>
</div>
<!-- /bread -->

<div id="content">

    <div class="mainCol" id="dataImport">



<h2>メインメニュー</h2>

<div><p><div id="flashMessage" class="message">１.から順番に実行してください。</div></p></div>

<form action="menu.php" name="frm" onsubmit="return confirm(&quot;実行してよろしいですか？&quot;);" enctype="multipart/form-data" id="/mypage/indexIndexForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>
<table>
	<tr>
		<th>1.　環境設定</th>
		<td colspan="2">
					<a href="setting.php">
			<img src="img/btn_config.jpg"  alt="" />
			</a>
				</td>
	</tr>
	<tr>
		<th class="lineNone">2.　楽天データ取込</th>
		<td colspan="2"><p><!-- 以下の３種類のファイルを同時に取り込んでください。<br> -->
		データ取込には時間がかかる場合がありますが、画面を閉じずにお待ちください。</p></td>
	</tr>
	<tr>
		<th  class="lineNone"></th>
		<td><span>商品ファイル&nbsp;&nbsp;<p>dl-itemxxxxxxxxxxxx.csv<br>固定フォーマット（詳細タイプ）</p></spna></td>
		<td><input type="file" name="item"></td>
	<tr>
	</tr>
	<tr>
		<th></th>
		<td  colspan="2">
		<a href="#" onclick="javascript:importcsv();"><img border=0 src="img/btn_data_in.jpg"></a>&nbsp;<a href="data.php">  取込済みデータ参照  </a>
		</td>
	</tr>
	<tr>
		<th>3.　ディレクトリ紐付け設定</th>
		<td>
			<?php
			$db = new dbclass();
			$sql = "select * from `user_tbl` where username = '".$db->esc($username)."' ";
			$rc = $db -> Exec($sql);
			$isPayed = false;
			$token = '';
			if ($obj = $db -> fetch_object($rc)) {
				$payed = $obj -> payed;
				$token = $obj -> token;

				if($payed == 1){
					$isPayed = true;
				}
			}
			if(!$isPayed){
			?>
		ディレクトリ紐付け設定を利用するには<a href="applicate.php">「有償機能お申込み」</a>にてお申し込みください。
			
			<?php
			
			}else {
			?>
		<a href="directory.php">
			<img src="img/btn_dir.jpg"  alt="" />
			</a>
			<?php
			}
			
			?>

			
				</td>
		<td>
		</td>
	</tr>
	<tr>
		<th>4.　変換データ一括編集</th>
		<td colspan="2">
					<a href="edit.php">
			<img src="img/btn_edit.jpg"  alt="" />
			</a>
				</td>
	</tr>

	<tr>
		<th>5.　データ変換</th>
		<td colspan=2>

		<a href="#" onclick="doChange();">
			<img src="img/btn_data_change.jpg"  alt="" />
			</a>
			<?php
			if(!$isPayed){
			?>
			<br>
			<br>
		>>eBayへ商品を自動登録するには<a href="applicate.php">「有償機能お申込み」</a>にてお申し込みください。
			
			<?php
			
			}else {
				if (isset($token) && $token <> '') {
					
			?>
				>><input type="button" name="auth" value=" eBayへ商品登録 " onclick="doUp();"/>
				<input type="button" value=" テスト用：：eBayから登録済み商品を削除 " onclick="location.href='endItem.php'"/>
			<?php
				}else{
			?>
		>><input type="button" name="auth" value=" eBayより本アプリを認証させる " onclick="doAuth();"/>
			<?php
				}
			}
			$db -> close();
			
			?>
		</td>
	</tr>

	<tr>
		<th>6.　変換ログ参照</th>
		<td colspan="2">
					<a href="log.php">
			<img src="img/btn_log.jpg"  alt="" />
			</a>
				</td>
	</tr>

	<tr>
		<th>7.　ダウンロード</th>
							<td>
		<a href="#" onclick="doDl();">
			<img src="img/btn_data_dl.jpg"  alt="" />
			</a>
				</td><td></td>
			 
	</tr>
<!--
	<tr>
		<th rowspan="2">8.　FTP自動転送</th>
		<td  class="lineNone">
		<input type="image" src="img/btn_csv_ftp.jpg"  name="data[item_up]" disabled="disabled"/>		</td>
	</tr>
	<tr>
		<td>
		<input type="image" src="img/btn_img_get.jpg"  name="data[img_dl]" disabled="disabled"/><td><p>※有償機能<br><a href="/entry"><span style="color:#ff0000;border-bottom:dotted 3px #ff0000;">お申込みフォーム</a></span>よりお申込みください。</p></td>
		</td>
	</tr>
-->
</table>
</form>

</div>

	<!-- /mainCol -->
<?php include('left.php'); ?>

	<!-- /leftCol -->
</div>


<!-- /content -->


<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
