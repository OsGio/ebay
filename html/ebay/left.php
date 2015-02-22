<?php
	require_once("common/auth.php");
	
	 session_start();
?>
	<div id="leftCol">
	<ul>
		<!-- <li><a href="top.php">マイページ</a></li> -->
		<li><a href="menu.php">メインメニュー</a></li>
		
					<?php
			$username = $_SESSION["CONVERTER_USERID"];
			$db = new dbclass();
			$sql = "select * from `user_tbl` where payed = 1 and username = '".$db->esc($username)."' ";
			$rc = $db -> Exec($sql);

			if($db -> NumRows($rc) > 0) {
			?>

		<li><a href="directory.php">ディレクトリ紐付け設定</a></li>
					<?php
			}
			$db -> close();
			
			?>

		<li><a href="edit.php">変換データ一括編集</a></li>
		<li><a href="log.php">変換ログ参照</a></li>
		<li><a href="setting.php">環境設定</a></li>
		<li><a href="data.php">取込済みデータ参照</a></li>
		<!-- <li><a href="operate.php">操作方法</a></li> -->
		<!-- <li class="anima"><a href="introduce.php">有償機能ご紹介</a></li> -->
		<li class="anima"><a href="applicate.php">有償機能お申込み</a></li>
		<?php
		if($_SESSION["CONVERTER_USERID"] == ADMIN){
			
		?>
		<li><a href="master.php">管理者メニュー</a></li>
		
		<?php
		}
		?>

	</ul>
	  <div  id="ad">
		<p>お問い合わせ先：<br />
		<a href="https://www.facebook.com/wasab.inc" target="_blank">株式会社ワサビ</a><br />
		TEL:-<br />
	  </div>
	</div>
