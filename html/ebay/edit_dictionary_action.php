<?php
require_once("common/auth.php");
require_once("common/db.php");
require_once("common/SC_transAPI.php");
//error_reporting(0);
session_start();

$username = $_SESSION["CONVERTER_USERID"];
$db = new dbclass();

$sql = "select * from  `user_tbl` where username = '".$db->esc($username)."'";
$user_rc = $db -> Exec($sql);
if ($obj_user = $db -> fetch_object($user_rc)) {
	$trans = new SC_transAPI('203916a788aa313171d9c22e85b82cf9', $obj_user->trans_api_key, $obj_user->trans_api_secret_key);
} else {
	
}

switch ($_REQUEST["action"]) {	
	case 'add': $res = $trans->add($_REQUEST['before_str'], $_REQUEST['after_str'], 'ja', 'en', '1'); break;
	case 'update': 
		$res = $trans->delete($_REQUEST['word_id'], 'ja', 'en');
		if ($res->code == 200) {
			$res = $trans->add($_REQUEST['before_str'], $_REQUEST['after_str'], 'ja', 'en', '1');
		}
		break;
	case 'delete': $res = $trans->delete($_REQUEST['word_id'], 'ja', 'en'); break;
	case 'list':
		$page = 1;
		if ((int)$_REQUEST['p'] > 0) {
			$page = (int)$_REQUEST['p'];
		}
		$res = $trans->dictionary('ja', 'en', $page);

		if (count($res->data->dictionary)) {
			foreach($res->data->dictionary as $obj) {
				echo '<tr>';
				echo '<td style="width:35%;font-size: 14px; "><input type="text" name="before_str[]" value="'.$obj -> before_word.'" class="form-control" style="width:98%;"></td>';
				echo '<td style="width:35%;font-size: 14px; "><input type="text" name="after_str[]" value="'.$obj -> after_word.'" class="form-control" style="width:98%;"></td>';
				echo '<td style="width:5%;font-size: 14px;text-align:center;"><input type="button" value="更新" onclick="updateItem(this,\''.$obj -> word_id.'\');" class="btn btnEdit"></td>';
				echo '<td style="width:5%;font-size: 14px;text-align:center;"><input type="button" value="削除" onclick="removeItem(this,\''.$obj -> word_id.'\');" class="btn btnDelete"></td>';
				echo '</tr>';
			}			
		} else {
			echo 'false';
		}
		exit();
		break;
}

echo json_encode($res);
?>