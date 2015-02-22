<?php include('header.php'); 
	$db = new dbclass();
	$username = $_SESSION["CONVERTER_USERID"];
if(isset($_GET["exec"]) && $_GET["exec"] == "1"){
	$sql = "delete from `rakuten_item_tbl` where username = '".$db->esc($username)."'";
	
	$rc = $db -> Exec($sql);
	if($rc){
		echo_h("既存データ削除成功。");
	}
}
?>
<script type="text/javascript">

  function search(){
		if(confirm("取込済みデータを削除しますか？")){
	  	document.frm.action = "data.php?exec=1";
	  	document.frm.submit();
	  	}
  }
</script>
<!-- /header -->
<div id="bread">
	<ul>
		<li><img src="img/icon_home.gif" width="26" height="25" alt="" /></li>
		<li><a href="menu.php"><?php echo_h(STORE_NAME);?></a> > <span>取込済みデータ参照</span></li>
	</ul>
</div>
<!-- /bread -->
<form name="frm" method="post">
<div id="content">

    <div class="mainCol" id="datadetail" style="overflow:visible;">
<div id="dataedit">
<h2>取込済みデータ参照</h2>
</div>
<table id="myTable" border="1">
<thead>
<tr>
<td style="width:10%;font-size: 14px;text-align:center ">No</td>
<td style="width:45%;font-size: 14px;text-align:center ">楽天ディレクトリID</td>
<td style="width:45%;font-size: 14px;text-align:center ">商品名</td>
</tr>
</thead>
<tbody id="dir-tbody">
<?php

	$sql = "select * from `rakuten_item_tbl` where username = '".$db->esc($username)."'";
	
	$rc = $db -> Exec($sql);
    // 成功
    $idx = 1;
	while ($obj = $db -> fetch_object($rc)) {
		

?>
<tr>
<td style="width:10%;font-size: 14px; "><?php echo_h($idx++);?></td>
<td style="width:45%;font-size: 14px; "><?php echo_h($obj -> directory_id);?></td>
<td style="width:45%;font-size: 14px; "><?php echo_h($obj -> product_name);?></td>
</tr>
<?php
}
		$db -> close();
?>
</tbody>
</table>
<br>
<div align=center>
<input type="button" value="　削除　" onclick="javascript:search();">
</div>
 </div>
	<!-- /mainCol -->
<?php include('left.php'); ?>

	<!-- /leftCol -->
</div>


<!-- /content -->
</form>

<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
