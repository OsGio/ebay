<?php
	require_once("common/auth.php");
	require_once("common/db.php");
	$username = $_SESSION["CONVERTER_USERID"];

	
	$checkedLinkCode1 = "checked";
	$checkedLinkCode2 = "";
	$link_code = $_POST["link_code"];
    if (isset($_POST["link_code"])) {
	  	if($_POST["link_code"] == "1"){
			$checkedLinkCode1 = "checked";
			$checkedLinkCode2 = "";
	  	}elseif($_POST["link_code"] == "2"){
			$checkedLinkCode1 = "";
			$checkedLinkCode2 = "checked";
	  	}
	}
	$db = new dbclass();
	
	if (isset($_GET["exec"]) && $_GET["exec"] == "3"){
   
		$rate = $_POST["rate"];
		$postage = $_POST["postage"];
		$action = $_POST["action"];
		//$Condition_ID = $_POST["Condition_ID"];
		$Format = $_POST["Format"];
		$Duration = $_POST["Duration"];
		$Quantity = $_POST["Quantity"];
		$PayPal_Accepted = $_POST["PayPal_Accepted"];
		$PayPal_Email_Address = $_POST["PayPal_Email_Address"];
		$Immediate_Pay_Required = $_POST["Immediate_Pay_Required"];
		$Payment_Instructions = $_POST["Payment_Instructions"];
		$Location = $_POST["Location"];
		$Shipping_Service1_Option = $_POST["Shipping_Service1_Option"];
		$Shipping_Service1_Cost = $_POST["Shipping_Service1_Cost"];
		$Dispatch_Time_Max = $_POST["Dispatch_Time_Max"];
		$Returns_Accepted_Option = $_POST["Returns_Accepted_Option"];
		$Returns_Within_Option = $_POST["Returns_Within_Option"];
		$Refund_Option = $_POST["Refund_Option"];
		$Shipping_Cost_Paid_By = $_POST["Shipping_Cost_Paid_By"];
		$Return_Detail = $_POST["Return_Detail"];
		$Restocking_Fee_Value_Option = $_POST["Restocking_Fee_Value_Option"];
		$Intl_Shipping_Service1_Additional_Cost = $_POST["Intl_Shipping_Service1_Additional_Cost"];
		$Intl_Shipping_Service1_Option = $_POST["Intl_Shipping_Service1_Option"];
		$Intl_Shipping_Service1_Cost = $_POST["Intl_Shipping_Service1_Cost"];
		$Intl_Shipping_Service1_Locations = $_POST["Intl_Shipping_Service1_Locations"];
		$Intl_Shipping_Service1_Priority = $_POST["Intl_Shipping_Service1_Priority"];
		$header_html = $_POST["header_html"];
		$split_html = $_POST["split_html"];
		$footer_html = $_POST["footer_html"];
		$use_pc_introduce = $_POST["use_pc_introduce"];
		$use_pc_promote = $_POST["use_pc_promote"];
		

		$tmp_item_specifics_default = array(
			"Band Size" => $_POST["Band_Size"],
			"Bottoms Size (Men's)" => $_POST["Bottoms_Size_(Men's)"],
			"Bottoms Size (Women's)" => $_POST["Bottoms_Size_(Women's)"],
			"Brand" => $_POST["Brand"],
			"Cup Size" => $_POST["Cup_Size"],
			"Dress Shirt Size" => $_POST["Dress_Shirt_Size"],
			"Hosiery Size" => $_POST["Hosiery_Size"],
			"Intimates & Sleep Size (Women's)" => $_POST["Intimates_&_Sleep_Size_(Women's)"],
			"Jacket Length" => $_POST["Jacket_Length"],
			"Jacket Size" => $_POST["Jacket_Size"],
			"Size (Men's)" => $_POST["Size_(Men's)"],
			"Size (Women's)" => $_POST["Size_(Women's)"],
			"Size Type" => $_POST["Size_Type"],
			"Sleeve Length" => $_POST["Sleeve_Length"],
			"Sock Size" => $_POST["Sock_Size"],
			"Style" => $_POST["Style"],
			"US Shoe Size (Men's)" => $_POST["US_Shoe_Size_(Men's)"],
			"US Shoe Size (Women's)" => $_POST["US_Shoe_Size_(Women's)"]
		);
		$item_specifics_default = serialize($tmp_item_specifics_default);

		
		//既に存在するかチェック
		$sql = "select username from  `setting_tbl` where username = '$username' ";
		
		$rc = $db -> Exec($sql);
		if($db -> NumRows($rc) > 0) {
			$sql = "update `setting_tbl` set ";
			$sql = $sql . " rate= '".$db->esc($rate)."', ";
			$sql = $sql . " postage= '".$db->esc($postage)."', ";
			$sql = $sql . " action= '".$db->esc($action)."', ";
			//$sql = $sql . " Condition_ID= '$Condition_ID', ";
			$sql = $sql . " Format= '".$db->esc($Format)."', ";
			$sql = $sql . " Duration= '".$db->esc($Duration)."', ";
			$sql = $sql . " Quantity= '".$db->esc($Quantity)."', ";
			$sql = $sql . " PayPal_Accepted= '".$db->esc($PayPal_Accepted)."', ";
			$sql = $sql . " PayPal_Email_Address= '".$db->esc($PayPal_Email_Address)."', ";
			$sql = $sql . " Immediate_Pay_Required= '".$db->esc($Immediate_Pay_Required)."', ";
			$sql = $sql . " Payment_Instructions= '".$db->esc($Payment_Instructions)."', ";
			$sql = $sql . " Location= '".$db->esc($Location)."', ";
			$sql = $sql . " Shipping_Service1_Option= '".$db->esc($Shipping_Service1_Option)."', ";
			$sql = $sql . " Shipping_Service1_Cost= '".$db->esc($Shipping_Service1_Cost)."', ";
			$sql = $sql . " Dispatch_Time_Max= '".$db->esc($Dispatch_Time_Max)."', ";
			$sql = $sql . " Returns_Accepted_Option= '".$db->esc($Returns_Accepted_Option)."', ";
			$sql = $sql . " Returns_Within_Option= '".$db->esc($Returns_Within_Option)."', ";
			$sql = $sql . " Refund_Option= '".$db->esc($Refund_Option)."', ";
			$sql = $sql . " Shipping_Cost_Paid_By= '".$db->esc($Shipping_Cost_Paid_By)."', ";
			$sql = $sql . " Return_Detail= '".$db->esc($Return_Detail)."', ";
			$sql = $sql . " Restocking_Fee_Value_Option= '".$db->esc($Restocking_Fee_Value_Option)."', ";
			$sql = $sql . " Intl_Shipping_Service1_Additional_Cost= '".$db->esc($Intl_Shipping_Service1_Additional_Cost)."', ";
			$sql = $sql . " Intl_Shipping_Service1_Option= '".$db->esc($Intl_Shipping_Service1_Option)."', ";
			$sql = $sql . " Intl_Shipping_Service1_Cost= '".$db->esc($Intl_Shipping_Service1_Cost)."', ";
			$sql = $sql . " Intl_Shipping_Service1_Locations= '".$db->esc($Intl_Shipping_Service1_Locations)."', ";
			$sql = $sql . " Intl_Shipping_Service1_Priority= '".$db->esc($Intl_Shipping_Service1_Priority)."', ";
			$sql = $sql . " header_html= '".$db->esc($header_html)."', ";
			$sql = $sql . " split_html= '".$db->esc($split_html)."', ";
			$sql = $sql . " footer_html= '".$db->esc($footer_html)."', ";
			$sql = $sql . " use_pc_introduce= '".$db->esc($use_pc_introduce)."', ";
			$sql = $sql . " use_pc_promote= '".$db->esc($use_pc_promote)."', ";
			$sql = $sql . " item_specifics_default= '".$db->esc($item_specifics_default)."' ";
			$sql = $sql . " where username = '".$db->esc($username)."' ";

			$result_flag = $db -> Exec($sql);
			
			if (!$result_flag) {
					die('登録が失敗しました。'.mysql_error());
			} else {
				$GLOBALS['announce'] = "登録が完了しました。";
			}
			$db -> close();
			
		}else{

			$sql = "insert into `setting_tbl`(
				`username` ,
				`rate`,
				`postage`,
				`action`,
				`Format`,
				`Duration`,
				`Quantity`,
				`PayPal_Accepted`,
				`PayPal_Email_Address`,
				`Immediate_Pay_Required`,
				`Payment_Instructions`,
				`Location`,
				`Shipping_Service1_Option`,
				`Shipping_Service1_Cost`,
				`Dispatch_Time_Max`,
				`Returns_Accepted_Option`,
				`Returns_Within_Option`,
				`Refund_Option`,
				`Shipping_Cost_Paid_By`,
				`Return_Detail`,
				`Restocking_Fee_Value_Option`,
				`Intl_Shipping_Service1_Additional_Cost`,
				`Intl_Shipping_Service1_Option`,
				`Intl_Shipping_Service1_Cost`,
				`Intl_Shipping_Service1_Locations`,
				`Intl_Shipping_Service1_Priority` ,
				`header_html` ,
				`split_html` ,
				`footer_html` ,
				`use_pc_introduce` ,
				`use_pc_promote` ,
				`item_specifics_default`
			) values(  '".$db->esc($username)."',
			'".$db->esc($rate)."',
			'".$db->esc($postage)."',
			'".$db->esc($action)."',
			'".$db->esc($Format)."',
			'".$db->esc($Duration)."',
			'".$db->esc($Quantity)."',
			'".$db->esc($PayPal_Accepted)."',
			'".$db->esc($PayPal_Email_Address)."',
			'".$db->esc($Immediate_Pay_Required)."',
			'".$db->esc($Payment_Instructions)."',
			'".$db->esc($Location)."',
			'".$db->esc($Shipping_Service1_Option)."',
			'".$db->esc($Shipping_Service1_Cost)."',
			'".$db->esc($Dispatch_Time_Max)."',
			'".$db->esc($Returns_Accepted_Option)."',
			'".$db->esc($Returns_Within_Option)."',
			'".$db->esc($Refund_Option)."',
			'".$db->esc($Shipping_Cost_Paid_By)."',
			'".$db->esc($Return_Detail)."',
			'".$db->esc($Restocking_Fee_Value_Option)."',
			'".$db->esc($Intl_Shipping_Service1_Additional_Cost)."',
			'".$db->esc($Intl_Shipping_Service1_Option)."',
			'".$db->esc($Intl_Shipping_Service1_Cost)."',
			'".$db->esc($Intl_Shipping_Service1_Locations)."',
			'".$db->esc($Intl_Shipping_Service1_Priority)."',
			'".$db->esc($header_html)."',
			'".$db->esc($split_html)."',
			'".$db->esc($footer_html)."',
			'".$db->esc($use_pc_introduce)."',
			'".$db->esc($use_pc_promote)."',
			'".$db->esc($item_specifics_default)."'
			) ";

			$result_flag = $db -> Exec($sql);
				if (!$result_flag) {
				    die('登録が失敗しました。'.mysql_error());
				} else {
					$GLOBALS['announce'] = "登録が完了しました。";
				}
			$db -> close();
		}
		
	}
	
?>

<?php include('header.php'); ?>
<script type="text/javascript">
  
  function doExec(id){
  	document.frm.action = "exhibit_setting.php?exec="+id;
  	document.frm.submit();
  }
  
	

function removeList(obj, id) {

	// tbody要素に指定したIDを取得し、変数「tbody」に代入
	var tbody = document.getElementById("dir-tbody"+id);
	// objの親の親のノードを取得し（つまりtr要素）、変数「tr」に代入
	var tr = obj.parentNode.parentNode;
	// 「tbody」の子ノード「tr」を削除
	tbody.removeChild(tr); 

}

</script>
<!-- /header -->



<section id="title_space">
<div>
<h2 class="import_data"><span style="font-weight:bold;background:url(img/title_logo_02.png) no-repeat 0 50%;padding:10px 0 10px 50px;background-size:40px 40px;">2. eBay出品時の項目設定</span></h2>

<p>
ドル→円換算レート、送料設定などeBay出品時の主要な設定ができます。<br>
支払い方法、返品受付などの重要な共通項目がありますので、必ず設定確認の上、コンバート作業を行ってください。<br>
「保存」しておけば、次回からは保存された情報で出品ができます。
</p>

</div>
</section>



<div id="content">

    <div>

<form action="exhibit_setting.php" name="frm" method="post">





<?php if ($GLOBALS['announce']) { ?><div class="attention"><?php echo_h($GLOBALS['announce']); ?></div><?php } ?>


<h2 class="subtitle" style="width:400px;float:left;">eBay主要項目設定</h2>



<br clear="both" />

		<?php
		require_once('common/SC_eBay.php');
		require_once('common/EBAY_CONS.php');
		if ($user -> token) {
			$ebayClass = new SC_eBay(API_DEV_NAME,API_APP_NAME,API_CERT_NAME,$user -> token,EBAY_SERVER,RU_NAME);
			$res = $ebayClass->getUser();
	//		var_dump($res);
		?>
		<table class="datatable" style="margin-bottom:20px;">
			<tr><th>eBay Email</th><td><?php echo_h($res->User->Email) ?></td></tr>
			<tr><th>eBay UserID</th><td><?php echo_h($res->User->UserID) ?></td></tr>
		</table>
		<?php } ?>

		


		<table class="datatable setting">
		<?php

		
		$rate="100";
		$postage="0";
		$action="Add";
		//$Condition_ID="3000";
		$Format="Auction";
		$Duration="10";
		$Quantity="1";
		$PayPal_Accepted="1";
		$PayPal_Email_Address="";
		$Immediate_Pay_Required="";
		$Payment_Instructions="";
		$Location="Tokyo";
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
		$split_html = '<br /><br />';
		$use_pc_introduce = 1;
		$use_pc_promote = 1;
		//既に存在するかチェック
		$sql = "select * from  `setting_tbl` where username = '$username' ";
		$db = new dbclass();
		$rc = $db -> Exec($sql);

		if($db -> NumRows($rc) > 0) {
			$obj = $db -> fetch_object($rc);
			
			$rate=$obj -> rate;
			$action=$obj -> action;
			$postage=$obj -> postage;
			//$Condition_ID=$obj -> Condition_ID;
			$Format=$obj -> Format;
			$Duration=$obj -> Duration;
			$Quantity=$obj -> Quantity;
			$PayPal_Accepted=$obj -> PayPal_Accepted;
			$PayPal_Email_Address=$obj -> PayPal_Email_Address;
			$Immediate_Pay_Required=$obj -> Immediate_Pay_Required;
			$Payment_Instructions=$obj -> Payment_Instructions;
			$Location=$obj -> Location;
			$Shipping_Service1_Option=$obj -> Shipping_Service1_Option;
			$Shipping_Service1_Cost=$obj -> Shipping_Service1_Cost;
			$Dispatch_Time_Max=$obj -> Dispatch_Time_Max;
			$Returns_Accepted_Option=$obj -> Returns_Accepted_Option;
			$Returns_Within_Option=$obj -> Returns_Within_Option;
			$Refund_Option=$obj -> Refund_Option;
			$Shipping_Cost_Paid_By=$obj -> Shipping_Cost_Paid_By;
			$Return_Detail=$obj -> Return_Detail;
			$Restocking_Fee_Value_Option=$obj -> Restocking_Fee_Value_Option;
			$Intl_Shipping_Service1_Additional_Cost=$obj -> Intl_Shipping_Service1_Additional_Cost;
			$Intl_Shipping_Service1_Option=$obj -> Intl_Shipping_Service1_Option;
			$Intl_Shipping_Service1_Cost=$obj -> Intl_Shipping_Service1_Cost;
			$Intl_Shipping_Service1_Locations=$obj -> Intl_Shipping_Service1_Locations;
			$Intl_Shipping_Service1_Priority=$obj -> Intl_Shipping_Service1_Priority;
			$header_html = $obj -> header_html;
			$split_html = $obj -> split_html;
			$footer_html = $obj -> footer_html;
			$use_pc_introduce = $obj -> use_pc_introduce;
			$use_pc_promote = $obj -> use_pc_promote;
			
			$item_specifics_default = unserialize($obj->item_specifics_default);
		}
		$db -> close();
		?>
<tr>
<th colspan="2">ドル/円換算レート</th>
<td>1ドル＝<input type="text" name = "rate" value="<?php echo $rate;?>">円<br>（整数で入力して下さい）</td>
</tr>

<tr>
<th colspan="2">加算送料(単位：ドル)</th>
<td><input type="text" name = "postage" value="<?php echo $postage;?>"></td>
</tr>

<tr>
<th>action</th>
<td><a href="#ebay-set-sousa">操作</a></td>
	<div class="remodal" data-remodal-id="ebay-set-sousa">
	<div style="text-align:left;">
	<p>アップロードするCSVファイルの操作を設定できます。<br>新規登録以外は基本的に使用しません。</p>
	<ul>
	<li>Add：新規登録</li>
	<li>Revise：編集・更新</li>
	<li>Relist：再出品する（売れた商品向け）</li>
	<li>End：オークションを終了させる</li>
	<li>Status：アイテムの状況</li>
	<li>VerifyAdd：アップロード確認</li>
	<li>AddToItemDescription：アイテム状況を加える</li>
	</ul>
	</div>
	</div>
<td>
	<select name = "action">
		<option value="Add" <?php if  ($action == 'Add') {echo 'selected="selected"';}?>>新規登録</option>
		<option value="Revise" <?php if  ($action == 'Revise') {echo 'selected="selected"';}?>>編集・更新</option>
		<option value="Relist" <?php if  ($action == 'Relist') {echo 'selected="selected"';}?>>再出品する（売れた商品向け）</option>
		<option value="End" <?php if  ($action == 'End') {echo 'selected="selected"';}?>>オークションを終了させる</option>
		<option value="Status" <?php if  ($action == 'Status') {echo 'selected="selected"';}?>>アイテムの状況</option>
		<option value="VerifyAdd" <?php if  ($action == 'VerifyAdd') {echo 'selected="selected"';}?>>アップロード確認</option>
		<option value="AddToItemDescription" <?php if  ($action == 'AddToItemDescription') {echo 'selected="selected"';}?>>アイテム状況を加える</option>
	</select>
</td>
</tr>




<!-- <tr><th>Condition_ID</th><td><input type="text" name = "Condition_ID" value="<?php echo $Condition_ID;?>"></td></tr> -->

<tr>
<th>Format</th>
<td><a href="#ebay-set-format">フォーマット</a></td>
	<div class="remodal" data-remodal-id="ebay-set-format">
	<div style="text-align:left;">
	<p>販売形式を決められます。</p>
	<ul>
	<li>Auction：オークション形式（デフォルト）</li>
	<li>FixedPrice：固定価格</li>
	<li>ClassifiedAd：-</li>
	<li>RealEstateAd：-</li>
	</ul>
	</div>
	</div>
<td>
	<select name = "Format">
		<option value="Auction" <?php if  ($Format == 'Auction') {echo 'selected="selected"';}?>>オークション形式</option>
		<option value="FixedPrice" <?php if  ($Format == 'FixedPrice') {echo 'selected="selected"';}?>>固定価格</option>
	</select>
</td>
</tr>

<tr>
<th>Duration</th>
<td><a href="#ebay-set-duration">販売日数</a></td>
	<div class="remodal" data-remodal-id="ebay-set-duration">
	<div style="text-align:left;">
	<p>開始から終了までのオークション期間です。</p>
	<p>1、3、5、7、10日から選びます。</p>
	<p>ストアアカウントの場合は、「30日間」と「キャンセルするまで出品し続ける（Good 'Til Cancelled）」が設定できます。</p>
	</div>
	</div>
<td>
	<select name = "Duration">
		<option value="1" <?php if  ($Duration == '1') {echo 'selected="selected"';}?>>1日間</option>
		<option value="3" <?php if  ($Duration == '3') {echo 'selected="selected"';}?>>3日間</option>
		<option value="5" <?php if  ($Duration == '5') {echo 'selected="selected"';}?>>5日間</option>
		<option value="7" <?php if  ($Duration == '7') {echo 'selected="selected"';}?>>7日間</option>
		<option value="10" <?php if  ($Duration == '10') {echo 'selected="selected"';}?>>10日間</option>
		<option value="30" <?php if  ($Duration == '30') {echo 'selected="selected"';}?>>30日間</option>
		<option value="GTC" <?php if  ($Duration == 'GTC') {echo 'selected="selected"';}?>>キャンセルするまで出品し続ける（Good 'Til Cancelled）</option>
	</select>
</td>
</tr>

<tr>
<th>Quantity</th>
<td><a href="#ebay-set-quantity">在庫数</a></td>
	<div class="remodal" data-remodal-id="ebay-set-quantity">
	<div style="text-align:left;">
	<p>必ず整数で記載してください</p>
	</div>
	</div>
<td><input type="text" name = "Quantity" value="<?php echo $Quantity;?>"></td>
</tr>

<tr>
<th>PayPal_Accepted</th>
<td><a href="#PayPal_A">ペイパル支払い</a></td>
	<div class="remodal" data-remodal-id="PayPal_A">
	<div style="text-align:left;">
	<p>受け付ける場合：1</p>
	<p>受け付けない場合：0</p>
	</div>
	</div>
<td>
	<select name = "PayPal_Accepted">
		<option value="1" <?php if  ($PayPal_Accepted == '1') {echo 'selected="selected"';}?>>受け付ける</option>
		<option value="0" <?php if  ($PayPal_Accepted == '0') {echo 'selected="selected"';}?>>受け付けない</option>
	</select>
</td>
</tr>

<tr>
<th>PayPal_Email_Address</th>
<td>ペイパルアカウント登録メールアドレス</td>
<td><input type="text" name = "PayPal_Email_Address" value="<?php echo $PayPal_Email_Address;?>"></td>
</tr>

<tr style="display:none">
<th>Immediate_Pay_Required</th>
<td>購入前の支払いを受け付ける？<br>paypalビジネスもしくはプレミアアカウントのみ</td>
<td><input type="text" name = "Immediate_Pay_Required" value="<?php echo $Immediate_Pay_Required;?>"></td>
</tr>

<tr>
<th>Payment_Instructions</th>
<td>支払い手順説明</td>
<td><input type="text" name = "Payment_Instructions" value="<?php echo $Payment_Instructions;?>"></td>
</tr>

<tr>
<th>Location</th>
<td>発送元の国または地域（例：Tokyo）</td>
<td><input type="text" name = "Location" value="<?php echo $Location;?>"></td>
</tr>

<tr>
<th>Shipping_Service1_Option</th>
<td>アメリカ国内への発送</td>
<td>
	<select name = "Shipping_Service1_Option">
		<option value="ExpeditedShippingFromOutsideUS" <?php if  ($Shipping_Service1_Option == 'ExpeditedShippingFromOutsideUS') {echo 'selected="selected"';}?>>アメリカ国外からの発送</option>
	</select>	
</td>
</tr>

<tr>
<th>Shipping_Service1_Cost</th>
<td>アメリカ国内へ発送する際の送料</td>
<td><input type="text" name = "Shipping_Service1_Cost" value="<?php echo $Shipping_Service1_Cost;?>"></td>
</tr>

<tr>
<th>Dispatch_Time_Max</th>
<td>発送までの最大日数</td>
<td><input type="text" name = "Dispatch_Time_Max" value="<?php echo $Dispatch_Time_Max;?>"></td>
</tr>

<tr>
<th>Returns_Accepted_Option</th>
<td><a href="#return_policy">返品ポリシー</td>
	<div class="remodal" data-remodal-id="return_policy">
	<div style="text-align:left;">
	<p>ReturnsAccepted：返品を受け付ける</p>
	<p>ReturnsNotAccepted：返品を受け付けない</p>
	</div>
	</div>
<td>
	<select name = "Returns_Accepted_Option">
		<option value="ReturnsAccepted" <?php if  ($Returns_Accepted_Option == 'ReturnsAccepted') {echo 'selected="selected"';}?>>返品を受け付ける</option>
		<option value="ReturnsNotAccepted" <?php if  ($Returns_Accepted_Option == 'ReturnsNotAccepted') {echo 'selected="selected"';}?>>返品を受け付けない</option>
	</select>
</td>
</tr>

<tr>
<th>Returns_Within_Option</th>
<td><a href="#return_option">返品受付期間</a></td>
	<div class="remodal" data-remodal-id="return_option">
	<div style="text-align:left;">
	<p>返品を受け付ける期間を設定します。（到着期限）</p>
	<p>Days_14：14日間</p>
	<p>Days_30：30日間</p>
	<p>Days_60：60日間</p>
	</div>
	</div>

<td>
	<select name = "Returns_Within_Option">
		<option value="Days_14" <?php if  ($Returns_Within_Option == 'Days_14') {echo 'selected="selected"';}?>>14日間</option>
		<option value="Days_30" <?php if  ($Returns_Within_Option == 'Days_30') {echo 'selected="selected"';}?>>30日間</option>
		<option value="Days_60" <?php if  ($Returns_Within_Option == 'Days_60') {echo 'selected="selected"';}?>>60日間</option>
	</select>
</td>
</tr>

<tr>
<th>Refund_Option</th>
<td><a href="#refund">返金方法</a></td>
	<div class="remodal" data-remodal-id="refund">
	<div style="text-align:left;">
	<p>MoneyBackOrExchange：返金あるいは商品交換</p>
	<p>MoneyBack：返金</p>
	</div>
	</div>
<td>
	<select name = "Refund_Option">
		<option value="MoneyBackOrExchange" <?php if  ($Refund_Option == 'MoneyBackOrExchange') {echo 'selected="selected"';}?>>返金あるいは商品交換</option>
		<option value="MoneyBack" <?php if  ($Refund_Option == 'MoneyBack') {echo 'selected="selected"';}?>>返金</option>
	</select>	
</td>
</tr>

<tr>
<th>Shipping_Cost_Paid_By</th>
<td><a href="#Cost_Paid_By">返品時、送料負担</td>
	<div class="remodal" data-remodal-id="Cost_Paid_By">
	<div style="text-align:left;">
	<p>Buyer：お客様負担</p>
	<p>Seller：出店者負担</p>
	</div>
	</div>
<td>
	<select name = "Shipping_Cost_Paid_By">
		<option value="Buyer" <?php if  ($Shipping_Cost_Paid_By == 'Buyer') {echo 'selected="selected"';}?>>お客様負担</option>
		<option value="Seller" <?php if  ($Shipping_Cost_Paid_By == 'Seller') {echo 'selected="selected"';}?>>出店者負担</option>
	</select>	
</td>
</tr>

<tr>
<th>Return Details</th>
<td>返品に関する説明</td>
<td><input type="text" name = "Return_Detail" value="<?php echo $Return_Detail;?>"></td>
</tr>

<tr>
<th>Restocking_Fee_Value_Option</th>
<td>返品受付時の手数料</td>
<td>
	<select name = "Restocking_Fee_Value_Option">
		<option value="NoRestockingFee" <?php if  ($Restocking_Fee_Value_Option == 'NoRestockingFee') {echo 'selected="selected"';}?>>手数料は請求しない</option>
		<option value="Percent_10" <?php if  ($Restocking_Fee_Value_Option == 'Percent_10') {echo 'selected="selected"';}?>>価格の10%を手数料として請求</option>
		<option value="Percent_15" <?php if  ($Restocking_Fee_Value_Option == 'Percent_15') {echo 'selected="selected"';}?>>価格の15%を手数料として請求</option>
		<option value="Percent_20" <?php if  ($Restocking_Fee_Value_Option == 'Percent_20') {echo 'selected="selected"';}?>>価格の20%を手数料として請求</option>
	</select>	
</td>
</tr>

<!--
<tr>
<th>Intl_Shipping_Service1_Additional_Cost</th>
<td>アメリカ以外への発送時の手数料</td>
<td><input type="text" name = "Intl_Shipping_Service1_Additional_Cost" value="<?php echo $Intl_Shipping_Service1_Additional_Cost;?>"></td>
</tr>
-->

<tr>
<th>Intl_Shipping_Service1_Option</th>
<td>アメリカ以外への発送</td>
<td>
	<select name = "Intl_Shipping_Service1_Option">
		<option value="ExpeditedInternational" <?php if  ($Intl_Shipping_Service1_Option == 'ExpeditedInternational') {echo 'selected="selected"';}?>>アメリカ国外へ発送</option>
	</select>	
</td>
</tr>

<tr>
<th>Intl_Shipping_Service1_Cost</th>
<td>アメリカ以外への発送時の送料</td>
<td><input type="text" name = "Intl_Shipping_Service1_Cost" value="<?php echo $Intl_Shipping_Service1_Cost;?>"></td>
</tr>

<tr style="display:none">
<th>Intl_Shipping_Service1_Locations</th>
<td>発送可能は国は？</td>
<td>
	<input type="text" name = "Intl_Shipping_Service1_Locations" value="<?php echo $Intl_Shipping_Service1_Locations;?>">
</td>
</tr>

<tr style="display:none">
<th>Intl_Shipping_Service1_Priority</th>
<td></td>
<td><input type="text" name = "Intl_Shipping_Service1_Priority" value="<?php echo $Intl_Shipping_Service1_Priority;?>"></td>
</tr>

</table>



	<div align="center">
		<input type="button" onclick="doExec('3')" name="exec3" value="" class="btn_hozon" />
	</div>




		
	<table class="datatable" style="display:none">
			<tr>
				<th>共通上部HTML</th>
				<td><textarea name="header_html"><?php echo $header_html;?></textarea></td>
			</tr>
			<tr>
				<th>区切りHTML</th>
				<td><textarea name="split_html"><?php echo $split_html;?></textarea></td>
			</tr>
			<tr>
				<th>共通下部HTML</th>
				<td><textarea name="footer_html"><?php echo $footer_html;?></textarea></td>
			</tr>
			<tr>
				<th>「PC用商品説明文」をeBay商品説明文に使用</th>
				<td><input type="checkbox" name="use_pc_introduce" <?php if ($use_pc_introduce) { ?>checked="checked"<?php } ?> value="1"></td>
			</tr>
			<tr>
				<th>「PC用販売説明文」をeBay商品説明文に使用</th>
				<td><input type="checkbox" name="use_pc_promote" <?php if ($use_pc_promote) { ?>checked="checked"<?php } ?> value="1"></td>
			</tr>
		</table>
		
		
		<table class="datatable"style="display:none">
			<tr>
				<th>Band Size</th>
				<td><input type="text" name="Band Size" value="<?php echo $item_specifics_default["Band Size"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Bottoms Size (Men's)</th>
				<td><input type="text" name="Bottoms Size (Men's)" value="<?php echo $item_specifics_default["Bottoms Size (Men's)"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Bottoms Size (Women's)</th>
				<td><input type="text" name="Bottoms Size (Women's)" value="<?php echo $item_specifics_default["Bottoms Size (Women's)"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Brand</th>
				<td><input type="text" name="Brand" value="<?php echo $item_specifics_default["Brand"];?>" placeholder="未入力時は「see title.」"></td>
			</tr>
			<tr>
				<th>Cup Size</th>
				<td><input type="text" name="Cup Size" value="<?php echo $item_specifics_default["Cup Size"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Dress Shirt Size</th>
				<td><input type="text" name="Dress Shirt Size" value="<?php echo $item_specifics_default["Dress Shirt Size"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Hosiery Size</th>
				<td><input type="text" name="Hosiery Size" value="<?php echo $item_specifics_default["Hosiery Size"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Intimates & Sleep Size (Women's)</th>
				<td><input type="text" name="Intimates & Sleep Size (Women's)" value="<?php echo $item_specifics_default["Intimates & Sleep Size (Women's)"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Jacket Length</th>
				<td><input type="text" name="Jacket Length" value="<?php echo $item_specifics_default["Jacket Length"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Jacket Size</th>
				<td><input type="text" name="Jacket Size" value="<?php echo $item_specifics_default["Jacket Size"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Size (Men's)</th>
				<td><input type="text" name="Size (Men's)" value="<?php echo $item_specifics_default["Size (Men's)"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Size (Women's)</th>
				<td><input type="text" name="Size (Women's)" value="<?php echo $item_specifics_default["Size (Women's)"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Size Type</th>
				<td><input type="text" name="Size Type" value="<?php echo $item_specifics_default["Size Type"];?>" placeholder="未入力時は「regular」"></td>
			</tr>
			<tr>
				<th>Sleeve Length</th>
				<td><input type="text" name="Sleeve Length" value="<?php echo $item_specifics_default["Sleeve Length"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Sock Size</th>
				<td><input type="text" name="Sock Size" value="<?php echo $item_specifics_default["Sock Size"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>Style</th>
				<td><input type="text" name="Style" value="<?php echo $item_specifics_default["Style"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>US Shoe Size (Men's)</th>
				<td><input type="text" name="US Shoe Size (Men's)" value="<?php echo $item_specifics_default["US Shoe Size (Men's)"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>
			<tr>
				<th>US Shoe Size (Women's)</th>
				<td><input type="text" name="US Shoe Size (Women's)" value="<?php echo $item_specifics_default["US Shoe Size (Women's)"];?>" placeholder="未入力時は「see description.」"></td>
			</tr>


		</table>

</form>


</div><!-- /mainCol -->

</div><!-- /content -->







<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
