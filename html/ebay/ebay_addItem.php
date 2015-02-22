#!/usr/local/bin/php
<?php
require_once(dirname(__FILE__)."/common/db.php");
require_once(dirname(__FILE__)."/common/SC_eBay.php");
require_once(dirname(__FILE__)."/common/EBAY_CONS.php");
//error_reporting(0);

DEFINE("STORE_NAME",'アイテムコンバーター');


$db = new dbclass();
$username = $argv[1];
//ログID
$new_log_id = 0;
//ログ内容
$logs = array();

	$uploaddir = 'csv/';
	$uploadfile = $uploaddir .$username."_". $_FILES['item']['name'];

	
	//item specificsを取得
	$sql = "select * from  `ebay_item_specifics`";	
	$rc = $db -> Exec($sql);
	$item_specifics = array();
	$csv_header_item_specifics = '';
	while($obj = $db -> fetch_object($rc)) {
		$item_specifics[] =  $obj->name;
		$csv_header_item_specifics .= ',C:'.$obj->name;
	}
	
	//そのユーザーのitem specificsのデフォルト設定を取得
	$sql = "SELECT item_specifics_default FROM  setting_tbl WHERE username = '".$db->esc($username)."' ";	
	$rc = $db -> Exec($sql);
	$obj = $db -> fetch_object($rc);	
	$item_specifics_default = unserialize($obj->item_specifics_default);
	
	
	$sql = "SELECT ebay_result_tbl.*, ebay_mst.item_specifics FROM ebay_result_tbl LEFT JOIN ebay_mst ON ebay_result_tbl.category = ebay_mst.catetory_id WHERE ebay_result_tbl.username = '".$db->esc($username)."' ";
	$rc = $db -> Exec($sql);
	
    // 変換
    $errorMsg = "";
    $new_id = 0;
    $success_cnt = 0;
		
    //token取得
	$sqle = "select * from `user_tbl` where username = '".$db->esc($username)."' ";
	$token = '';
	$rce = $db -> Exec($sqle);
	if ($obj = $db -> fetch_object($rce)) {
		$token = $obj -> token;
	}
	$ebayClass = new SC_eBay(API_DEV_NAME,API_APP_NAME,API_CERT_NAME,$token,EBAY_SERVER,RU_NAME);
	$sql = "delete from `log_tbl` where username = '".$db->esc($username)."'";
	$db -> Exec($sql);
	while ($obj = $db -> fetch_object($rc)) {
		$new_id++;
		if(!isset($obj -> category) || $obj -> category == "") {
			continue;
		}
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
		$product['Format'] = $obj->Format;
		if (is_numeric($obj -> Duration)) {
			$product['Duration'] = "Days_" . $obj -> Duration;
		} else {
			$product['Duration'] = $obj -> Duration;
		}
var_dump($product['Duration']);
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
		

		$category_item_specificses = explode('|', $obj->item_specifics);
var_dump($category_item_specificses);
var_dump($item_specifics);
		foreach ($item_specifics as $value) {
			
			if (array_search($value, $category_item_specificses) !== false) {
			
				switch ($value) {
					case 'Size Type':
						if ($item_specifics_default[$value]) {
							$product['C:'.$value] = $item_specifics_default[$value];
						} else {
							$product['C:'.$value] = 'regular';
						}
						break;

					case 'Brand':
						if ($item_specifics_default[$value]) {
							$product['C:'.$value] = $item_specifics_default[$value];
						} else {
							$product['C:'.$value] = 'see title.';
						}
						break;

					default :
						if ($item_specifics_default[$value]) {
							$product['C:'.$value] = $item_specifics_default[$value];
						} else {
							$product['C:'.$value] = 'see description.';
						}
				}
			}
		}

		$product['C:Country of Manufacture'] = $obj -> C_Country_Manufacture;
var_dump($product);
		$itemID="";
		// Convert the xml response string in an xml object
		$xmlResponse = false;
		$xmlResponse = $ebayClass->addItem($product, $item_specifics);
var_dump($xmlResponse);
		// Verify that the xml response object was created

		$ebay_msg="";
		if ($xmlResponse) {
			// Check for call success
			if ($xmlResponse->Ack == "Success" || $xmlResponse->Ack == "Warning") {
				$itemID= $xmlResponse->ItemID ;
			}else{
				$ebay_msg=$xmlResponse->Errors->ShortMessage.'/'.$xmlResponse->Errors->LongMessage;
			}
		}
		if($itemID=="") { 
			$new_log_id++;
			//ログ記録
			$column=$obj -> column_name;
			$msg = '商品番号'.$obj->custom_label.'の商品アップロードに失敗しました';
			if($ebay_msg <> ""){
				$msg = $msg.'。原因：'.$ebay_msg;
			}
			$logs[] = "('".$db->esc($username)."',".$db->esc($new_log_id).", 2, '".$db->esc($msg)."','".$db->esc($column)."')";
			$errorMsg = $errorMsg."\n".$msg;
			
		}else{
			$success_cnt++;
			$ebayUploadedImages = array();
			foreach ($images as $image) {
				if ($image) {
					$tmp_image_url = $ebayClass->getEbayImageURL($image);
					if ($tmp_image_url) {
						$ebayUploadedImages[] = $tmp_image_url;
					}
				}
			}
			$ebayClass->uploadEbayImageURL($ebayUploadedImages, $itemID);

			$id=$obj -> id;
			$sql = "update ebay_result_tbl set
			Pic_URL = '".$db->esc($ebayUploadedImages[0])."' ,item_id = '".$db->esc($itemID)."' where  username = '".$db->esc($username)."' and id='".$db->esc($id)."'";
			$rc2 = $db -> Exec($sql);
			if(!rc2) {
				$message = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $sql;
				die($message);
			}
		}
	}


	$email = $username;
	if($username == ADMIN){
		$email = ADMIN_EMAIL;
	}
	$db -> senddone2($username, strval($success_cnt), $email, $errorMsg);
	
	//完了ログ
	$new_log_id++;
	$logs[] = "('".$db->esc($username)."',".$db->esc($new_log_id).", 5, 'eBayへのアップロードが完了しました。','')";
	
	//ログをまとめてDBに保存
	$sql = "insert into log_tbl (username, log_id, msg_flg, msg, column_name) values ". implode(',', $logs);
	$rc3 = $db -> Exec($sql);
	if(!rc3) {
		$message = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $sql;
		die($message);
	}
	
	$db -> close();

?>
