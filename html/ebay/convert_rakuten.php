#!/usr/bin/php
<?php
require_once(dirname(__FILE__)."/common/db.php");
require_once(dirname(__FILE__)."/common/SC_transAPI.php");

DEFINE("STORE_NAME",'アイテムコンバーター');


$db = new dbclass();
//ユーザーID
$username = $argv[1];
//ログID
$new_log_id = 1;
//ログ内容
$logs = array();

//翻訳APIのインスタンス生成
$sql = "select * from  `user_tbl` where username = '".$db->esc($username)."'";
$user_rc = $db -> Exec($sql);
if ($obj_user = $db -> fetch_object($user_rc)) {
	$trans = new SC_transAPI('203916a788aa313171d9c22e85b82cf9', $obj_user->trans_api_key, $obj_user->trans_api_secret_key);
}

var_dump($user_name);exit;
if ($username) {

	//変換
	$sql = "select * from  `setting_tbl` where username = '".$db->esc($username)."'";
	$setting_rc = $db -> Exec($sql);
	$objset = $db -> fetch_object($setting_rc);

	$PayPal_Accepted = 1;
	$PayPal_Email_Address = "";
	$location = "";
	$Dispatch_Time_Max = 3;
	$Returns_Accepted_Option = "ReturnsAccepted";
	$format = "FixedPrice";
	if ($objset) {
		$PayPal_Accepted = $objset -> use_paypal;
		$PayPal_Email_Address =  $objset -> paypal_mail;
		$location = $objset -> location;
		$Dispatch_Time_Max = $objset -> max_dispatch_time;
		$Returns_Accepted_Option = $objset -> return_accept;
		$format = $objset -> format;
	}

	$sql = "delete from  `log_tbl` where username = '".$db->esc($username)."'";
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
    $errorMsg = "";

    $rate="100";
    $action="Add";
	$Condition_ID="3000";
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
	$header_html = '';
	$split_html = '<br /><br />';
	$footer_html = '';
	$use_pc_introduce = 1;
	$use_pc_promote = 1;
	$postage  = 0;


	if($db -> NumRows($setting_rc) > 0) {

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
		$header_html = $objset -> header_html;
		$split_html = $objset -> split_html;
		$footer_html = $objset -> footer_html;
		$use_pc_introduce = $objset -> use_pc_introduce;
		$use_pc_promote = $objset -> use_pc_promote;
		$postage  = $objset -> postage;
	}


	//コンディションテーブルを取得
	$condition_mst = array();
	$cond_sql = "select * from  `condition_mst` where username = '".$db->esc($username)."'";
	$condition_res = $db -> Exec($cond_sql);
	if (!$db->NumRows($condition_res)) {
		$cond_sql = "select * from  `condition_mst` where username = 'wasabi_admin'";
		$condition_res = $db -> Exec($cond_sql);
	}
	while ($cond_obj = $db -> fetch_object($condition_res)) {
		$condition_mst[] = array(
			'tag_id' => $cond_obj->tag_id,
			'ebay_condition_id' => $cond_obj->ebay_condition_id,
			'condition_des' => $cond_obj->condition_des
		);
	}
//	var_dump($condition_mst);


	//文中の文字列を正規表現に変換するマスタ
	$regex_list = array(
		array('【半角英数】', '[0-9a-zA-Z ]+'),
		array('【半角数字】', '[0-9 ]+'),
		array('【半角英字】', '[a-zA-Z ]+'),
		array('【カタカナ】', '[ァ-ヶー・ ]+'),
		array('【ひらがな】', '[ぁ-んー・ ]+'),
		array('【漢字】', '[一-龠 ]+'),
		array('【全角文字】', '[ぁ-んァ-ヶー一-龠 ]+')
	);
//	var_dump($regex_list);


	//キーワード・英訳辞書を取得
	$sql = "SELECT *, CASE change_col WHEN 0 THEN '0' ELSE '1' END as chg, CASE username WHEN 'wasabi_admin' THEN '0' ELSE '1' END as usr FROM string_mst_tbl WHERE (username = '".$db->esc($username)."' OR username = 'wasabi_admin') ORDER BY chg DESC, usr DESC, no ASC";
	$tmp_string_mst = $db->Exec($sql);
	$string_mst = array();
	while ($obj = $db->fetch_object($tmp_string_mst)) {
		if ($obj->action_type == '置換' || $obj->action_type == '削除') {
			$obj->before_str = preg_quote($obj->before_str, '/');
			foreach ($regex_list as $regex) {
				$obj->before_str = preg_replace('/'.$regex[0].'/', $regex[1], $obj->before_str);
			}
			if ($obj->start_str_no) {
				$obj->before_str = '/('.$obj->before_str.'){'.$obj->start_str_no.'}/u';
			} else {
				$obj->before_str = '/'.$obj->before_str.'/u';
			}

		} else if ($obj->action_type == '範囲置換') {
			$split_str = mb_split('<<split>>', $obj->before_str);

			$obj->start_str = preg_quote($split_str[0], '/');
			foreach ($regex_list as $regex) {
				$obj->start_str = preg_replace('/'.$regex[0].'/', $regex[1], $obj->start_str);
			}

			$obj->end_str = preg_quote($split_str[1], '/');
			foreach ($regex_list as $regex) {
				$obj->end_str = preg_replace('/'.$regex[0].'/', $regex[1], $obj->end_str);
			}
		}

		$string_mst[] = (array)$obj;
	}
//	var_dump($string_mst);



	while ($obj = $db -> fetch_object($rc)) {

		//キーワード・英訳辞書の変換を実行
		convertString($string_mst, $obj);

		//楽天ディレクトリIDをebayカテゴリIDに変換
		$category = changeCat($db,$obj -> directory_id, $username);

		$new_username = $userid;
		$id = $new_id++;
		$custom_label = $obj -> product_no;
		$Store_Category = "";
		$Title = '';
		$Title = trim(strip_tags($trans->trans($obj -> product_name, 'ja', 'en')));
		$Title = str_replace("'","''",$Title);
		$Title = preg_replace('/[￡％＃＆＊＠§☆★○●◎◇◆□■△▲▽▼、。，．・：；？！゛゜´｀¨＾￣＿ヽヾゝゞ〃仝々〆〇ー―‐／＼～∥｜…‥‘’“”（）〔〕［］｛｝〈〉《》「」『』【】＋－±×÷＝≠＜＞≦≧∞∴♂♀°′″℃￥＄￠※〒→←↑↓〓∈∋⊆⊇⊂⊃∪∩∧∨￢⇒⇔∀∃∠⊥⌒∂∇≡≒≪≫√∽∝∵∫∬Å‰♯♭♪†‡¶◯ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩαβγδεζηθικλμνξοπρστυφχψωАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя─│┌┐┘└├┬┤┴┼━┃┏┓┛┗┣┳┫┻╋┠┯┨┷┿┝┰┥┸╂①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩ�㍉㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫㍊㌻㎜㎝㎞㎎㎏㏄㎡㍻〝〟№㏍℡㊤㊥㊦㊧㊨㈱㈲㈹㍾㍽㍼≒≡∫∮∑√⊥∠∟⊿∵∩∪]+/u', '', $Title);

		if (mb_strwidth($Title) > 80) {
			$Title = substr($Title, 0, 80);
			$logs[] = "('".$db->esc($username)."',".$db->esc($new_log_id).", 2, '商品番号「".$obj->product_no."」のタイトルが80文字を超えていたため省略しました。','Title')";
			$errorMsg = $errorMsg."<br>商品番号「".$obj->product_no."」のタイトルが80文字を超えていたため省略しました。";
			$new_log_id++;
		}

		$Pic_URL = explode('/[\r\n\s]+/', $obj -> img_url);
		$Pic_URL = implode('|', $Pic_URL);
		if ($use_pc_introduce) {
			//英訳
			$obj->pc_introduce = $trans->trans($obj -> pc_introduce, 'ja', 'en');
			//ｃｍをインチに変換
			$obj->pc_introduce = preg_replace_callback('/[0-9¥.]+cm/', 'trans_cm2inch', $obj->pc_introduce);
			//mmをインチに変換
			$obj->pc_introduce = preg_replace_callback('/[0-9¥.]+mm/', 'trans_mm2inch', $obj->pc_introduce);
		}
		if ($use_pc_promote) {
			//英訳
			$obj->pc_promote = $trans->trans($obj -> pc_promote, 'ja', 'en');
			//ｃｍをインチに変換
			$obj->pc_promote = preg_replace_callback('/[0-9¥.]+cm/', 'trans_cm2inch', $obj->pc_promote);
			//mmをインチに変換
			$obj->pc_promote = preg_replace_callback('/[0-9¥.]+mm/', 'trans_mm2inch', $obj->pc_promote);
		}
		$Description = $header_html;
		if ($use_pc_introduce) {
			$Description .= $obj -> pc_introduce;
		}
		if ($use_pc_introduce && $use_pc_promote) {
			$Description .= $split_html;
		}
		if ($use_pc_promote) {
			$Description .= $obj -> pc_promote;
		}
		$Description .= $footer_html;
		$Description = preg_replace('/[￡％＃＆＊＠§☆★○●◎◇◆□■△▲▽▼、。，．・：；？！゛゜´｀¨＾￣＿ヽヾゝゞ〃仝々〆〇ー―‐／＼～∥｜…‥‘’“”（）〔〕［］｛｝〈〉《》「」『』【】＋－±×÷＝≠＜＞≦≧∞∴♂♀°′″℃￥＄￠※〒→←↑↓〓∈∋⊆⊇⊂⊃∪∩∧∨￢⇒⇔∀∃∠⊥⌒∂∇≡≒≪≫√∽∝∵∫∬Å‰♯♭♪†‡¶◯ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩαβγδεζηθικλμνξοπρστυφχψωАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя─│┌┐┘└├┬┤┴┼━┃┏┓┛┗┣┳┫┻╋┠┯┨┷┿┝┰┥┸╂①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩ�㍉㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫㍊㌻㎜㎝㎞㎎㎏㏄㎡㍻〝〟№㏍℡㊤㊥㊦㊧㊨㈱㈲㈹㍾㍽㍼≒≡∫∮∑√⊥∠∟⊿∵∩∪]+/u', '', $Description);
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


		$Condition_Description = "";
		$Condition_ID = '1000';
		foreach ($condition_mst as $cond) {
			if ($obj -> tag_id == $cond['tag_id']) {	//主にタグIDが空欄の場合に
				$Condition_Description = $cond['condition_des'];
				$Condition_ID = $cond['ebay_condition_id'];
				break;
			}

			if ($cond['tag_id'] && preg_match('/'.preg_quote($cond['tag_id'],'/').'/', $obj -> tag_id)) {
				$Condition_Description = $cond['condition_des'];
				$Condition_ID = $cond['ebay_condition_id'];
				break;
			}
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
			//ログ
			$column=$obj -> column_name;
			$logs[] = "('".$db->esc($username)."',".$db->esc($new_log_id).", 2, '楽天ディレクトリID".$db->esc($obj -> directory_id)."とeBayCategoreIDが紐づいていません。','".$db->esc($column)."')";
			$errorMsg = $errorMsg."<br>楽天ディレクトリID".$obj -> directory_id."がeBayカテゴリIDと紐づいていません。";
			$new_log_id++;
		}
	}
	$all = $new_id + $new_log_id -2;
	$new_id=$new_id-1;
	$email = $username;
	if($username == ADMIN){
		$email = ADMIN_EMAIL;
	}
	$db -> senddone($username, strval($new_id), $email);

	//完了ログ
	$logs[] = "('".$db->esc($username)."',".$db->esc($new_log_id).", 5, 'eBayデータへの変換が完了しました。','')";

	//ログをまとめてDBに保存
	$sql = "insert into log_tbl (username, log_id, msg_flg, msg, column_name) values ". implode(',', $logs);
	$rc3 = $db -> Exec($sql);
	if(!rc3) {
		$message = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $sql;
		die($message);
	}

	$db -> close();

	var_dump('finished.');
}


//楽天ディレクトリIDをebayカテゴリIDに変換
function changeCat($db,$rk_dir_id, $username) {

	$sql = "select * from  `change_mst_tbl` where (username = '".$db->esc($username)."' OR username = '') and rk_dir_id = '".$db->esc($rk_dir_id)."' AND ebay_cat_id != '' ORDER BY username DESC LIMIT 1";

	$rc = $db -> Exec($sql);

	if($obj = $db -> fetch_object($rc)) {
		return $obj -> ebay_cat_id;
	}else{
		return "";
	}
}


//キーワード・英訳辞書の変換を実行
function convertString(&$string_mst, &$row) {

	foreach ($string_mst as $obj) {

		switch ($obj['change_col']) {
			case 1: $change_text = &$row->product_name; break;
			case 2: $change_text = &$row->pc_promote; break;
			case 3: $change_text = &$row->pc_introduce; break;
		}

		switch ($obj['action_type']) {

			case '追加':
				if ($obj['word_order'] == '語頭'){
					$change_text = $obj['after_str'] . $change_text;
				} else {
					$change_text = $change_text . $obj['after_str'];
				}
				break;

			case '置換':
				$change_text = preg_replace($obj['before_str'], $obj['after_str'], $change_text);
				break;

			case '削除':
				$change_text = preg_replace($obj['before_str'], '', $change_text);
				break;

			case '範囲置換':
				if (preg_match_all('/'.$obj['start_str'].'/u', $change_text, $match, PREG_OFFSET_CAPTURE)) {
					$start_pos = $match[0][$obj['start_str_no']-1][1];
					if (preg_match_all('/'.$obj['end_str'].'/u', $change_text, $match, PREG_OFFSET_CAPTURE, $start_pos)) {
						$end_pos = $match[0][$obj['end_str_no']-1][1] + strlen($match[0][$obj['end_str_no']-1][0]);

						$change_text = substr($change_text, 0, $start_pos).$obj['after_str'].substr($change_text, $end_pos);
					}
				}
				break;
		}

	}

}


//cmをインチ変換
function trans_cm2inch($value) {

	preg_match('/[0-9¥.]+/', $value[0], $match);
	//$value[0] = round((float)$match[0] * 0.393700787, 1);
	$value[0] = (float)$match[0] * 0.393700787;

	return round($value[0],1).'inch';
}

//mmをインチ変換
function trans_mm2inch($value) {

	preg_match('/[0-9¥.]+/', $value[0], $match);
	$value[0] = (float)$match[0] * 0.0393700787;

	return round($value[0],1).'inch';
}
?>
