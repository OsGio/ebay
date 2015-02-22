<?php 
	require_once("common/db.php");
$db = new dbclass();
$directory_id = $_GET["directory_id"];
$_SESSION["HAS_DATA"] = false;
if(isset($_GET["get_name"]) && $_GET["get_name"] == "1"){
	$sql = "select * from `rakuten_mst` where rakuten_dir_id= '".$db->esc($directory_id)."'" ;
	$rc = $db -> Exec($sql);

	if ($obj = $db -> fetch_object($rc)) {
		$result = $obj -> rakuten_dir_name;
		echo $result;
	}
	
}else{
	$steps = $_GET["level"];
	$idx = (int)$steps;
	$idx = $idx + 1;
	$step1 = $_GET["step1"];
	$step2 = $_GET["step2"];
	$step3 = $_GET["step3"];
	$step4 = $_GET["step4"];
	$step5 = $_GET["step5"];
	if($steps == "1") {
		$condition = " step1 = '".$db->esc($step1)."'";
	}else if($steps == "2"){
		$condition = " step1 = '".$db->esc($step1)."' and step2 = '".$db->esc($step2)."'";
	}else if($steps == "3"){
		$condition = " step1 = '".$db->esc($step1)."' and step2 = '".$db->esc($step2)."' and step3 = '".$db->esc($step3)."'";
	}else if($steps == "4"){
		$condition = " step1 = '".$db->esc($step1)."' and step2 = '".$db->esc($step2)."' and step3 = '".$db->esc($step3)."' and step4 = '".$db->esc($step4)."'";
	}else if($steps == "5"){
		$condition = " step1 = '".$db->esc($step1)."' and step2 = '".$db->esc($step2)."' and step3 = '".$db->esc($step3)."' and step4 = '".$db->esc($step4)."' and step5 = '".$db->esc($step5)."'";
	}
	
	$sql = "select distinct step".$db->esc($idx)." as step from `rakuten_mst` where ".$condition;

	$rc = $db -> Exec($sql);

	$result = '<SELECT name = "CatMenu_' .$steps .'" size = "14" onChange = "changeMenu(' . $steps . ');">';
	    // 成功
	    $hasData = false;
		while ($obj = $db -> fetch_object($rc)) {
			$val = $obj -> step;
			if(isset($val) && $val <> "") {
			    $hasData = true;
				$result = $result . '<OPTION value = "'.$val . '">'.$val . '</OPTION>';
			}
		}
		if(!$hasData){
			$sql2 = "select rakuten_dir_id,rakuten_dir_name from `rakuten_mst` where ".$condition;

			$rc2 = $db -> Exec($sql2);
			if ($obj2 = $db -> fetch_object($rc2)) {
				$rakuten_dir_id = $obj2 -> rakuten_dir_id;
				$rakuten_dir_name = $obj2 -> rakuten_dir_name;
				$result = $result . '<OPTION value = "-1">-----------------------------------</OPTION>';
			}
		}
		$result = $result . "</SELECT>";
		if(!$hasData){
			$result = $result . "<div><input type='hidden' name='rakuten_dir_id' id='rakuten_dir_id' value='$rakuten_dir_id'><input type='hidden' id='rakuten_dir_name' name='rakuten_dir_name' value='$rakuten_dir_name'></div>";
		}
	echo $result;
}
	$db -> close();

?>
