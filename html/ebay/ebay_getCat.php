<?php 
	require_once("common/db.php");
$db = new dbclass();
$catetory_id = $_GET["catetory_id"];

if(isset($_GET["get_name"]) && $_GET["get_name"] == "1"){
	$sql = "select * from `ebay_mst` where catetory_id= '".$db->esc($catetory_id)."'" ;
	$rc = $db -> Exec($sql);

	if ($obj = $db -> fetch_object($rc)) {
		$result = $obj -> jp_name. '<br>(' .$obj -> catetory_name. ')';
		echo $result;
	}
	
}else{
	$steps = $_GET["level"];
	$idx = (int)$steps;
	$idx = $idx + 1;
	$sql = "select * from `ebay_mst` where steps= '".$db->esc($idx)."' and father_id = '".$db->esc($catetory_id)."'";
	$rc = $db -> Exec($sql);

	$result = '<SELECT name = "CatMenu_' .$steps .'" size = "14" onChange = "changeMenu(' . $steps . ');">';
	    // 成功
	    $hasData = false;
		while ($obj = $db -> fetch_object($rc)) {
	    $hasData = true;
		$result = $result . '<OPTION value = "'.$obj -> catetory_id . '">'.$obj -> jp_name . '(' .$obj -> catetory_name . ')</OPTION>';
		}
		if(!$hasData){
		$result = $result . '<OPTION value = "-1">-----------------------------------</OPTION>';
			
		}
		$result = $result . "</SELECT>";
	echo $result;
}
	$db -> close();

?>
