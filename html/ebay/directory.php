<?php include('header.php');
$db = new dbclass();
	$username = $_SESSION["CONVERTER_USERID"];

    if(isset($_GET["exec"]) && $_GET["exec"] == "1"){

		if($username == ADMIN){
			$sql = "delete from `default_change_mst`";
			$db -> Exec($sql);
			for($i=0; $i<count($_POST[rk_dir_id]); $i++) {
			    if(isset($_POST[rk_dir_id][$i])) {
			        $rk_dir_id = $_POST[rk_dir_id][$i];
			        $ebay_cat_id = $_POST[ebay_cat_id][$i];
			        if($rk_dir_id <> "") {

							$sql = "insert into `default_change_mst`(
								`rk_dir_id` ,
								`ebay_cat_id`
							) values( '".$db->esc($rk_dir_id)."','".$db->esc($ebay_cat_id)."') ";
							$db -> Exec($sql);
			        }
			    }
			}
		}

		$sql = "delete from `change_mst_tbl` where username = '".$db->esc($username)."'";
		$db -> Exec($sql);
		for($i=0; $i<count($_POST[rk_dir_id]); $i++) {
				if(isset($_POST[rk_dir_id][$i])) {
						$rk_dir_id = $_POST[rk_dir_id][$i];
						$ebay_cat_id = $_POST[ebay_cat_id][$i];
						if($rk_dir_id <> "") {
				//    	//更新/登録
			//		$sql = "select username from  `change_mst_tbl` where username = '$username'  and  rk_dir_id = '$rk_dir_id'";
			//
			//		$rc = $db -> Exec($sql);
			//		if($db -> NumRows($rc) > 0) {
			//			$sql = "update `change_mst_tbl` set rk_dir_id = '$link_code'  where username = '$username' and  rk_dir_id = '$rk_dir_id'";
			//			$db -> Exec($sql);
			//		}else{

						$sql = "insert into `change_mst_tbl`(
							`username` ,
							`rk_dir_id` ,
							`ebay_cat_id`
						) values(  '".$db->esc($username)."','".$db->esc($rk_dir_id)."','".$db->esc($ebay_cat_id)."') ";
						$db -> Exec($sql);
			//		}
						}
				}
		}
		$db -> close();
		$GLOBALS['announce'] =  "登録が完了しました。\n";

	}elseif(isset($_GET["exec"]) && $_GET["exec"] == "3"){
		if($_FILES['item']['name'] <> "") {

			$uploaddir = 'csv/';
			$uploadfile = $uploaddir .$username."_transfer_". $_FILES['item']['name'];

			if (move_uploaded_file($_FILES['item']['tmp_name'], $uploadfile)) {
			    insert_data($db,realpath($uploadfile));
				unlink($uploadfile);
			} else {
			    $GLOBALS['announce'] =  "ファイルアップロード失敗した!\n";
			}
		}
	}

	function insert_data($db,$uploadfile) {

		$username = $_SESSION["CONVERTER_USERID"];

		if($username == ADMIN){

			//既存データ削除
			$sql = "delete from default_change_mst";
			$db -> Exec($sql);
			$db -> Exec("set character_set_database=sjis");

			//最新取込み
			$doubleQ = '"';
			$sql = "LOAD DATA LOCAL INFILE '$uploadfile' REPLACE
			INTO TABLE default_change_mst
			FIELDS TERMINATED BY ',' ENCLOSED BY '".$doubleQ."'
			 LINES TERMINATED BY '\r\n'
			 IGNORE 1 LINES (@rk_dir_id,
			@ebay_cat_id
			)
			SET
			rk_dir_id=@rk_dir_id,
			ebay_cat_id=@ebay_cat_id";

			$result = $db -> Exec($sql);
			if (!$result) {
				$message = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $sql;
				die($message);
			}else{
				$GLOBALS['announce'] =  "データ取込成功！";
			}
		}

			//既存データ削除
			$sql = "delete from tmp_change_mst_tbl where username='".$db->esc($username)."'";
			$db -> Exec($sql);
			$db -> Exec("set character_set_database=sjis");

			//最新取込み
			$doubleQ = '"';
			$sql = "LOAD DATA LOCAL INFILE '$uploadfile' REPLACE
			INTO TABLE tmp_change_mst_tbl
			FIELDS TERMINATED BY ',' ENCLOSED BY '".$doubleQ."'
			 LINES TERMINATED BY '\r\n'
			 IGNORE 1 LINES (@rk_dir_id,
			@ebay_cat_id
			)
			SET  username='".$username."',
			rk_dir_id=@rk_dir_id,
			ebay_cat_id=@ebay_cat_id";

			$result = $db -> Exec($sql);
			if (!$result) {
				$message = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $sql;
				die($message);
			}else{
				$sql = "select * from tmp_change_mst_tbl where username='".$db->esc($username)."'";

				$rc = $db -> Exec($sql);
			    // 成功
				while ($obj = $db -> fetch_object($rc)) {
					$dirid = $obj -> rk_dir_id;
					$catid = $obj -> ebay_cat_id;
					$sql2 = "select * from `change_mst_tbl` where rk_dir_id = '".$db->esc($dirid)."' and username = '".$db->esc($username)."' ";
					$rc2 = $db -> Exec($sql2);

					if($db -> NumRows($rc2) <= 0) {
						$sql2 = "insert into `change_mst_tbl`(username,rk_dir_id,ebay_cat_id) values('".$db->esc($username)."','".$db->esc($dirid)."','".$db->esc($catid)."') ";
						$db -> Exec($sql2);
					}else{
						$sql2 = "update `change_mst_tbl` set ebay_cat_id='".$db->esc($catid)."' where username = '".$db->esc($username)."' and rk_dir_id = '".$db->esc($dirid)."' ";
						$db -> Exec($sql2);
					}

				}

				$GLOBALS['announce'] =  "データ取込成功！";
			}
		$db -> close();

	}
?>
<script type="text/javascript">
function win(name,width,height,loc)
{

    var newin = window.open(loc,name,'resizable=yes,scrollbars=yes,status=0,width='+width+',height='+height);
    if ( newin.focus!=null ) { newin.focus(); }
}

function addList(obj) {

  // tbody要素に指定したIDを取得し、変数「tbody」に代入
  var tbody = document.getElementById("dir-tbody");
  // objの親の親のノードを取得し（つまりtr要素）、変数「tr」に代入
  var tr = obj.parentNode.parentNode;
  // tbodyタグ直下のノード（行）を複製し、変数「list」に代入
  var list = tbody.childNodes[0].cloneNode(true);
  // 複製した行の2番目のセルを指定し、変数「td」に代入
  var td = list.childNodes[1];
  // 複製した行の2番目のセルの内容を「A」に置き換え
  td.innerHTML = "A";
  //　複製したノード「list」を直後の兄弟ノードの上に挿入
  // （「tr」の下に挿入）
  tbody.insertBefore(list, tr.nextSibling);

}
function removeList(obj) {

  // tbody要素に指定したIDを取得し、変数「tbody」に代入
  var tbody = document.getElementById("dir-tbody");
  // objの親の親のノードを取得し（つまりtr要素）、変数「tr」に代入
  var tr = obj.parentNode.parentNode;
  // 「tbody」の子ノード「tr」を削除
  tbody.removeChild(tr);

}
  $(function(){
    $(".menu").click(function(){
      var action = $(this).attr('data-action');
      var url = "/mypage/" + action;
      location.href = url;
    });
  });
  function addColumn(){

  	$('#dir-tbody').append('<tr><td style="width:15%;">'+
  	'<input type=text name="rk_dir_id[]"><br><input type=button value="検索" onclick="rksearch(this,1);"></td><td style="width:30%;">&nbsp;</td><td style="width:5%;font-size: 14px; "><input type=button value="ID検索 >" class="btn btn-info" onclick="search(this,1);"></td><td style="width:15%;"><input type=text name="ebay_cat_id[]" onchange="setName(this,1);">'+
  	'</td><td style="width:35%;">&nbsp;</td><td style="width:5%;font-size: 14px;text-align:center;"><input type="button" value="削除" onclick="removeList(this)" class="btn"></td></tr>');
  }

  function setName(obj,flg){
  	  if(obj) {
  	  var id = obj.value;
  	  $.ajax({
    url: "ebay_getCat.php?get_name=1&catetory_id=" + id,
    type: "POST",
    timeout: 10000
	}).done(function(data, status, xhr) {
	   setEbay(data,obj,flg);
	}).fail(function(xhr, status, error) {
	});

	 }

  }


  function setDir(){
  	if(confirm("ディレクトリ紐付け設定を保存しますか？")){
	  	document.frm.action = "directory.php?exec=1";
	  	document.frm.submit();
  	}
  }
  function save(){
  	if(confirm("ディレクトリ紐付け設定を保存しますか？")){
	  	document.frm.action = "directory.php?exec=4";
	  	document.frm.submit();
  	}
  }
  var gltd = null;
  var glrktd = null;
  var glflg = 2;
  var glrkflg = 2;
  function search(obj,flg){
  gltd = obj;
  glflg = flg;
   win('ebay_category',1200,500,'ebay_struct.php');
  }
  function rksearch(obj,flg){
  glrktd = obj;
  glrkflg = flg;
   win('rakuten_dir',1200,480,'rakuten_struct.php');
  }
  function setEbay(ebaynm,obj,flg){
	  if(obj) {
	  // objの親の親のノードを取得し（つまりtr要素）、変数「tr」に代入
	  var tr = obj.parentNode.parentNode;
	  // 複製した行の2番目のセルを指定し、変数「td」に代入
	  var ebaynmtag = tr.childNodes[9];
	  if(flg == 1){
	  ebaynmtag = tr.childNodes[4];
	  }
		ebaynmtag.innerHTML = ebaynm;
	 }
  }
  function setFromSub(id,ebaynm){
	  if(gltd) {
	  // alert(id);
	  // objの親の親のノードを取得し（つまりtr要素）、変数「tr」に代入
	  var tr = gltd.parentNode.parentNode;
	  // 複製した行の2番目のセルを指定し、変数「td」に代入
	  var ebayidtag = tr.childNodes[7];
	  // 複製した行の2番目のセルを指定し、変数「td」に代入
	  var ebaynmtag = tr.childNodes[9];
	  if(glflg == 1) {
	  	ebayidtag = tr.childNodes[3];
	  	ebaynmtag = tr.childNodes[4];
	  }
	  var res = '<input type=text name="ebay_cat_id[]" onchange="setName(this,'+glflg+');" value="'+id+'">';
		ebayidtag.innerHTML = res;
		var ebaynmarr = ebaynm.split("(");
		if(ebaynmarr.length && ebaynmarr.length == 2) {
		ebaynm = ebaynmarr[0]+"<br>("+ebaynmarr[1];
		}

		ebaynmtag.innerHTML = ebaynm;
	 }
  }
  function setRakuten(ebaynm,obj,flg){
	  if(obj) {
	  // objの親の親のノードを取得し（つまりtr要素）、変数「tr」に代入
	  var tr = obj.parentNode.parentNode;
	  // 複製した行の2番目のセルを指定し、変数「td」に代入
	  var ebaynmtag = tr.childNodes[2];
	  if(flg == 1){
	  ebaynmtag = tr.childNodes[1];
	  }
		ebaynmtag.innerHTML = ebaynm;
	 }
  }
  function setFromSubRk(id,nm){
	  if(glrktd) {
	  // alert(id);
	  // objの親の親のノードを取得し（つまりtr要素）、変数「tr」に代入
	  var tr = glrktd.parentNode.parentNode;
	  // 複製した行の2番目のセルを指定し、変数「td」に代入
	  var ebayidtag = tr.childNodes[1];
	  // 複製した行の2番目のセルを指定し、変数「td」に代入
	  var ebaynmtag = tr.childNodes[3];
	  var res = '<input type=text name="rk_dir_id[]" value="'+id+'"><br><input type=button value="検索" onclick="rksearch(this,2);">';
	  if(glrkflg == 1) {
	  	ebayidtag = tr.childNodes[0];
	  	ebaynmtag = tr.childNodes[1];
	  }
		ebayidtag.innerHTML = res;
		ebaynmtag.innerHTML = nm;
	 }
  }
    function importcsv(){
  	if(document.frm.item.value == "") {
  		alert("設定CSVファイルを選択してください");
  		document.frm.item.focus();
 		return;
  	}
  	document.frm.action = "directory.php?exec=3";
  	document.frm.submit();
  }

    function download(){
  	document.frm.action = "downloadmatchcsv.php";
  	document.frm.submit();
  }
</script>
<!-- /header -->




<section id="title_space">
<div>
<h2 class="directory"><span style="font-weight:bold;background:url(img/title_logo_06.png) no-repeat 0 50%;padding:10px 0 10px 50px;background-size:40px 40px;">eBayカテゴリ変換 個別設定</span></h2>

<p>
楽天ディレクトリIDをeBayカテゴリに変換する際、ユーザー様ごとに個別に設定ができます。<br>
基本的には自動で変換がされますが、eBayカテゴリに特定しづらいものや該当しないものは、この画面にエラーとして出てきます。<br>
最下部の「保存」をクリックすれば、設定を保存しておくことができます。
</p>

</div>
</section>





<form name="frm" method="post" enctype="multipart/form-data">
<div id="content">

    <div class="mainCol" id="datadetail" style="overflow:visible;">


<?php if ($GLOBALS['announce']) { ?><div class="attention"><?php echo_h($GLOBALS['announce']); ?></div><?php } ?>

<div class="plus1">
<input type=button value="  追加  " onclick="addColumn();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>




<table id="" class="table table-bordered table-striped directory" style="font-size:14px;">
<thead>
<tr>
<th style="width:15%;">楽天ディレクトリID</th>
<th style="width:30%;">楽天ディレクトリ名</th>
<th style="width:5%;background:#e0ffff !important;">eBay検索</th>
<th style="width:15%;background:#e0ffff !important;">eBayカテゴリID</th>
<th style="width:35%;background:#e0ffff !important;">eBayカテゴリ名</th>
<th style="width:5%;">削除</th>
</tr>
</thead>
<tbody id="dir-tbody">
<?php
$db = new dbclass();
	$userid = $_SESSION["CONVERTER_USERID"];
	$sql = "select a.rk_dir_id as rk_dir_id,b.rakuten_dir_name as rakuten_dir_name,a.ebay_cat_id as ebay_cat_id,c.catetory_name as catetory_name,c.jp_name as jp_name from `change_mst_tbl`  a LEFT JOIN `ebay_mst`  c ON a.ebay_cat_id = c.catetory_id,`rakuten_mst`  b  where a.username = '".$db->esc($userid)."' and a.rk_dir_id=b.rakuten_dir_id";

	$rc = $db -> Exec($sql);
    // 成功
	while ($obj = $db -> fetch_object($rc)) {


?>
<tr <?php if (!$obj -> ebay_cat_id) { ?>class="ebay_cat_not_yet"<?php } ?>>
<td><input type=hidden name="rk_dir_id[]" value="<?php echo_h($obj -> rk_dir_id);?>"><?php echo_h($obj -> rk_dir_id);?>
<br><input type=button value="検索" onclick="rksearch(this,2);">
</td>
<td><?php echo_h($obj -> rakuten_dir_name);?></td>
<td><input type="button" value="ID検索 >" class="btn btn-info" onclick="search(this,2);"></td>
<td><input type=text name="ebay_cat_id[]" value="<?php echo_h($obj -> ebay_cat_id);?>" onchange="setName(this,2);"></td>
<td><?php echo_h($obj -> jp_name);?><br>(<?php echo_h($obj -> catetory_name);?>)</td>
<td style="text-align:center;"><input type="button" class="btn" id="btnDelete" value="削除" onclick="removeList(this);"></td>
</tr>
<?php
	}
		$db -> close();
?>
</tbody>
</table>
</div>



<div align=center>

<input type="image" src="img/btn_hozon.gif" onclick="javascript:setDir();"/>

<!-- <input type="button" value="   保存   " onclick="javascript:setDir();"/> -->

<!--  <a href="#" onclick="javascript:setDir();"><img border=0 src="img/btn_dir.jpg"></a>-->
</div>



<h2 class="subtitle">CSV一括登録</h2>

<table class="torikomi2">
	<tr>
		<td><span>変換設定追加CSVファイルを選択：</span></td>
		<td><input type="file" name="item"></td>
		<td align="right">
		<input type="image" src="img/btn_torikomi2.gif" onclick="javascript:importcsv();">
		<?php
		if($_SESSION["CONVERTER_USERID"] == ADMIN){
		?>
		 >><input type="button" onclick="javascript:download();" value="  CSVダウンロード  ">
		<?php }
		?>
		</td>
	</tr>
</table>


<br clear="both">


<div style="margin:5px 0 50px 5px;">
<a href="files/directory-temp.csv" style="background:#dcdcdc;padding:10px 15px;">変換登録サンプルファイルのダウンロード</a>
</div>



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
