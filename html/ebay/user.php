<?php 
	 session_start();
	require_once("common/db.php");
	$username = $_SESSION["CONVERTER_USERID"];
	if($username != ADMIN){
		header("Location: login.php?errorMsg=管理者権限が必要です。再度ログインしてください。");
	}
include('header.php'); 

    if(isset($_GET["exec"]) && $_GET["exec"] == "1" && isset($_GET["username"]) ){
    	$db = new dbclass();

		$username=$_GET["username"];
		$sql = "delete from `user_tbl` where username = '".$db->esc($username)."'";
		$db -> Exec($sql);
		$db -> close();

	}
?>
<script type="text/javascript">

function removeList(username) {
 if(!confirm("このユーザを本当に削除しますか？")) {
 	return;
 }
  	document.frm.action = "user.php?exec=1&username="+username;
  	document.frm.submit();

}

function search() {
	var likeuser = frm.username.value;
	var url = "user.php?exec=2";
	if(likeuser != "") {
		url = url + "&likeuser="+likeuser;
	}
  	document.frm.action = "user.php?exec=2&likeuser="+likeuser;
  	document.frm.submit();

}

</script>
<style>
	td {font-size: 12px}
</style>
<!-- /header -->


<section id="title_space">
<div>
<h2 class="import_data">ユーザー管理</h2>

<p>
登録されているユーザー一覧です。<br>
管理・編集できます。<br>
削除する際は、慎重に！
</p>

</div>
</section>



<form name="frm" method="post" enctype="multipart/form-data">
<div id="content">

    <div class="mainCol" id="datadetail" style="overflow:visible;">


<table>
	<tr>
		<td style="font-size: 14px; "><span>ユーザ名：</span></td>
		<td style="font-size: 14px; "><input type="text" name="username"></td>
	<tr>
	<tr>
		<td style="font-size: 14px; " colspan="2"><center><input class="btn_basic" type=button value="  検索  " onclick="search();"></center></td>
	<tr>
</table>
<br><br>
<!--
<input type=button value="  追加  " onclick="addColumn();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br>
-->
<a href="update_user.php">新規ユーザー登録</a>

<table id="myTable" border="1">
<thead>
<tr>
<td>ユーザID</td>
<td>ユーザ名</td>
<td>会社名</td>
<td>楽天<br>アカウント</td>
<td>eBay<br>アカウント</td>
<td>有料<br>ユーザ</td>
<td>Email<br>認証済み</td>
<td>登録日時</td>
<td>最終ログイン日時</td>
<td>登録動機</td>
<td>ひとことメモ</td>
<td>削除</td>
</tr>
</thead>
<tbody id="dir-tbody">
<?php
$db = new dbclass();
	$sql = "select * from `user_tbl` where is_admin=0 ";
	if(isset($_GET["exec"]) && $_GET["exec"] == "2" && isset($_GET["likeuser"]) ){
		$username = $_GET["likeuser"];
		$sql = $sql . "  and CONCAT (user_last_name,user_first_name)  like '%".$db->esc($username)."%'";
	}
	
	$sql = $sql . "  order by create_time DESC";
	$rc = $db -> Exec($sql);
    // 成功
	while ($obj = $db -> fetch_object($rc)) {
		$payedmsg = "未申請";
		$payed =  $obj -> payed;
		if($payed == 1) {
			$payedmsg = "入金済";
		}else if($payed == 2){
			$payedmsg = "申込済";
		}
		$email_auth =  "認証済";
		$email =  $obj -> registered_flg;
		if($email == 0) {
			$email_auth = "未認証";
		}
?>
<tr>
<td style="width:15%;font-size: 14px; "><a href="update_user.php?username=<?php echo_h($obj -> username);?>"><?php echo_h($obj -> username);?></a></td>
<td><?php echo_h($obj -> user_last_name);?>&nbsp;<?php echo_h($obj -> user_first_name);?></td>
<td><?php echo_h($obj -> company_name);?></td>
<td><?php echo_h($obj -> rakuten_id);?></td>
<td><?php echo_h($obj -> ebay_id);?></td>
<td><?php echo_h($payedmsg);?></td>
<td><?php echo_h($email_auth);?></td>
<td><?php echo_h($obj -> create_time);?></td>
<td><?php echo_h($obj -> last_login);?></td>
<td><?php nl2br(echo_h($obj -> enquete));?></td>
<td><?php nl2br(echo_h($obj -> memo));?></td>
<td><input type=button class="btnDelete" id="btnDelete" value="  削除  " onclick="removeList('<?php echo_h($obj -> username);?>');"></td>
</tr>
<?php
	}
		$db -> close();
?>
</tbody>
</table>
<br>
<!--
<div align=center>
 <a href="#" onclick="javascript:setDir();"><img border=0 src="img/btn_dir.jpg"></a>
</div>
-->
 </div>
	<!-- /mainCol -->

</div>


<!-- /content -->
</form>

<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
