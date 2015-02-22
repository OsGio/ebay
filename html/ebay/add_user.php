<?php
	require_once("common/auth.php");
	require_once("common/db.php");
	 session_start();
	$username = $_SESSION["CONVERTER_USERID"];
	if($username != ADMIN){
		header("Location: login.php?errorMsg=管理者権限が必要です。再度ログインしてください。");
	}
	

	$db = new dbclass();
	//商品番号
	if(isset($_GET["exec"]) && $_GET["exec"] == "1"){
		$username = $_POST["userid"];
		$company_name = $_POST["company_name"];
		$user_last_name = $_POST["user_last_name"];
		$user_first_name = $_POST["user_first_name"];
		$tel = $_POST["tel"];
		$rakuten_id = $_POST["rakuten_id"];
		$memo = $_POST["memo"];
		$payed = $_POST["payed"];
			$sql = "update `user_tbl` set  ";
			$hasUp = false;
			if($company_name <> "") {
				$sql = $sql . "company_name= '".$db->esc($company_name)."',";
				$hasUp = true;
			}
			if($user_last_name <> "") {
				$sql = $sql . "user_last_name= '".$db->esc($user_last_name)."',";
				$hasUp = true;
			}
			if($user_first_name <> "") {
				$sql = $sql . "user_first_name= '".$db->esc($user_first_name)."',";
				$hasUp = true;
			}
			if($tel <> "") {
				$sql = $sql . "tel= '".$db->esc($tel)."',";
				$hasUp = true;
			}
			if($rakuten_id <> "") {
				$sql = $sql . "rakuten_id= '".$db->esc($rakuten_id)."',";
				$hasUp = true;
			}
			if($memo <> "") {
				$sql = $sql . "memo= '".$db->esc($memo)."',";
				$hasUp = true;
			}			
			if($payed <> "") {
				$sql = $sql . "payed= '".$db->esc($payed)."',";
				if($payed == "1"){
					$payed_day = date("Y-m-d");
					$sql = $sql . "payed_day= '".$db->esc($payed_day)."',";
				}
				$hasUp = true;
			}
			if($hasUp) {
				$sql = substr($sql,0,strlen($sql) - 1);
				$sql = $sql . " where username = '".$db->esc($username)."' ";
				$db -> Exec($sql);
			}
			$db -> close();

	}
?>

<?php include('header.php'); ?>
<script type="text/javascript">
  function doExec(){
  	var userid=frm.userid.value;
  	document.frm.action = "update_user.php?exec=1&username="+userid;
  	document.frm.submit();
  }
  
</script>
<!-- /header -->
<div id="bread">
	<ul>
		<li><img src="img/icon_home.gif" width="26" height="25" alt="" /></li>
		<li><a href="menu.php"><?php echo_h(STORE_NAME);?></a> > <span>ユーザ設定</span></li>
	</ul>
</div>
<!-- /bread -->

<div id="content">

    <div class="mainCol" id="dataedit">

<h2>ユーザ設定</h2>


<form action="update_user.php" name="frm" method="post">

<div class="mainCol" id="dataedit">


<table>
	<tr>
		<th style="font-size:18px;">ユーザ情報設定</th>
	</tr>

	<tr>
	<td>
		<table class="lineNone">
		<?php

		
		$username=$_GET["username"];
		$company_name="";
		$user_last_name="";
		$user_first_name="";
		$tel="";
		$payed="";
		$rakuten_id="";
		
		$db = new dbclass();
		$sql = "select * from  `user_tbl` where username = '".$db->esc($username)."' ";
		$rc = $db -> Exec($sql);

		if($db -> NumRows($rc) > 0) {
			$obj = $db -> fetch_object($rc);
			
			$username = $obj -> username;
			$company_name = $obj -> company_name;
			$user_last_name = $obj -> user_last_name;
			$user_first_name = $obj -> user_first_name;
			$tel = $obj -> tel;
			$rakuten_id = $obj -> rakuten_id;
			$payed = $obj -> payed;
			$payed0 = "";
			$payed1 = "";
			$payed2 = "";
			$payed3 = "";
			$memo = $obj -> memo;
			
			if($payed == 1){
				$payed1 = "checked";
			}elseif($payed == 2){
				$payed2 = "checked";
			}elseif($payed == 3){
				$payed3 = "checked";
			}elseif($payed == 0){
				$payed0 = "checked";
			}
		}
		$db -> close();
		?>
		<tr><th class="lineNone">ユーザID</th><td><input type="hidden" name = "userid" value="<?php echo_h($username);?>"><?php echo_h($username);?></td></tr>
		<tr><th class="lineNone">ユーザ会社名</th><td><input type="text" name = "company_name" value="<?php echo_h($company_name);?>"></td></tr>
		<tr><th class="lineNone">楽天アカウント</th><td><input type="text" name = "rakuten_id" value="<?php echo_h($rakuten_id);?>"></td></tr>
		<tr>
		<th class="lineNone">ご担当者姓名</th>
		<td><div  class="dataname" ><nobr>(姓)<input type="text" name = "user_last_name" value="<?php echo_h($user_last_name);?>">(名)<input type="text" name = "user_first_name" value="<?php echo_h($user_first_name);?>"></nobr></div></td>
		</tr>

		<tr>
		<th class="lineNone">お電話番号</th>
		<td><input type="text" name = "tel" value="<?php echo_h($tel);?>">
		</tr>

		<tr>
		<th class="lineNone">有償ユーザ</th>
		<td>
		<div  class="dataconfig" >
		<input type="radio" name = "payed" value="0" <?php echo $payed0;?>>未申請<br>
		<input type="radio" name = "payed" value="2" <?php echo $payed2;?>>申請済<br>
		<input type="radio" name = "payed" value="1" <?php echo $payed1;?>>入金済<br>
		<input type="radio" name = "payed" value="3" <?php echo $payed3;?>>期限切れ<br>
		</div>
		</tr>

		<tr><th class="lineNone">ひとことメモ</th><td><textarea name = "memo"><?php echo_h($memo);?></textarea></td></tr>		
		
		<tr>
		<td>
		</td>
		<td>
		<input type="button" onclick="window.location='user.php';" value="戻る">&nbsp;&nbsp;
		<input type="button" onclick="doExec()" name="exec" value="" style="background:url(img/btn_save.png) no-repeat; float:right;width:100px;border:none" />
			</td>
		</tr>
		
	</table>
	</td>
	</tr>
</table>

</div>


</form>

</div>

	<!-- /mainCol -->

</div>


<!-- /content -->


<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
