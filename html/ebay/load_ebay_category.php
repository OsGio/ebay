<?php include('header.php'); 
$db = new dbclass();
	$username = $_SESSION["CONVERTER_USERID"];
			    insert_data($db,realpath('csv/ebay_category.csv'));
	function insert_data($db,$uploadfile) {


	$username = $_SESSION["CONVERTER_USERID"];
	//既存データ削除
	$sql = "delete from ebay_mst"; 
	$db -> Exec($sql);
	$db -> Exec("set character_set_database=sjis");

	//最新取込み
	$doubleQ = '"';
		$sql = "LOAD DATA LOCAL INFILE '$uploadfile' REPLACE 
		INTO TABLE ebay_mst
		FIELDS TERMINATED BY ',' 
		  (@catetory_id,
		@catetory_name
		)
		SET  
		catetory_id=@catetory_id,
		catetory_name=@catetory_name";
	
		$result = $db -> Exec($sql);
		if (!$result) {
			$message = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $sql;
			die($message);
		}else{
			echo "データ取込成功！";
		}

		$db -> close();

	}
?>
<script type="text/javascript">
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
  
  	$('#dir-tbody').append('<tr><td style="width:50%;">'+
  	'<input type=text name="rk_dir_id[]"></td><td style="width:50%;"><input type=text name="ebay_cat_id[]">'+
  	'</td><td style="width:10%;font-size: 14px; "><input type=button value="削除" onclick="removeList(this)"></td></tr>');
  }


</script>
<!-- /header -->
<div id="bread">
	<ul>
		<li><img src="img/icon_home.gif" width="26" height="25" alt="" /></li>
		<li><a href="menu.php"><?php echo_h(STORE_NAME);?></a> > <span>楽天ディレクトリ取込み</span></li>
	</ul>
</div>
<!-- /bread -->
<form name="frm" method="post" enctype="multipart/form-data">
<div id="content">

    <div class="mainCol" id="datadetail" style="overflow:visible;">
<div id="dataedit">
<h2>楽天ディレクトリ取込み</h2>
</div>
<br><br>
<br>
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
