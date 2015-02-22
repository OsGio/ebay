<?php include('header.php'); 
$username = $_SESSION["CONVERTER_USERID"];
$db = new dbclass();

if ($_POST["mode"] == 'edit_type') {	

	$sql = "delete from `string_mst_tbl` where username = '$username'";
	$db -> Exec($sql);
	for($i=0; $i<count($_POST[action_type]); $i++) {
		$before_str = $_POST[before_str][$i];
		$start_str_no = $_POST[start_str_no][$i];
		$after_str = $_POST[after_str][$i];
		$end_str_no = $_POST[end_str_no][$i];
		$action_type = $_POST[action_type][$i];
		$word_order = $_POST[word_order][$i];
		$change_col = $_POST[change_col][$i];
		
		if ($_POST[action_type][$i] == '範囲置換') {
			$before_str = $_POST[start_str][$i].'<<split>>'.$_POST[end_str][$i];
		}
		
		if($before_str <> "" || $after_str <> "") {
			$sql = "insert into `string_mst_tbl`(
				`username` ,
				`before_str` ,
				`start_str_no` ,
				`after_str` ,
				`end_str_no` ,
				`action_type` ,
				`word_order` ,
				`change_col` 
			) values(  '".$db->esc($username)."','".$db->esc($before_str)."','".$db->esc($start_str_no)."','".$db->esc($after_str)."','".$db->esc($end_str_no)."','".$db->esc($action_type)."','".$db->esc($word_order)."','".$db->esc($change_col)."') ";
			$db -> Exec($sql);
		}
	}
	$GLOBALS['announce'] = "変換データ保存完了。";
	
} 


$start_str_no = array('全て','1番目','2番目','3番目','4番目','5番目','6番目','7番目','8番目','9番目','10番目');
$end_str_no = array('全て','1番目','2番目','3番目','4番目','5番目','6番目','7番目','8番目','9番目','10番目');

$start_str_no_html = '<select name="start_str_no[]">';
$end_str_no_html = '<select name="end_str_no[]">';
foreach ($start_str_no as $key=>$value) {
	$start_str_no_html .= '<option value="'.$key.'">'.$value.'</option>';
	$end_str_no_html .= '<option value="'.$key.'">'.$value.'</option>';
}
$start_str_no_html .= '</select>';
$end_str_no_html .= '</select>';




//文中の文字列を正規表現に変換するマスタ
$regex_list = array(
	array('【半角英数】', '[0-9a-zA-Z ]+'),
	array('【半角数字】', '[0-9 ]+'),
	array('【半角英字】', '[a-zA-Z ]+'),
	array('【カタカナ】', '[ァ-ヶー・ ]+'),
	array('【ひらがな】', '[ぁ-んー・ ]+'),
	array('【漢字】', '[一-龠 ]+'),
	array('【全角文字】', '[ぁ-んァ-ヶー一-龠 ]+')
);


//キーワード・英訳辞書を取得
$sql = "SELECT *, CASE change_col WHEN 0 THEN '0' ELSE '1' END as chg, CASE username WHEN 'wasabi_admin' THEN '0' ELSE '1' END as usr FROM string_mst_tbl WHERE (username = '".$db->esc($username)."' OR username = 'wasabi_admin') ORDER BY chg DESC, usr DESC, no ASC";
$tmp_string_mst = $db->Exec($sql);
$string_mst = array();
while ($obj = $db->fetch_object($tmp_string_mst)) {
	if ($obj->action_type == '置換' || $obj->action_type == '削除') {
		$obj->before_str = preg_quote($obj->before_str, '/');
		foreach ($regex_list as $regex) {
			$obj->before_str = preg_replace('/'.$regex[0].'/', $regex[1], $obj->before_str);
		}
		if ($obj->start_str_no) {
			$obj->before_str = '/('.$obj->before_str.'){'.$obj->start_str_no.'}/u';
		} else {
			$obj->before_str = '/'.$obj->before_str.'/u';
		}

	} else if ($obj->action_type == '範囲置換') {
		$split_str = mb_split('<<split>>', $obj->before_str);

		$obj->start_str = preg_quote($split_str[0], '/');
		foreach ($regex_list as $regex) {
			$obj->start_str = preg_replace('/'.$regex[0].'/', $regex[1], $obj->start_str);
		}

		$obj->end_str = preg_quote($split_str[1], '/');
		foreach ($regex_list as $regex) {
			$obj->end_str = preg_replace('/'.$regex[0].'/', $regex[1], $obj->end_str);
		}
	}

	$string_mst[] = (array)$obj;
}
?>

<style>
input[type="text"] {width: 120px;}
</style>
<!-- /header -->


<div id="content">

	<script src="js/jquery.tablefix_1.0.1.js" type="text/javascript"></script>
	
    <script type="text/javascript">

function removeList(obj, id) {
	// tbody要素に指定したIDを取得し、変数「tbody」に代入
	var tbody = document.getElementById("dir-tbody"+id);
	// objの親の親のノードを取得し（つまりtr要素）、変数「tr」に代入
	var tr = obj.parentNode.parentNode;
	// 「tbody」の子ノード「tr」を削除
	tbody.removeChild(tr); 
}

$(function(){	
	$('#tablefix').tablefix({width: $('#out_Div').width(), height: 700, fixRows: 1, fixCols: 0});
});
	
function addColumn(id){
	if (id == 1) {
		$('#dir-tbody1').append('<tr>'+'<td style="width:15%;font-size: 14px; "><select name="action_type[]" onchange="actionChange(this)"><option value="追加">追加</option><option value="削除">削除</option><option value="置換">置換</option><option value="範囲置換">範囲置換</option></select></td>'+'<td style="width:30%;font-size: 14px; ">'+
		'<input type="hidden" name="start_str_no[]"><input type=hidden name="before_str[]"></td><td style="width:30%;font-size: 14px; "><input type=text name="after_str[]"></td>'+
		'<td style="width:10%;font-size: 14px; "><select name="word_order[]"><option value="語頭">語頭</option><option value="語尾">語尾</option></select></td>'+
		'<td style="width:10%;font-size: 14px; "><select name="change_col[]"><option value="1">タイトル</option><option value="2">販売説明</option><option value="3">商品説明</option></select></td><td style="width:5%;font-size: 14px; "><input type=button value="削除" onclick="removeList(this, 1)"></td></tr>');

	} else {
		$('#dir-tbody2').append('<tr>'+ '<input type="hidden" name="action_type[]" value="英訳"><input type="hidden" name="word_order[]"><input type="hidden" name="change_col[]">' + '<td style="width:30%;font-size: 14px; ">'+
		'<input type=text name="before_str[]"></td><td style="width:30%;font-size: 14px; "><input type=text name="after_str[]"></td>'+
		'<td style="width:5%;font-size: 14px; "><input type=button value="削除" onclick="removeList(this, 2)"></td></tr>');
	}
}

function actionChange(obj){
	// tbody要素に指定したIDを取得し、変数「tbody」に代入
	var tbody = document.getElementById("dir-tbody");
	// objの親の親のノードを取得し（つまりtr要素）、変数「tr」に代入
	var tr = obj.parentNode.parentNode;
	var childs = tr.childNodes; 
	var i = 3;
	var j = 5;
	var h = 7;
	if(childs.length == 6) {
		 i = 1;
		 j = 2;
		 h = 3;
	}
	if(obj.value == "追加"){
		childs[i].innerHTML = '<input type="hidden" name="start_str_no[]"><input type=hidden name="before_str[]">';
		childs[j].innerHTML = '<input type=text name="after_str[]">';
		childs[h].innerHTML = '<select name="word_order[]"><option value="語頭">語頭</option><option value="語尾">語尾</option></select>';
	}else if(obj.value == "削除"){
		childs[i].innerHTML = '<?php echo $start_str_no_html;?>の<input type=text name="before_str[]">';
		childs[j].innerHTML = '<input type=text name="after_str[]" value="" readonly>';
		childs[h].innerHTML = '<input type="hidden" name="word_order[]"/>';
	}else if(obj.value == "置換"){
		childs[i].innerHTML = '<?php echo $start_str_no_html;?>の<input type=text name="before_str[]">';
		childs[j].innerHTML = '<input type=text name="after_str[]">';
		childs[h].innerHTML = '<input type="hidden" name="word_order[]"/>';
	}else if(obj.value == "範囲置換"){
		childs[i].innerHTML = '<?php echo $start_str_no_html;?>の<input type=text name="start_str[]">から<?php echo $end_str_no_html;?>の<input type=text name="end_str[]">の間を';
		childs[j].innerHTML = '<input type=text name="after_str[]">';
		childs[h].innerHTML = '<input type="hidden" name="word_order[]"/>';
	}
}
	
function tab_change(id) {
	$('#tab_content1').css('display', 'none');
	$('#tab_content2').css('display', 'none');
	$('ul#tab li').removeClass('selected_tab');

	$('#tab_content'+id).css('display', 'block');
	$('ul#tab li').eq(id-1).addClass('selected_tab');
}
</script>

    <div class="mainCol" id="datadetail" style="overflow:visible;">


<h2><img src="img/title_keyword.gif" alt="キーワード変換" /></h2>


<p class="midashi">
予め追加しておきたいキーワード、もしくは削除したいキーワードを登録できます。<br>
置き換え設定もできるので、あらゆる使い方が可能です。
</p>

<?php if ($GLOBALS['announce']) { ?><div class="attention"><?php echo_h($GLOBALS['announce']); ?></div><?php } ?>


<form action="edit.php" method="post" name="form1">
	<input type="hidden" name="mode" >
	
	<div class="tab_div">
	<ul id="tab">
		<li class="selected_tab"><a href="javascript:tab_change(1);"><span class="edit_keyword">キーワード変換</span></a></li>
		<li><a href="javascript:tab_change(2);"><span class="edit_dic">英語辞書登録</span></a></li>
	</ul>
	</div>
	
	<div id="tab_content1">
		<div class="plus1">
		<input type="button" value="行を追加する" onclick="addColumn(1);">
		</div>

		<table id="table1">
		<thead>
		<tr>
		<th style="width:10%;">種類</th>
		<th style="width:30%;">変換したいキーワード&#8594;</th>
		<th style="width:30%;">&#8594;変換後のキーワード</th>
		<th style="width:10%;">語頭or語尾</th>
		<th style="width:15%;">変換対象</th>
		<th style="width:5%;">削除</th>
		</tr>
		</thead>
		<tbody id="dir-tbody1">
		<?php
			$sql = "select * from `string_mst_tbl` where (username = '".$db->esc($username)."' OR username = 'wasabi_admin') AND NOT action_type LIKE '英訳' ORDER BY no ASC";

			$rc = $db -> Exec($sql);
				// 成功
			while ($obj = $db -> fetch_object($rc)) {
				$action1 = "";
				$action2 = "";
				$action3 = "";
				$action4 = "";
				$action_caption = '';
				$order1 = "";
				$order2 = "";
				$orderc1 = "";
				$orderc2 = "";
				$orderc3 = "";
				$order_caption = '';
				$colum_caption = '';
				switch ($obj -> change_col) {
					case '1': $orderc1 = "selected"; $colum_caption="タイトル"; break;
					case '2': $orderc2 = "selected"; $colum_caption="販売説明"; break;
					case '3': $orderc3 = "selected"; $colum_caption="商品説明"; break;
				}
				if($obj -> word_order == "語頭"){
					$order1 = "selected";
					$order_caption = "語頭";
				}else if($obj -> word_order == "語尾"){
					$order2 = "selected";
					$order_caption = "語尾";
				}
				$orderstr = '<select name="word_order[]"><option value="語頭" '.$order1.'>語頭</option><option value="語尾" '.$order2.'>語尾</option></select>';
				$disabledaft = "";
				$before_type = "text";
				if($obj -> action_type == "追加"){
					$action1 = "selected";
					$before_type = "hidden";
					$action_caption = "追加";
				}else if($obj -> action_type == "削除"){
					$action2 = "selected";
					$orderstr = '<input type="hidden" name="word_order[]"/>';
					$disabledaft = "readonly";
					$action_caption = "削除";
				}else if($obj -> action_type == "置換"){
					$action3 = "selected";
					$orderstr = '<input type="hidden" name="word_order[]"/>';
					$action_caption = "置換";
				}else if($obj -> action_type == "範囲置換"){
					$action4 = "selected";
					$orderstr = '<input type="hidden" name="word_order[]"/>';
					$action_caption = "範囲置換";
					
					$split_str = mb_split('<<split>>', $obj -> before_str);
				}

		?>
			<tr>
			<td style="width:15%;font-size: 14px; ">
				<?php if ($obj->username == $username) { ?>
				<select name="action_type[]" onchange="actionChange(this)"><option value="追加" <?php echo $action1;?>>追加</option><option value="削除" <?php echo $action2;?>>削除</option><option value="置換" <?php echo $action3;?>>置換</option><option value="範囲置換" <?php echo $action4;?>>範囲置換</option></select>
				<?php } else { echo $action_caption; } ?>
			</td>
			<td style="width:35%;font-size: 14px; ">
				<?php if ($obj->username == $username) { ?>
				
					<?php if ($obj -> action_type == "削除" || $obj -> action_type == "置換") { ?>
						<select name="start_str_no[]">
						<?php foreach ($start_str_no as $key=>$value) { ?>
							<option value="<?php echo $key;?>" <?php if ($obj->start_str_no == $key) {?>selected="selected"<?php } ?>><?php echo $value;?></option>
						<?php } ?>
						</select>の
						<input type=<?php echo $before_type;?> name="before_str[]" value="<?php echo htmlspecialchars($obj -> before_str, ENT_COMPAT);?>">
						<input type="hidden" name="end_str_no[]">
						<input type="hidden" name="start_str[]">
						<input type="hidden" name="end_str[]">
						
					<?php } else if ($obj -> action_type == "範囲置換") { ?>
						<select name="start_str_no[]">
						<?php foreach ($end_str_no as $key=>$value) { ?>
							<option value="<?php echo $key;?>" <?php if ($obj->start_str_no == $key) {?>selected="selected"<?php } ?>><?php echo $value;?></option>
						<?php } ?>
						</select>の
						<input type="text" name="start_str[]" value="<?php echo htmlspecialchars($split_str[0], ENT_COMPAT);?>">から
						
						<select name="end_str_no[]">
						<?php foreach ($end_str_no as $key=>$value) { ?>
							<option value="<?php echo $key;?>" <?php if ($obj->end_str_no == $key) {?>selected="selected"<?php } ?>><?php echo $value;?></option>
						<?php } ?>
						</select>の
						<input type="text" name="end_str[]" value="<?php echo htmlspecialchars($split_str[1], ENT_COMPAT);?>">の間
						<input type="hidden" name="before_str[]">
						
					<?php } else { ?>
						<input type="hidden" name="start_str_no[]">
						<input type="hidden" name="end_str_no[]">
						<input type="hidden" name="start_str[]">
						<input type="hidden" name="end_str[]">						
						<input type=<?php echo $before_type;?> name="before_str[]" value="<?php echo htmlspecialchars($obj -> before_str, ENT_COMPAT);?>">
					<?php } ?>
				
				<?php } else { echo htmlspecialchars($obj -> before_str); } ?>
			</td>
			<td style="width:35%;font-size: 14px; ">
				<?php if ($obj->username == $username) { ?>
				<input type=text name="after_str[]" value="<?php echo htmlspecialchars($obj -> after_str, ENT_COMPAT);?>" <?php echo $disabledaft;?>>
				<?php } else { echo_h($obj -> after_str); } ?>
			</td>
			<td style="width:10%;font-size: 14px; ">
				<?php if ($obj->username == $username) { ?>
				<?php echo $orderstr;?>
				<?php } else { echo $order_caption; } ?>
			</td>
			<td style="width:10%;font-size: 14px; ">
				<?php if ($obj->username == $username) { ?>
				<select name="change_col[]"><option value="1" <?php echo $orderc1;?>>タイトル</option><option value="2" <?php echo $orderc2;?>>販売説明</option><option value="3" <?php echo $orderc3;?>>商品説明</option></select>
				<?php } else { echo $colum_caption;} ?>
			</td>
			<td style="width:5%;font-size: 14px; ">
				<?php if ($obj->username == $username) { ?>
				<input type=button class="btnDelete" id="btnDelete" value="削除" onclick="removeList(this, 1);">
				<?php } ?>
			</td>
			</tr>
		<?php } ?>
		</tbody>
		</table>


		<br>



		<div align="center">
		 <input type="image" name="edit_type" src="img/btn_hozon.gif" onclick="document.form1.mode.value='edit_type';document.form1.submit();" />
		</div>

	</div>
	<!-- tab_content1 -->

	
	<div id="tab_content2" style="display:none">
		
		<div class="plus1">
			<input type="button" value="行を追加する" onclick="addColumn(2);">
		</div>

		<table id="table1">
		<thead>
		<tr>
		<th style="width:30%;"><span class="icon_jap">日本語</span></th>
		<th style="width:30%;"><span class="icon_eng">英語</span></th>
		<th style="width:5%;">削除</th>
		</tr>
		</thead>
		<tbody id="dir-tbody2">
		<?php
			$sql = "select * from `string_mst_tbl`  where username = '".$db->esc($username)."' AND action_type LIKE '英訳'";
			$rc = $db -> Exec($sql);
		?>
		<?php while ($obj = $db -> fetch_object($rc)) {	?>
			<tr>
				<input type="hidden" name="action_type[]" value="英訳">
				<input type="hidden" name="word_order[]">
				<input type="hidden" name="change_col[]">
				<td style="width:35%;font-size: 14px; "><input type="text" name="before_str[]" value="<?php echo $obj -> before_str;?>" width="100%"></td>
				<td style="width:35%;font-size: 14px; "><input type="text" name="after_str[]" value="<?php echo $obj -> after_str;?>"></td>
				<td style="width:5%;font-size: 14px; "><input type=button class="btnDelete" id="btnDelete" value="削除" onclick="removeList(this, 2);"></td>
			</tr>
		<?php } ?>
		</tbody>
		</table>


		<br>



		<div align="center">
		 <input type="image" name="edit_type" src="img/btn_hozon.gif" onclick="document.form1.mode.value='edit_type';document.form1.submit();" />
		</div>
		
	</div>
	<!-- tab_content2 -->

</form>


</div><!-- /mainCol -->

</div><!-- /content -->



	<div id="out_Div">

		 <table id="tablefix" class="edit_preview_table">

			<thead>
				 <tr>
					<th style="width:500px">商品名</th>
					<th style="width:1000px">PC用商品説明文</th>
					<th style="width:1000px">PC用販売説明文</th>
				 </tr>
			</thead>

			<tbody>
				<?php
				$sql = "select * from `rakuten_item_tbl` where username = '$username' LIMIT 10";
				$rc = $db -> Exec($sql);
				while ($obj = $db -> fetch_object($rc)) {
					//キーワード・英訳辞書の変換を実行
					convertString($string_mst, $obj);
				?>
				 <tr>
					<td><?php echo_h($obj->product_name);?></td>
					<td style="font-size:80%;"><?php echo_h($obj->pc_introduce);?></td>
					<td style="font-size:80%;"><?php echo_h($obj->pc_promote);?></td>
				 </tr>
				 <?php } ?>
			</tbody>
		 </table>
	</div>

	<?php $db -> close(); ?>

<div id="footer">
<?php include('footer.php'); ?>

</div>

</body>
</html>


<?php
//キーワード・英訳辞書の変換を実行
function convertString(&$string_mst, &$row) {

	foreach ($string_mst as $obj) {

		switch ($obj['change_col']) {
			case 1: $change_text = &$row->product_name; break;
			case 2: $change_text = &$row->pc_promote; break;
			case 3: $change_text = &$row->pc_introduce; break;
		}

		switch ($obj['action_type']) {
			
			case '追加':
				if ($obj['word_order'] == '語頭'){
					$change_text = $obj['after_str'] . $change_text;
				} else {
					$change_text = $change_text . $obj['after_str'];
				}
				break;
				
			case '置換':
				$change_text = preg_replace($obj['before_str'], $obj['after_str'], $change_text);
				break;
			
			case '削除':
				$change_text = preg_replace($obj['before_str'], '', $change_text);
				break;
			
			case '範囲置換':
				if (preg_match_all('/'.$obj['start_str'].'/u', $change_text, $match, PREG_OFFSET_CAPTURE)) {
					$start_pos = $match[0][$obj['start_str_no']-1][1];
					if (preg_match_all('/'.$obj['end_str'].'/u', $change_text, $match, PREG_OFFSET_CAPTURE, $start_pos)) {
						$end_pos = $match[0][$obj['end_str_no']-1][1] + strlen($match[0][$obj['end_str_no']-1][0]);
						
						$change_text = substr($change_text, 0, $start_pos).$obj['after_str'].substr($change_text, $end_pos);
					}					
				}
				break;
			
			case '英訳':
				$row->product_name = preg_replace('/'.preg_quote($obj['before_str'],'/').'/', $obj['after_str'], $row->product_name);
				$row->pc_promote = preg_replace('/'.preg_quote($obj['before_str'],'/').'/', $obj['after_str'], $row->pc_promote);
				$row->pc_introduce = preg_replace('/'.preg_quote($obj['before_str'],'/').'/', $obj['after_str'], $row->pc_introduce);
				break;				
		}
		
	}	

}
?>