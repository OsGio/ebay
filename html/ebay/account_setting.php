<?php
	require_once("common/auth.php");
	require_once("common/db.php");
	$username = $_SESSION["CONVERTER_USERID"];

	
	$db = new dbclass();
	
	if (isset($_GET["exec"]) && $_GET["exec"] == "2"){

		//既に存在するかチェック
		$sql = "select username from  `user_tbl` where username = '".$db->esc($username)."' ";
		$password = $_POST["compass"];
		$company_name = $_POST["compname"];
		$user_last_name = $_POST["last_name"];
		$user_first_name = $_POST["first_name"];
		$rakuten_id = $_POST["rakuten_id"];
		$ebay_id = $_POST["ebay_id"];
		$tel = $_POST["tel"];
		
		$rc = $db -> Exec($sql);

		if($db -> NumRows($rc) > 0) {
			$sql = "update `user_tbl` set  ";
			$hasUp = false;
			if($password <> "") {
				$sql = $sql . "password= '".$db->esc($password)."',";
				$hasUp = true;
			}
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
			if($ebay_id <> "") {
				$sql = $sql . "ebay_id= '".$db->esc($ebay_id)."',";
				$hasUp = true;
			}
			if($hasUp) {
				$sql = substr($sql,0,strlen($sql) - 1);
				$sql = $sql . " where username = '".$db->esc($username)."' ";
				$db -> Exec($sql);
				$db -> close();
				
				$GLOBALS['announce'] = "登録が完了しました。";
			}
		}else{
			$db -> close();
		}
	}
	
	

	//登録済みのユーザーデータを取得
	$db = new dbclass();
	$res = $db -> Exec("select * from `user_tbl` where username = '".$db->esc($username)."' ");
	$user = $db -> fetch_object($res);
	$db -> close();
?>

<?php include('header.php'); ?>
<script type="text/javascript">
function doExec(id){
	document.frm.action = "account_setting.php?exec="+id;
	document.frm.submit();
}  

function removeList(obj, id) {

	// tbody要素に指定したIDを取得し、変数「tbody」に代入
	var tbody = document.getElementById("dir-tbody"+id);
	// objの親の親のノードを取得し（つまりtr要素）、変数「tr」に代入
	var tr = obj.parentNode.parentNode;
	// 「tbody」の子ノード「tr」を削除
	tbody.removeChild(tr); 

}
</script>
<!-- /header -->



<section id="title_space">
<div>
<h2 class="directory"><span style="font-weight:bold;background:url(img/title_logo_08.png) no-repeat 0 50%;padding:10px 0 10px 50px;background-size:40px 40px;">アカウント設定</span></h2>

<p>
ご登録いただいたアカウント情報を編集できます。<br>
パスワードの再設定・会社情報の変更等あれば、こちらから手続きをお願いいたします。<br>
</p>

</div>
</section>


<div id="content">

    <div>


<form action="account_setting.php" name="frm" method="post">


<?php if ($GLOBALS['announce']) { ?><div class="attention"><?php echo_h($GLOBALS['announce']); ?></div><?php } ?>



		<table class="datatable">
		<tr>
		<th>アカウント情報</th>
		<td><?php echo_h($username);?></td>
		</tr>

		<tr>
		<th>ログインパスワード</th>
		<td><input type="password"  class="dataconfig" name = "compass" value="<?php echo $user->password; ?>"></td>
		</tr>
		
		<tr>
		<th>貴社名</th>
		<td><input type="text" name = "compname" value="<?php echo $user->company_name; ?>"></td>
		</tr>

		<tr>
		<th>楽天アカウント</th>
		<td><input type="text" name = "rakuten_id" value="<?php echo $user->rakuten_id; ?>"></td>
		</tr>

		<tr>
		<th>eBayアカウント</th>
		<td><input type="text" name = "ebay_id" value="<?php echo $user->ebay_id; ?>"></td>
		</tr>
		
		<tr>
		<th>ご担当者姓名</th>
		<td><div  class="dataname" ><nobr>(姓)<input type="text" name = "last_name" value="<?php echo $user->user_last_name; ?>">(名)<input type="text" name = "first_name" value="<?php echo $user->user_first_name; ?>"></nobr></div></td>
		</tr>

		<tr>
		<th>お電話番号</th>
		<td><div  class="dataconfig" ><input type="text" name = "tel" value="<?php echo $user->tel; ?>"></div>
		</tr>

	</table>

	<div align="center" style="margin:15px 0 20px 0">
		<input type="submit" onclick="doExec('2')" name="exec2" value="保存" class="btn btn-outline btn-lg btn-success" />
	</div>

</form>


</div><!-- /mainCol -->

</div><!-- /content -->







<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
