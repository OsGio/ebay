<?php include('header.php'); 
$infoSel = "";
$warnSel = "";
if(isset($_POST["log_type"])) {
	if($_POST["log_type"] == "1") {
		$infoSel = " selected";
	}elseif($_POST["log_type"] == "2") {
		$warnSel = " selected";
	}
}
?>
<!-- /header -->



<section id="title_space">
<div>
<h2 class="log">コンバート時のエラーチェック</h2>

<p>
eBayデータへコンバートの際に、エラーがあったかどうかをチェックできます。<br>
古い順に随時削除されていきますので、ご注意ください。<br>
ワンクリック出品時のエラーについては、登録メールアドレスにお送りしますので、そちらでチェックしてください。
</p>

</div>
</section>



<div id="content">

    <div class="mainCol" id="dataImport">


<form style="float:right;" id="changeOption" action="log.php" method="post">
<select name="log_type" onChange="$('#changeOption').submit();">
<option value=""></option>
<option value="1" <?php echo $infoSel;?>>INFO</option>
<option value="2" <?php echo $warnSel;?>>WARNING</option>
</select>
</form>
<table border="1">
<tr>
<th style="width:100px;">no</th><th style="width:25%;">時間</th><th style="white-space:nowrap;width:20%;">カラム名</th><th style="width:55%;">ログ内容</th>
</tr>
<?php
$db = new dbclass();
	$userid = $_SESSION["CONVERTER_USERID"];
	$sql = "select * from  `log_tbl` where username = '".$db->esc($userid)."'";
	if(isset($_POST["log_type"]) && $_POST["log_type"] <> "") {
		$msgFlg = $_POST["log_type"];
		$sql = $sql . " and msg_flg='".$db->esc($msgFlg)."'";
	}
	
	$rc = $db -> Exec($sql);
    // 認証成功
	while ($obj = $db -> fetch_object($rc)) {
		

?>
<tr>
<th style="width:100px;"><?php echo_h($obj -> log_id);?></th>
<th style="width:25%;"><?php echo_h($obj -> create_time);?></th>
<th style="white-space:nowrap;width:20%;"><?php echo_h($obj -> column);?></th>
<th style="width:55%;"><?php echo_h($obj -> msg);?></th>
</tr>
<?php
	}
		$db -> close();
?>
</table>




<div style="margin-top:30px;background:#ededed;text-align:center;padding:20px 0;">
<a href="convert.php">コンバート画面へもどる</a>
</div>





</div>

	<!-- /mainCol -->

</div>


<!-- /content -->


<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
