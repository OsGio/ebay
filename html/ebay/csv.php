<?php
ini_set('display_errors', 0);
	// header('Cache-Control: public');
	// header('Pragma: public');
	// header("Content-Type: application/octet-stream");
	// date_default_timezone_set('Asia/Tokyo');
	// header("Content-Disposition: attachment; filename=ebay_items".date('YmdHis').".csv");
//fortest	require_once("common/auth.php");
	require_once("common/db.php");

	 session_start();
	$db = new dbclass();

	$username = 'misaki@wasab.net'; //test

//var_dump($db->esc($username));exit;
	//item specificsを取得
	$sql = "select * from  `ebay_item_specifics`";
	$rc = $db -> Exec($sql);
	$item_specifics = array();
	$csv_header_item_specifics = '';
	while($obj = $db -> fetch_object($rc)) {
		$item_specifics[] = $obj->name;
		$csv_header_item_specifics .= ',C:'.$obj->name;
	}


	// ADD: sku_itemsを取得
	$sql = "SELECT sku_items.*, ebay_result_tbl.custom_label from sku_items LEFT JOIN ebay_result_tbl ON sku_items.item_url = ebay_result_tbl.custom_label WHERE sku_items.master_flg = '1' AND ebay_result_tbl.username = '".$db->esc($username)."'";
	$rc = $db -> Exec($sql);
	$sku_key = array();
	//$sku = array();
	while($obj = $db -> fetch_object($rc)){
	$sku_key[] = $obj->item_url;

	// $sku = "\"". $obj->item_url ."\",";
	// $sku = $sku ."\"". $obj->action ."\",";
	// $sku = $sku ."\"". $obj->relationship ."\",";
	// $sku = $sku ."\"". $obj->relationship_details ."\",";
	// $sku = $sku ."\"". $obj->quantity ."\",";
	// $sku = $sku ."\"". $obj->start_price ."\",";
	// $sku = $sku ."\"". $obj->master_flg ."\",";
	// $sku = $sku ."\"". $obj->username ."\",";
	// $sku = $sku ."\"". $obj->created_datetime ."\",\r\n";
	}

	$sku_arr = array();
	foreach($sku_key as $s)
	{
		$sql = "SELECT * FROM sku_items WHERE master_flg = '0' AND item_url = "."\"". $s ."\"";
		$rc = $db -> Exec($sql);
		while($obj = $db -> fetch_object($rc))
		{
			$sku[$s] = "\"" .$obj -> action . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> item_url . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> category . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> Store_Category . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> Title . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> Condition_ID . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> Pic_URL . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> Description . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> Format . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> Duration . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> start_price . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> quantity . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> PayPal_Accepted . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> PayPal_Email_Address . "\",";
			$sku[$s] = $sku[$s]. "\"" .$obj -> Immediate_Pay_Required . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Payment_Instructions . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Location . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Shipping_Service1_Option . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Shipping_Service1_Cost . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Shipping_Service2_Option . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Shipping_Service2_Cost . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Dispatch_Time_Max . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Promotional_Shipping_Discount . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Shipping_Discount_ProfileID . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Domestic_Rate_Table . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Returns_Accepted_Option . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Returns_Within_Option . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Refund_Option . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Shipping_Cost_Paid_By . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Additional_Details . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Restocking_Fee_Value_Option . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Use_Tax_Table . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Additional_Cost . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Option . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Cost . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Locations . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  relationship . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  relationship_details . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";
			$sku[$s]=$sku[$s]. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",\r\n";
			$sku_arr[$s] = $sku;
			$sku = "";

// $sku_arr = explode("\r\n",$sku);
		}
		//$sku_arr[$s] = exlode("\r\n", $sku[$s]);
	}

var_dump($sku_arr);
exit;


	//そのユーザーのitem specificsのデフォルト設定を取得
	$sql = "SELECT item_specifics_default FROM  setting_tbl WHERE username = '".$db->esc($username)."' ";
	$rc = $db -> Exec($sql);
	$obj = $db -> fetch_object($rc);
	$item_specifics_default = unserialize($obj->item_specifics_default);



	 	//CSVダウンロード
	$sql = "SELECT ebay_result_tbl.*, ebay_mst.item_specifics FROM ebay_result_tbl LEFT JOIN ebay_mst ON ebay_result_tbl.category = ebay_mst.catetory_id WHERE ebay_result_tbl.username = '".$db->esc($username)."' ";

	$rc = $db -> Exec($sql);

	print "*Action(SiteID=US|Country=JP|Currency=USD|Version=403|CC=UTF-8),CustomLabel,*Category,StoreCategory,*Title,*ConditionID,PicURL,*Description,*Format,*Duration,*StartPrice,*Quantity,PayPalAccepted,PayPalEmailAddress,ImmediatePayRequired,PaymentInstructions,*Location,ShippingService-1:Option,ShippingService-1:Cost,ShippingService-2:Option,ShippingService-2:Cost,*DispatchTimeMax,PromotionalShippingDiscount,ShippingDiscountProfileID,DomesticRateTable,*ReturnsAcceptedOption,ReturnsWithinOption,RefundOption,ShippingCostPaidBy,AdditionalDetails,RestockingFeeValueOption,UseTaxTable,IntlShippingService-1:AdditionalCost,IntlShippingService-1:Option,IntlShippingService-1:Cost,IntlShippingService-1:Locations,IntlShippingService-1:Priority".$csv_header_item_specifics.",C:Country of Manufacture,ConditionDescription\r\n";
	while($obj = $db -> fetch_object($rc)) {
		$str= "\"" . $obj ->  action . "\",";
		$str=$str. "\"" . $obj ->  custom_label . "\",";
		foreach($sku as $sk)
		{
			if(array_key_exits($obj -> custom_label, $sku) == true )
			{
				var_dump('this');
			}
		$str=$str. "\"" . $obj ->  custom_label . "\",";
		}
				var_dump('here!!');exit;
		$str=$str. "\"" . $obj ->  category . "\",";
		$str=$str. "\"" . $obj ->  Store_Category . "\",";
		$str=$str. "\"" . $obj ->  Title . "\",";
		$str=$str. "\"" . $obj ->  Condition_ID . "\",";

		$Pic_URL = preg_split('/[\r\n\s]+/', $obj ->  Pic_URL);
		$Pic_URL = implode('|', $Pic_URL);
		$str=$str. "\"" . $Pic_URL . "\",";

		$newdes = str_replace("\r\n",' ',$obj ->  Description);
		$newdes = str_replace(",",'.',$newdes);
		$newdes = preg_replace('/"/', '""', $newdes);
		$str=$str. "\"" . $newdes . "\",";

		$str=$str. "\"" . $obj ->  Format . "\",";
		$str=$str. "\"" . $obj ->  Duration . "\",";
		$str=$str. "\"" . $obj ->  Start_Price . "\",";
		$str=$str. "\"" . $obj ->  Quantity . "\",";
		$str=$str. "\"" . $obj ->  PayPal_Accepted . "\",";
		$str=$str. "\"" . $obj ->  PayPal_Email_Address . "\",";
		$str=$str. "\"" . $obj ->  Immediate_Pay_Required . "\",";
		$str=$str. "\"" . $obj ->  Payment_Instructions . "\",";
		$str=$str. "\"" . $obj ->  Location . "\",";
		$str=$str. "\"" . $obj ->  Shipping_Service1_Option . "\",";
		$str=$str. "\"" . $obj ->  Shipping_Service1_Cost . "\",";
		$str=$str. "\"" . $obj ->  Shipping_Service2_Option . "\",";
		$str=$str. "\"" . $obj ->  Shipping_Service2_Cost . "\",";
		$str=$str. "\"" . $obj ->  Dispatch_Time_Max . "\",";
		$str=$str. "\"" . $obj ->  Promotional_Shipping_Discount . "\",";
		$str=$str. "\"" . $obj ->  Shipping_Discount_ProfileID . "\",";
		$str=$str. "\"" . $obj ->  Domestic_Rate_Table . "\",";
		$str=$str. "\"" . $obj ->  Returns_Accepted_Option . "\",";
		$str=$str. "\"" . $obj ->  Returns_Within_Option . "\",";
		$str=$str. "\"" . $obj ->  Refund_Option . "\",";
		$str=$str. "\"" . $obj ->  Shipping_Cost_Paid_By . "\",";
		$str=$str. "\"" . $obj ->  Additional_Details . "\",";
		$str=$str. "\"" . $obj ->  Restocking_Fee_Value_Option . "\",";
		$str=$str. "\"" . $obj ->  Use_Tax_Table . "\",";
		$str=$str. "\"" . $obj ->  Intl_Shipping_Service1_Additional_Cost . "\",";
		$str=$str. "\"" . $obj ->  Intl_Shipping_Service1_Option . "\",";
		$str=$str. "\"" . $obj ->  Intl_Shipping_Service1_Cost . "\",";
		$str=$str. "\"" . $obj ->  Intl_Shipping_Service1_Locations . "\",";
		$str=$str. "\"" . $obj ->  Intl_Shipping_Service1_Priority . "\",";

//var_dump($str);exit;


		$category_item_specificses = explode('|', $obj->item_specifics);

		foreach ($item_specifics as $value) {

			if (array_search($value, $category_item_specificses) !== false) {

				switch ($value) {
					case 'Size Type':
						if ($item_specifics_default[$value]) {
							$str=$str. "\"".$item_specifics_default[$value]."\",";
						} else {
							$str=$str. "\"regular\",";
						}
						break;

					case 'Brand':
						if ($item_specifics_default[$value]) {
							$str=$str. "\"".$item_specifics_default[$value]."\",";
						} else {
							$str=$str. "\"see title.\",";
						}
						break;

					// ADD:SKU
					//case 'Relationship'


					default :
						if ($item_specifics_default[$value]) {
							$str=$str. "\"".$item_specifics_default[$value]."\",";
						} else {
							$str=$str. "\"see description.\",";
						}
				}

			} else {
				$str=$str. "\"\",";
			}
		}

		$str=$str. "\"" . $obj ->  C_Country_Manufacture . "\",";
		$str=$str. "\"" . $obj ->  Condition_Description . "\"\r\n";
		print $str;
		print $sku;
	}
			$db -> close();

?>
