<?php

	$path = '/var/app/current/ebay/common';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	require_once("Mail.php");

//	require_once(dirname(__FILE__)."/Mail.php");



	DEFINE("ADMIN","wasabi_admin");
	DEFINE("ADMIN_EMAIL","misaki@wasab.net");

	//接続設定
	// define("SMTP_HOST", "email-smtp.us-west-2.amazonaws.com");
	// define("SMTP_PORT", "587");
	// define("SMTP_USER", "AKIAJZ4QLKVYDVWFYX2A");
	// define("SMTP_PSWD", "AlSe05DlHs36rqt+7MiZy2yErjpnma0Mth4JnfOAV6+v");
	// define("SMTP_FROM", "info@world-converter.com");
	// define("SMTP_DEBUG", false); //デバッグ用(true/false)
	define("SMTP_HOST", "localhost");
	define("SMTP_PORT", "");
	define("SMTP_USER", "root");
	define("SMTP_PSWD", "");
	define("SMTP_FROM", "");
	define("SMTP_DEBUG", true); //デバッグ用(true/false)


	if (ereg("db.php", $_SERVER['PHP_SELF'])) {
		header("Location: /");
		exit;
	}
	$z_db = "ebay_converter";
	mb_internal_encoding("utf-8");
	date_default_timezone_set('Asia/Tokyo');


	class dbclass {
		var		$db		;

		function dbclass() {
			global	$_SERVER	;
			global	$z_db		;

			$conn = mysqli_init();
			mysqli_options($conn, MYSQLI_OPT_LOCAL_INFILE, true);
			if(!mysqli_real_connect($conn,'localhost','root', '','ebdb', 3306)){	//テスト環境
//			if(!mysqli_real_connect($conn,'aak52nf9ibdbdv.ca47aqpqqano.ap-northeast-1.rds.amazonaws.com','ebayconverter', '7mTXrwkpCOPFn52U','ebdb', 3306)){	//Amazon RDS
				die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
			}
			if ($this -> db = $conn) {
				mysqli_query($this -> db,"SET NAMES utf8"); //クエリの文字コードを設定
				return TRUE;
			}
			else{
				die('Could not select database.');
				return FALSE;
				}
		}
		function ran() {
				 $strinit = "abcdefghkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ012345679";
		 		$strarray = preg_split("//", $strinit, 0, PREG_SPLIT_NO_EMPTY);
				for ($i = 0, $str = null; $i < 20; $i++) {
					$str .= $strarray[array_rand($strarray, 1)];
				}
				return $str;
		}

		function Exec($SQL) {

			global	$_SERVER	;

			$rc = mysqli_query($this -> db,$SQL);
			if (! $rc) {
					//printf("<pre>%s</pre>%s<br><br>\n", $SQL, pg_ErrorMessage($this -> db));
			}
			return ($rc);
		}

		function NumRows($rc) {

			return (mysqli_num_rows($rc));
		}

		function Fetch_Object($rc, $row="") {

				return mysqli_fetch_object($rc);
		}

		function close() {

			return (mysqli_close($this -> db));

		}

		function esc($string) {
			return mysqli_real_escape_string($this->db, $string);
		}

		function sendmail($username,$isDone,$flg) {

			$fil = "common/registered.txt";
			$title = "[ITEM CONVERTER]アカウントID仮登録";
			$bcc = false;
			if($isDone == 2) {
				$fil = "common/confirmed.txt";
				$title = "[ITEM CONVERTER]アカウントID登録完了";
				$bcc = true;
			}elseif($isDone == 3){
				$fil = "common/pw.txt";
				$title = "[ITEM CONVERTER]パスワード再設定";
			}
			if ($fdc = fopen($fil, "r")) {
				$body = fread($fdc, filesize($fil));
				fclose($fdc);

				$body = ereg_replace("\r", "", $body);
				$body = ereg_replace("%%username%%", $username, $body);
				if($isDone != 2) {
					$body = ereg_replace("%%auth_string%%", $flg, $body);
				}
				mb_internal_encoding("UTF-8");
				mb_language("Japanese");
				return $this->sendmail_ses($username, $title, $body, $bcc);
			}else {
				return false;
			}
		}

		function sendpayed($username,$isuser,$email) {

			$fil = "common/payed_user.txt";
			$title = "[ITEM CONVERTER]有料機能お申込み";
			if($isuser) {
				$fil = "common/payed_user.txt";
			}else{
				$fil = "common/admin_payed.txt";
			}
			if ($fdc = fopen($fil, "r")) {
				$body = fread($fdc, filesize($fil));
				fclose($fdc);

				$body = ereg_replace("\r", "", $body);
				$body = ereg_replace("%%username%%", $username, $body);
				mb_internal_encoding("UTF-8");
				mb_language("Japanese");
				return $this->sendmail_ses($email, $title, $body, true);
			}else {
				return false;
			}
		}

		function senddone($username,$num,$email) {

			$title = "[ITEM CONVERTER]楽天CSV変換完了通知";
			$fil = "common/done.txt";
			if ($fdc = fopen($fil, "r")) {
				$body = fread($fdc, filesize($fil));
				fclose($fdc);

				$body = ereg_replace("\r", "", $body);
				$body = ereg_replace("%%username%%", $username, $body);
				$body = ereg_replace("%%number%%", $num, $body);
				mb_internal_encoding("UTF-8");
				mb_language("Japanese");
				return $this->sendmail_ses($email, $title, $body, false);
			}else {
				return false;
			}
		}

		function senddone2($username,$num,$email,$errorMsg) {

			$title = "[ITEM CONVERTER]eBay出品完了通知";
			$fil = "common/done2.txt";
			if ($fdc = fopen($fil, "r")) {
				$body = fread($fdc, filesize($fil));
				fclose($fdc);

				$body = ereg_replace("\r", "", $body);
				$body = ereg_replace("%%username%%", $username, $body);
				$body = ereg_replace("%%number%%", $num, $body);
				$body = ereg_replace("%%errorMsg%%", $errorMsg, $body);
				mb_internal_encoding("UTF-8");
				mb_language("Japanese");
				return $this->sendmail_ses($email, $title, $body, false);
			}else {
				return false;
			}
		}

		function senddone3($username) {

			$title = "[ITEM CONVERTER]新規アカウント登録通知";
			$fil = "common/done3.txt";
			if ($fdc = fopen($fil, "r")) {
				$body = fread($fdc, filesize($fil));
				fclose($fdc);

				$body = ereg_replace("\r", "", $body);
				$body = ereg_replace("%%username%%", $username, $body);
				mb_internal_encoding("UTF-8");
				mb_language("Japanese");
				return $this->sendmail_ses(SMTP_FROM, $title, $body, false);
			}else {
				return false;
			}
		}

		//Amazon SESでメールを送信
		function sendmail_ses($to, $subject, $body, $bcc_flag=false) {

			//送信文作成
			$from = SMTP_FROM;
			$from = mb_encode_mimeheader("株式会社ワサビ", "ISO-2022-JP", "Q")." <".SMTP_FROM.">";

			//日本語をエンコード
			$body = mb_convert_encoding($body,"iso-2022-jp");
			$subject=mb_encode_mimeheader(mb_convert_encoding($subject,"iso-2022-jp"));

			//SMTPサーバーに接続
			$params = array(
				"host"     => SMTP_HOST,
				"port"     => SMTP_PORT,
				"auth"     => true,
				"username" => SMTP_USER,
				"password" => SMTP_PSWD,
				"debug"    => SMTP_DEBUG,
			);
			$smtp = Mail::factory("smtp", $params);
			if (PEAR::isError($smtp)){
					echo("メールエラー：".$smtp->getMessage());
			}

			//メールヘッダーの生成
			$headers = array(
				"To"      => $to,
				"From"    => $from,
				"Subject" => $subject,
				"Content-Type" => "text/plain; charset=ISO-2022-JP"
			);
			if ($bcc_flag) {
				$headers['Bcc'] = SMTP_FROM;
			}

			//送信
			$return = $smtp->send($to,$headers,$body);
			if (PEAR::isError($return)){
					echo("メール送信エラー：".$return->getMessage());
			} else {
//				echo '送信完了。'.date('Y/m/d H:i:s');
			}

		}
	}
	class prefclass {
		var		$keycd = 0;
		var		$pref = "";
		var		$zcod = 0;

		var		$pref_t = array();
		var		$zcod_t = array();

		function dbread($keycd) {
			global	$db			;

			$retcd = FALSE;
			if ($keycd) {
				$SQL = "SELECT * FROM PREF WHERE KEYCD = $keycd ";
				$rc  = $db -> Exec($SQL);
				if ($db -> NumRows($rc)) {
					$obj = $db -> fetch_object($rc, 0);
					$this -> keycd = $obj -> keycd;
					$this -> pref  = $obj -> pref;
					$this -> zcod  = $obj -> zcod;
					$retcd = TRUE;
				}
			}
			return $retcd;
		}

		function dblist() {
			global	$db			;

			$SQL = "SELECT * FROM PREF ORDER BY KEYCD ";
			$rc  = $db -> Exec($SQL);
			$pc  = $db -> NumRows($rc);
			for ($p = 0; $p < $pc; $p++) {
				$obj = $db -> Fetch_Object($rc, $p);

				$this -> pref_t[$obj -> keycd] = $obj -> pref;
				$this -> zcod_t[$obj -> keycd] = $obj -> zcod;
			}
			$this -> zcod_t[0] = 0;
		}

		function checkbox($n, $v="") {
			global	$db			;

			$fld_t = array();
			$fld_t = split(",", $v);

			$SQL = "SELECT * FROM PREF ORDER BY KEYCD ";
			$rc  = $db -> exec($SQL);
			$pc  = $db -> numrows($rc);
			for ($p = 0; $p < $pc; $p++) {
				$obj = $db -> fetch_object($rc, $p);

				$this -> pref_t[$obj -> keycd]  = $obj -> pref;

				$flg = "";
				for ($p2 = 0; $p2 < sizeof($fld_t); $p2++) {
					if ($obj -> keycd == $fld_t[$p2] * 1) {
						$flg = " checked";
						break;
					}
				}
				printf("<input type='checkbox' name='%s[]' value='%s'%s>%s\n",
														$n, $obj -> keycd, $flg, $obj -> pref);

				if ((($p + 1) % 5) == 0) echo "<br >\n";
			}
		}

		function selectbox($v="") {
			global	$db			;

			$SQL = "SELECT * FROM PREF ORDER BY KEYCD ";
			$rc  = $db -> exec($SQL);
			$pc  = $db -> numrows($rc);
			for ($p = 0; $p < $pc; $p++) {
				$obj = $db -> fetch_object($rc, $p);

				$this -> pref_t[$obj -> keycd]  = $obj -> pref;

				$flg = "";
				if ($obj -> keycd == $v) {
					$flg = " selected";
				}
				printf("<option value='%d'%s>%s</option>\n", $obj -> keycd, $flg, $obj -> pref);
			}
		}
	}

	class dbtemplate {
		var $table  = "";
		var $maxfld = 0;
		var $fld_t  = array();
		var $msg_t  = array();

		var $SQL = "";

		function dbtemplate() {
			$ret = $this -> init();
		}

		function init(){
			//	初期化
			$this -> set_maxfld($this);
			return $this;
		}

		function set_maxfld($obj) {

			$rc   = 0;
			$vars = get_class_vars(get_class($obj)) ;
			while (list($fld, $val) = each($vars)) {
				if (strlen($fld) == 5 || strlen($fld) == 6) {
					$na = strtoupper(substr($fld, 0, 4));
					switch ($na) {
					case 'INFO' :
						$rc++;
						break;
					case 'KEYC' :
						$rc++;
						break;
					default :
						break;
					}
				}
			}
			$this -> maxfld = $rc;
			return $rc;
		}

		function get_field_data() {
			global	$db			;

			if ($this -> table == "") {
				$msg_t[] = "テーブル名を定義してください。";
				return FALSE;
			}

			$this -> SQL = sprintf("
SELECT a.attname, t.typname, a.attlen, a.atttypmod, a.attnotnull, a.atthasdef
FROM pg_class c, pg_attribute a, pg_type t
WHERE c.relname = '%s'
and a.attnum > 0
and a.attrelid = c.oid
and a.atttypid = t.oid
ORDER BY attnum; ",			$this -> table);
			$rc  = $db -> Exec($this -> SQL);
			while ($obj = $db -> Fetch_Object($rc)) {
				$fld = strtoupper($obj -> attname);
				$this -> fld_t[$fld]['type'] = $obj -> typname;
				switch ($obj -> typname) {
				case "char"		:
				case "bpchar"	:
				case "varchar"	:
					$this -> fld_t[$fld]['maxlen'] = $obj -> atttypmod - 4;
					break;
				case "text"		:
					$this -> fld_t[$fld]['maxlen'] = 10240;
					break;
				default			:
					$this -> fld_t[$fld]['maxlen'] = $obj -> attlen;
					break;
				}
			}
		}

		function sessionclear() {

			for ($p = 1; $p <= $this -> maxfld; $p++) {
				$x_fld = sprintf("info%02d", $p);
				$y_fld = sprintf("INFO%02d", $p);
				unset($_SESSION[$y_fld]);
			}
		}

		function sessionread() {

			for ($p = 1; $p <= $this -> maxfld; $p++) {
				$x_fld = sprintf("info%02d", $p);
				$y_fld = sprintf("INFO%02d", $p);
				$this -> {$x_fld} = $_SESSION[$y_fld];
			}
		}

		function sessionwrite() {

			for ($p = 1; $p <= $this -> maxfld; $p++) {
				$x_fld = sprintf("info%02d", $p);
				$y_fld = sprintf("INFO%02d", $p);
				$_SESSION[$y_fld] = $this -> {$x_fld};
			}
		}

		function postread() {
			global	$_POST		;

			extract($_POST);
			for ($p = 1; $p <= $this -> maxfld; $p++) {
				$x_fld = sprintf("info%02d", $p);
				$y_fld = sprintf("INFO%02d", $p);
				$this -> {$x_fld} = strip_tags($_POST[$y_fld]);
			}
		}

		function dbread($keycd) {
			global	$db			;

			$retcd = FALSE;
			if ($keycd) {
				$this -> SQL = sprintf("SELECT * FROM %s WHERE KEYCD = %d ", $this -> table, $keycd);
				$rc  = $db -> Exec($this -> SQL);
				if ($db -> NumRows($rc)) {
					$obj = $db -> Fetch_Object($rc, 0);

					$this -> keycd = $obj -> keycd;
					for ($p = 1; $p <= $this -> maxfld; $p++) {
						$x_fld = sprintf("info%02d", $p);
						$this -> {$x_fld} = $obj -> {$x_fld};
					}
					$retcd = TRUE;
				}
			}
			return $retcd;
		}

		function dbwrite() {
			global	$db			;

			//	初期化
			if (sizeof($this -> fld_t) == 0) {
				$this -> get_field_data();
			}

			//	data adjust
			$keycd = $this -> keycd;

			for ($p = 3; $p < $this -> maxfld; $p++) {
				$x_fld = sprintf("info%02d", $p);
				$y_fld = sprintf("INFO%02d", $p);

				$type = strtolower($this -> fld_t[$y_fld]['type']);
				switch ($type) {
				case 'integer' 		:
				case 'int2'			:
				case 'int4'			:
				case 'numeric'		:
				case 'serial'		:
				case 'bigserial'	:
				case 'real'			:
				case 'float4'		:
				case 'float8'		:
					$$x_fld = __dbsafe2($this -> $x_fld);
					if ($$x_fld == "") $$x_fld = 0;
					break;
				case 'timestamp' :
				case 'time' :
				case 'date' :
				case 'datetime':
					$$x_fld = sprintf("'%s'", __dbsafe2($this -> $x_fld));
					if ($$x_fld == "''") $$x_fld = "NULL";
					break;
				default :
					$$x_fld = sprintf("'%s'", __dbsafe2($this -> $x_fld, $this -> fld_t[$y_fld]['maxlen']));
					break;
				}
			}

			if ($keycd == 0) {					//	新規
				$this -> SQL   = sprintf("SELECT NEXTVAL('%s_KEYCD_SEQ')", $this -> table);
				$rc            = $db -> Exec($this -> SQL);
				$keycd         = $db -> Result($rc, 0, 0);
				$this -> keycd = $keycd;

				$n[] = "keycd";
				$v[] = $keycd;
				$n[] = "info01";
				$v[] = "now()";
				$n[] = "info02";
				$v[] = "now()";
				for ($p = 3; $p < $this -> maxfld; $p++) {
					$va  = sprintf("info%02d", $p);
					$n[] = $va;
					$v[] = $$va;
				}
				$this -> SQL = sprintf("INSERT INTO %s (%s) VALUES (%s) ",
											$this -> table,
											implode(",", $n),
											implode(",", $v)
											);
			}
			else {								//	更新
				$n[] = " INFO02 = now() ";
				for ($p = 3; $p < $this -> maxfld; $p++) {
					$va  = sprintf("info%02d", $p);
					$n[] = sprintf("%s = %s", $va, $$va);
				}
				$this -> SQL = sprintf("UPDATE %s SET %s WHERE KEYCD = %d ",
											$this -> table,
											implode(",", $n),
											$keycd
											);
			}

			$rc = $db -> Exec($this -> SQL);
			return $rc;
		}

		function dbdelete($keycd = 0) {
			global	$db			;

			$rc = FALSE;

			if ($keycd != 0) {
				$this -> SQL = sprintf("UPDATE %s
SET INFO02 = NOW(), INFO03 = 0
WHERE KEYCD = %d",						$this -> table, $keycd);
				$rc = $db -> Exec($this -> SQL);
			}

			return $rc;
		}
	}

	class sa01class extends dbtemplate {
		var		$info42 = "";

		var		$fil_t = array("common/pc.txt", "../common/mb.txt", "../common/mb.txt");

		function sa01class() {

			$this -> table = "sa01";
			$rc = $this -> init();
			return $rc;
		}

	}

	class t_sa01class extends dbtemplate {
		var		$keycd = 0;
		var		$info01 = "";
		var		$info02 = "";
		var		$info03 = 1;
		var		$info04 = 0;
		var		$info05 = 0;
		var		$info06 = 0;
		var		$info07 = "";
		var		$info08 = "";
		var		$info09 = "";
		var		$info10 = "";
		var		$info11 = "";
		var		$info12 = "";
		var		$info13 = "";
		var		$info14 = 0;
		var		$info15 = 0;
		var		$info16 = "";
		var		$info17 = "";
		var		$info18 = "";
		var		$info19 = "";
		var		$info20 = "";
		var		$info21 = "";
		var		$info22 = "";
		var		$info23 = "";
		var		$info24 = "";
		var		$info25 = "";
		var		$info26 = 0;
		var		$info27 = "";
		var		$info28 = "";
		var		$info29 = "";
		var		$info30 = "";
		var		$info31 = "";
		var		$info32 = "";
		var		$info33 = 0;
		var		$info34 = 0;
		var		$info35 = 0;
		var		$info36 = 0;
		var		$info37 = 0;
		var		$info38 = 0;
		var		$info39 = "";
		var		$info40 = "";
		var		$info41 = "";
		var		$info42 = "";

		function t_sa01class() {

			$this -> table = "t_sa01";
			$rc = $this -> init();
			return $rc;
		}

		function auth($e) {
			global	$db		;

			$retcd = FALSE;
			if ($e) {
				$SQL = "SELECT * FROM T_SA01 WHERE INFO39 = '$e' AND INFO03 != 0 ";
				$rc  = $db -> Exec($SQL);
				if ($db -> NumRows($rc)) {
					$obj = $db -> fetch_object($rc, 0);

					$this -> keycd = $obj -> keycd;
					for ($p = 1; $p <= $this -> maxfld; $p++) {
						$x_fld = sprintf("info%02d", $p);
//						$y_fld = sprintf("INFO%02d", $p);
						$this -> {$x_fld} = $obj -> {$x_fld};
					}
					$retcd = TRUE;
				}
			}
			return $retcd;
		}
	}

	class sb01class extends dbtemplate {
		var		$keycd = 0;
		var		$info01 = "";
		var		$info02 = "";
		var		$info03 = 1;
		var		$info04 = "";
		var		$info05 = "";
		var		$info06 = "";
		var		$info07 = "";
		var		$info08 = 0;
		var		$info09 = 0;
		var		$info10 = 0;
		var		$info11 = 0;
		var		$info12 = 0;
		var		$info13 = "";
		var		$info14 = "";
		var		$info15 = "";
		var		$info16 = "";

		function sb01class() {

			$this -> table = "sb01";
			$rc = $this -> init();
			return $rc;
		}

		function dblist() {
			global	$db			;

			$SQL = "SELECT * FROM SB01 ORDER BY KEYCD ";
			$rc  = $db -> Exec($SQL);
			$pc  = $db -> NumRows($rc);
			for ($p = 0; $p < $pc; $p++) {
				$obj = $db -> Fetch_Object($rc, $p);

				$this -> info04_t[$obj -> keycd]  = $obj -> info04;
				$this -> info08_t[$obj -> keycd]  = $obj -> info08;
			}
		}
	}

	class sc01class extends dbtemplate {
		var		$keycd = 0;
		var		$info01 = "";
		var		$info02 = "";
		var		$info03 = 0;
		var		$info04 = 0;
		var		$info05 = 0;
		var		$info06 = 0;
		var		$info07 = "";
		var		$info08 = "";
		var		$info09 = "";
		var		$info10 = "";
		var		$info11 = 0;
		var		$info12 = 0;
		var		$info13 = "";
		var		$info14 = "";
		var		$info15 = "";
		var		$info16 = "";
		var		$info17 = "";
		var		$info18 = "";
		var		$info19 = "";
		var		$info20 = "";
		var		$info21 = 0;
		var		$info22 = 0;
		var		$info23 = 0;
		var		$info24 = 0;
		var		$info25 = "";
		var		$info26 = "";
		var		$info27 = "";
		var		$info28 = "";

		function sc01class() {

			$this -> table = "sc01";
			$rc = $this -> init();
			return $rc;
		}

		function getsccd($info15, $info16, $info34) {
			global	$db			;

			$sccd = "";

			$SQL = "SELECT KEYCD, INFO07 FROM SC01
WHERE INFO04 = $info15
AND INFO08 ~ '$info16'
AND INFO05 = $info34
";

			$rc  = $db -> Exec($SQL);
			if ($obj = $db -> Fetch_Object($rc)) {
				$sccd  = $obj -> info07;
			}

			return $sccd;
		}
	}


	function echo_h($string) {
			echo htmlspecialchars($string, ENT_QUOTES);
	}
?>
