<?php 
require_once("common/db.php");
require_once("common/SC_transAPI.php");

$db = new dbclass();

$user_tbl = $db->Exec("SELECT * FROM user_tbl WHERE 1");
while ($user = $db->fetch_object($user_tbl)) {

	$username = $user->username;
	var_dump($username);
	
	//適当なパスワード生成
	$password = substr(md5($username.time()), 0, 12);

	//翻訳APIインスタンス生成
	$trans = new SC_transAPI('203916a788aa313171d9c22e85b82cf9');

	//翻訳API代表者登録
	$res = $trans->regist($username, $password, $username, $username);			
	
	$sql = "UPDATE  `user_tbl` SET trans_api_key = '".$db->esc($res->data->api_key)."', trans_api_secret_key = '".$db->esc($res->data->api_secret)."'  WHERE username = '".$db->esc($username)."'";
	$db -> Exec($sql);
	
	
	$trans = new SC_transAPI('203916a788aa313171d9c22e85b82cf9', $res->data->api_key, $res->data->api_secret);
	
	$string_mst_tbl = $db->Exec("SELECT * FROM string_mst_tbl WHERE username = '".$username."' AND action_type = '英訳'");
	while ($string = $db->fetch_object($string_mst_tbl)) {
		var_dump($string);
		$trans->add($string->before_str, $string->after_str, 'ja', 'en', '1');
	}

}

?>
