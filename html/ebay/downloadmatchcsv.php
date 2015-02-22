<?php 	
	header('Cache-Control: public');
    header('Pragma: public');
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=transferdata.csv");
	require_once("common/auth.php");
	require_once("common/db.php");
	error_reporting(0);
	 session_start();
	 
	 		if($_SESSION["CONVERTER_USERID"] <> ADMIN){
	 		die('不正アクセス');
}
	$db = new dbclass();
	 
	 	//CSVダウンロード
	$sql = "select * from  `change_mst_tbl` ";
	
	$rc = $db -> Exec($sql);
    
	print "username,rakutenDirId,eBayCategoryId\n";
	while($obj = $db -> fetch_object($rc)) {
		$str= "\"" . $obj ->  username . "\",";
$str=$str. "\"" . $obj ->  rk_dir_id . "\",";
$str=$str. "\"" . $obj ->  ebay_cat_id . "\"\n";
print $str; 
	}
			$db -> close();

?>
