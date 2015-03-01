<?php include('header.php');
	require_once("common/rakuten_header.php");
	$username = $_SESSION["CONVERTER_USERID"];
//	$uploaddir = 'csv/';
	$uploaddir = '/var/www/csv/';
	$uploadfile = $uploaddir .$username."_". $_FILES['item']['name'];
	$GLOBALS['announce'] = '';

	function transferIframe($desc){
		$patterns[0] = '/<iframe src/';
		$patterns[1] = '/<\/iframe>/';
		$replacements[0] = '<object data';
		$replacements[1] = '<\/object>';
		$desc = preg_replace($patterns, $replacements,$desc);
		return $desc;
	}

//楽天CSV取込み
$db = new dbclass();
if (isset($_GET["exec"]) && $_GET["exec"] == "1") {
	if($_FILES['item']['name'] <> "") {
		//アップロードされたCSVを読んで改行コードを統一
		$csv_data = strtr(file_get_contents($_FILES['item']['tmp_name']), array_fill_keys(array("\r\n", "\r", "\n"), "\r\n"));
		//ファイルを保存
		if (file_put_contents($uploadfile, $csv_data)) {
			//DBにインサート
		    insert_data($db,realpath($uploadfile));
			//未登録の楽天ディレクトリIDをあらかじめInsert
			insert_rk_dir($db);
		} else {
		    $GLOBALS['announce'] = "ファイルのアップロードに失敗しました。\n";
		}
	}
}
$db -> close();


function insert_data($db,$uploadfile) {

//$uploadfile="E:/develop/wasabi/ebay/rakuten_item.csv";
//$uploadfile="/var/www/csv/sample.csv";
var_dump('upload');
	$username = $_SESSION["CONVERTER_USERID"];
	//アップロードするデータと重複する既存データを削除
	$sql = "delete from rakuten_item_tbl where username='$username'";
	$db -> Exec($sql);
	$product_nos = array();
	$fp = fopen($uploadfile, 'r');
	while ($res = fgetcsv($fp, 1024)) {
		$product_nos[] = $res[2];
	}
	fclose($fp);
	if (count($product_nos)) {
		$db -> Exec("delete from rakuten_item_tbl where username='".$db->esc($username)."' AND product_no IN ('".implode("','",$product_nos)."')");
	}
	$db -> Exec("set character_set_database=sjis");
	//ヘッダ部読み込み
	$fp = fopen($uploadfile, 'r');
	if($header = fgetcsv($fp)){
		$columnnames = '';
		$setnames = '';
		global $rakuten_csvhead_t;
		$i=0;
		foreach ($header as &$key) {
			$val = $rakuten_csvhead_t[$key];
			if($val && isset($val ) && $val != "") {
			$columnnames = $columnnames."@".$val.",";
			$setnames = $setnames.$val."=@".$val.",";
			}else{
			$columnnames = $columnnames."@tmpclmnm".$i++.",";
			}
		}
		$columnnames = substr($columnnames,0,-1);
		$setnames = substr($setnames,0,-1);

		//最新取込み
		$doubleQ = '"';
// 		$newsql = "LOAD DATA LOCAL INFILE '$uploadfile' REPLACE
// INTO TABLE rakuten_item_tbl
// FIELDS TERMINATED BY ',' ENCLOSED BY '".$doubleQ."'
//  LINES TERMINATED BY '\r\n'
//  IGNORE 1 LINES (".$columnnames.") SET  username='".$db->esc($username)."',".$setnames;
$newsql = "LOAD DATA LOCAL INFILE '$uploadfile' REPLACE
INTO TABLE rakuten_item_tbl
FIELDS TERMINATED BY ',' ENCLOSED BY '".$doubleQ."'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES";
// (".$columnnames.") SET  username='".$db->esc($username)."',".$setnames;

		$result = $db -> Exec($newsql);
var_dump($columnnames);exit;

		if (!$result) {
			$message = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $sql;
			die($message);
		} else {
			$GLOBALS['announce'] .= "データの取込が完了しました。<br />";
		}
	}
	fclose($fp);
		$db -> close();

	}


//未登録のディレクトリIDをeBayカテゴリIDが空欄のまま登録
function insert_rk_dir($db) {

	$username = $_SESSION["CONVERTER_USERID"];

	//登録済みのディレクトリIDの対応表を取得
	$sql = "SELECT rakuten_item_tbl.directory_id, change_mst_tbl.rk_dir_id, change_mst_tbl.ebay_cat_id FROM rakuten_item_tbl LEFT JOIN change_mst_tbl ON rakuten_item_tbl.directory_id = change_mst_tbl.rk_dir_id AND (change_mst_tbl.username = '".$db->esc($username)."' OR change_mst_tbl.username = '') WHERE rakuten_item_tbl.username = '".$db->esc($username)."'";

	$rc = $db -> Exec($sql);

	$insert_array = array();
	while ($obj = $db -> fetch_object($rc)) {
		if ($obj->directory_id && !$obj->rk_dir_id) {
			$insert_array[] = "('$username', '$obj->directory_id', '')";
			$GLOBALS['announce'] .= '楽天ディレクトリID'.$obj->directory_id.'に対応するeBayカテゴリが見つかりませんでした。「<a href="./directory.php">ディレクトリ紐付け設定</a>」でカテゴリの設定を行ってください。<br />';
		}
	}
	//重複するデータを削除
	$insert_array = array_unique($insert_array);

	//未登録のディレクトリIDをeBayカテゴリIDを空欄のまま登録
	if (count($insert_array) > 0) {
		$sql = 'INSERT INTO change_mst_tbl (username, rk_dir_id, ebay_cat_id) VALUES '.implode(',', $insert_array);
		$db->Exec($sql);
	}

}



//取り込み済みのデータ件数を取得
function count_data($db) {

	$username = $_SESSION["CONVERTER_USERID"];

	$sql = "select count(*) as total from `rakuten_item_tbl` where username = '$username'";
	$rc = $db -> Exec($sql);
	while ($obj = $db -> fetch_object($rc)) {
		return $obj->total;
	}
}
?>

<?php
$db = new dbclass();
$username = $_SESSION["CONVERTER_USERID"];
if(isset($_GET["exec"]) && $_GET["exec"] == "2"){
	$sql = "delete from `rakuten_item_tbl` where username = '".$db->esc($username)."'";

	$rc = $db -> Exec($sql);
	if($rc){
		$GLOBALS['announce'] = "既存データの削除が完了しました。";
	}
}
?>

<script type="text/javascript">
  $(function(){

	$(".menu").click(function(){
		var action = $(this).attr('data-action');
		var url = "/mypage/" + action;
		location.href = url;
	});

//	$('#tablefix').tablefix({width: $('#out_Div').width(), height: 700, fixRows: 1, fixCols: 2});

	$('.td_description').click(function(){
		if ($(this).hasClass('description_close')) {
			$(this).removeClass('description_close');
			$(this).addClass('description_swing');
			$(this).animate({
				width: "900px"
				}, 1500, 'swing', function(){
				$(this).removeClass('description_swing');
				$(this).addClass('description_open');
			});

		} else {
			$(this).animate({
				width: "400px"
				}, 1000, 'swing', function(){
				$(this).removeClass('description_open');
				$(this).addClass('description_close');
			});
		}
	});
  });

  function importcsv(){
  	if(document.frm.item.value == "") {
  		alert("商品ファイルを選択してください");
  		document.frm.item.focus();
 		return;
  	}
  	document.frm.action = "import_data.php?exec=1";
  	document.frm.submit();
  }

  function search(){
		if(confirm("取込済みデータを削除しますか？")){
	  	document.frm_delete.action = "import_data.php?exec=2";
	  	document.frm_delete.submit();
	  	}
  }
</script>
<!-- /header -->



<section id="title_space">
<div>
<h2 class="import_data"><span style="font-weight:bold;background:url(img/title_logo_01.png) no-repeat 0 50%;padding:10px 0 10px 50px;background-size:40px 40px;">1. 楽天データの取り込み</span></h2>

<p>
まずは、楽天からダウンロードしてきたCSVファイルを取り込みます。<br>
データ取込には時間がかかる場合がありますが、画面を閉じずにお待ちください。<br>
推奨：固定フォーマット（詳細タイプ）<br>
</p>

</div>
</section>



<div id="content">

<a href="#torikomi_01"><img src="img/icon_q_movie.gif" style="float:right;margin:5px 10px 10px 0;"></a>

<div class="remodal" data-remodal-id="torikomi_01">
<iframe width="500" height="315" src="//www.youtube.com/embed/RXq26WwZ5is" frameborder="0" allowfullscreen></iframe>
<p>
楽天市場からダウンロードした商品データCSVを取り込みます。
</p>
</div>

<br clear="both" />


<?php
//必須項目が未入力のデータを取得
$sql = "select * from `rakuten_item_tbl` where username = '$username' AND (directory_id IS NULL OR tag_id IS NULL OR product_name IS NULL OR sell_price IS NULL OR img_url IS NULL OR stock_quantity IS NULL)";
$rc = $db -> Exec($sql);

while ($obj = $db -> fetch_object($rc)) {
	if (is_null($obj->directory_id)) {
		$GLOBALS['announce'] .= '商品番号'.$obj->product_no.'の「ディレクトリID」が入力されていません。CSVを確認して再度アップロードしてください。<br />';
	}
	if (is_null($obj->tag_id)) {
		$GLOBALS['announce'] .= '商品番号'.$obj->product_no.'の「タグID」が入力されていません。CSVを確認して再度アップロードしてください。<br />';
	}
	if (is_null($obj->product_name)) {
		$GLOBALS['announce'] .= '商品番号'.$obj->product_no.'の「商品名」が入力されていません。CSVを確認して再度アップロードしてください。<br />';
	}
	if (is_null($obj->sell_price)) {
		$GLOBALS['announce'] .= '商品番号'.$obj->product_no.'の「販売価格」が入力されていません。CSVを確認して再度アップロードしてください。<br />';
	}
	if (is_null($obj->img_url)) {
		$GLOBALS['announce'] .= '商品番号'.$obj->product_no.'の「商品画像URL」が入力されていません。CSVを確認して再度アップロードしてください。<br />';
	}
	if (is_null($obj->stock_quantity)) {
		$GLOBALS['announce'] .= '商品番号'.$obj->product_no.'の「在庫数」が入力されていません。CSVを確認して再度アップロードしてください。<br />';
	}
}
?>

<?php if ($GLOBALS['announce']) { ?><div class="attention"><?php echo $GLOBALS['announce']; ?></div><?php } ?>

<form action="import_data.php" name="frm" onsubmit="return confirm(&quot;実行してよろしいですか？&quot;);" enctype="multipart/form-data" id="/mypage/indexIndexForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>
<table class="torikomi">
	<tr>
		<td width="30%"><span>商品ファイル例：<p>dl-itemxxxxxxxxxxxx.csv</p></span></td>
		<td width="40%"><input type="file" name="item"></td>
		<td width="30%" align="right">
		<a href="#" onclick="javascript:importcsv();"><img border=0 src="img/btn_torikomi.gif"></a>
		</td>
	</tr>
</table>
</form>


<p class="">
<span style="color:#ff0000;">ファイル容量が3000商品もしくは30MBを超える場合、取り込めない場合がございます。</p>
</p>





<div align="center" style="margin:20px 0;">
<img src="img/arrow_under.gif" />
</div>

	<form name="frm_delete" method="post">

	 <h2 class="subtitle" align="center">取込済みデータ参照</h2>

	 取込件数：<?php echo count_data($db);?>件


</div><!-- /content -->


	<div id="out_Div">

		 <table id="tablefix" class="import_table">


	<thead>
		 <tr>
			<th style="width:100px">商品管理番号（商品URL）</th>
			<th style="width:100px">商品番号</th>
			<th style="width:100px">全商品ディレクトリID</th>
			<th style="width:100px">タグID</th>
			<th style="width:500px">PC用キャッチコピー</th>
			<th style="width:500px">モバイル用キャッチコピー</th>
			<th style="width:500px">商品名</th>
			<th style="width:100px">販売価格</th>
			<th style="width:100px">表示価格</th>
			<th style="width:100px">消費税</th>
			<th style="width:100px">送料</th>
			<th style="width:100px">倉庫指定</th>
			<th style="width:100px">商品情報レイアウト</th>
			<th>PC用商品説明文</th>
			<th>モバイル用商品説明文</th>
			<th>スマートフォン用商品説明文</th>
			<th>PC用販売説明文</th>
			<th style="width:100px">商品画像URL</th>
			<th style="width:100px">商品画像名（ALT）</th>
			<th style="width:100px">販売期間指定</th>
			<th style="width:100px">在庫タイプ</th>
			<th style="width:100px">在庫数</th>
		 </tr>
	</thead>

	<tbody>
		 <?php
			$sql = "select * from `rakuten_item_tbl` where username = '$username'";
			$rc = $db -> Exec($sql);
			// 成功
			$idx = 1;
			while ($obj = $db -> fetch_object($rc)) {
		 ?>
		 <tr>
			<td align="center"><?php echo_h($obj->product_url);?></td>
			<td align="center"><?php echo_h($obj->product_no);?></td>
			<td align="center"><?php echo_h($obj->directory_id);?></td>
			<td><?php echo_h($obj->tag_id);?></td>
			<td><?php echo_h($obj->pc_tag_line);?></td>
			<td><?php echo_h($obj->mobile_tag_line);?></td>
			<td><?php echo_h($obj->product_name);?></td>
			<td><?php echo_h($obj->sell_price);?></td>
			<td><?php echo_h($obj->show_price);?></td>
			<td><?php echo_h($obj->tax);?></td>
			<td><?php echo_h($obj->postage);?></td>
			<td><?php echo_h($obj->warehouse);?></td>
			<td><?php echo_h($obj->layout);?></td>
			<td><div class="td_description description_close"><?php echo_h($obj->pc_introduce);?></div></td>
			<td><div class="td_description description_close"><?php echo_h($obj->mobile_introduce);?></div></td>
			<td><div class="td_description description_close"><?php echo_h($obj->sp_introduce);?></div></td>
			<td><div class="td_description description_close"><?php echo_h($obj->pc_promote);?></div></td>
			<td><?php echo_h($obj->img_url);?></td>
			<td><?php echo_h($obj->img_name);?></td>
			<td><?php echo_h($obj->sell_duration);?></td>
			<td><?php echo_h($obj->stock_type);?></td>
			<td><?php echo_h($obj->stock_quantity);?></td>
		 </tr>
		 <?php
		 }
				 $db -> close();
		 ?>

	</tbody>
		 </table>


	</div>



	 <br>
	 <div align=center>
	 <input type="button" class="import-delete" onclick="javascript:search();">
	 </div>

	</form>





<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
