<?php
require_once("common/auth.php");
require_once("common/db.php");

session_start();

$username = $_SESSION["CONVERTER_USERID"];

$db = new dbclass();

$sql = "select count(*) as total from `log_tbl` where username = '".$db->esc($username)."'";
$rc = $db -> Exec($sql);
$max = 0;
while ($obj = $db -> fetch_object($rc)) {
	$max = $obj->total;
}

if ($max) {
	echo 'true';
} else {
	echo 'false';
}

$db -> close();