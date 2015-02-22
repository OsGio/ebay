<?php include('header.php'); 
$username = $_SESSION["CONVERTER_USERID"];
$db = new dbclass();

if ($_POST["mode"] == 'edit_type') {	

	$sql = "delete from `string_mst_tbl` where username = '$username' AND action_type IN ('追加', '削除', '置換', '範囲置換')";
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
?>

<style>
input[type="text"] {width: 120px;}
</style>

<script src="js/feedback_me/js/jquery.feedback_me.js" type="text/javascript"></script>
<link rel="stylesheet" href="js/feedback_me/css/jquery.feedback_me.css" />

<!-- /header -->





<section id="title_space">
<div>
<h2 class="edit_keyword"><span style="font-weight:bold;background:url(img/title_logo_04.png) no-repeat 0 50%;padding:10px 0 10px 50px;background-size:40px 40px;">キーワード変換（追加・削除・置換）</span></h2>

<p>
タイトル・説明文内のキーワードやタグを一括で変換できます。<br>
追加・削除・置き換えの設定ができ、eBayでより正しい形で出品できるよう変換設定をしていけます。<br>
少し使い方が複雑な部分もございますので、こちらの<a href="http://wasab.net/howto/converter/" target="_blank" style="color:#2ecc71;text-decoration:underline;">ヘルプ</a>からも使い方をご確認ください。
</p>

</div>
</section>




<div id="content">
	
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

	var s = document.styleSheets[0];
	s.insertRule(".feedback_content { width: " + (window.innerWidth - 100) + "px}", 0);
	s.insertRule(".feedback_content.fm_clean.feedback_content_closed.left-top, .feedback_content.fm_clean.feedback_content_closed.left-bottom { margin-left: -" + (window.innerWidth - 100) + "px}", 0);
	s.insertRule(".feedback_trigger.fm_clean.left-top, .feedback_trigger.fm_clean.left-bottom { margin-left: " + (window.innerWidth - 100) + "px}", 0);

	fm_options = {
		show_form : false,
		title_label: '翻訳前プレビュー',
		trigger_label: "Preview",				
		custom_html : '<div id="preview_div">読み込んでいます。。。</div>'
	};

	fm.init(fm_options);
	
	//最初の100件を取得
	preview(0);
});
	
function addColumn(){

		$('#dir-tbody1').append('<tr>'+'<td style="width:15%;font-size: 14px; "><select name="action_type[]" onchange="actionChange(this)"><option value="追加">追加</option><option value="削除">削除</option><option value="置換">置換</option><option value="範囲置換">範囲置換</option></select></td>'+'<td style="width:30%;font-size: 14px; ">'+
		'<input type="hidden" name="start_str_no[]"><input type=hidden name="before_str[]"></td><td style="width:30%;font-size: 14px; "><input type=text name="after_str[]"></td>'+
		'<td style="width:10%;font-size: 14px; "><select name="word_order[]"><option value="語頭">語頭</option><option value="語尾">語尾</option></select></td>'+
		'<td style="width:10%;font-size: 14px; "><select name="change_col[]"><option value="1">タイトル</option><option value="2">販売説明</option><option value="3">商品説明</option></select></td><td style="width:5%;font-size: 14px;text-align:center;"><input type=button value="削除" onclick="removeList(this, 1)" class="btn"></td></tr>');

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
	
function preview(page) {

	$.ajax({
		type: "GET",
		url: './edit_preview.php',
		data: 'page='+page,
		success: function(content){
//			alert(content);
			$('#preview_div').html(content);
			//最初の行へスクロール
			if (page > 0) {
				var p = $("#preview_div").offset().top;
				$('html,body').animate({ scrollTop: p-20 }, {duration: "slow", easing: "swing"});
			}
		}
	});
}
</script>

    <div class="mainCol" id="datadetail" style="overflow:visible;">




<div class="keyword_new">

<h4>「特定キーワード検索」機能で柔軟な変換作業ができるようになりました！</h4>

<p style="margin:5px 20px 15px 20px;">
「http://hogehoge.com/65439879.html」というURLを置換したい時に「65439879.html」の部分が商品によって変わる場合、<br>
「http://hogehoge.com/【半角数字】.html」とすることで、一括で変換ができます。
</p>

<p class="att">
<span>指定できる特定キーワードはこちら >></span>
【半角英数】、【半角英字】、【カタカナ】、【ひらがな】、【漢字】、【全角文字】
</p>


<p class="link"><a href="http://wasab.net/howto/converter/keyword/new-keyword.html" target="_blank">詳しくはヘルプページへ！</a></p>

</div>






<?php if ($GLOBALS['announce']) { ?><div class="attention"><?php echo_h($GLOBALS['announce']); ?></div><?php } ?>


<form action="edit_keyword.php" method="post" name="form1">
	<input type="hidden" name="mode" >
	
	
	<div id="tab_content1">
		<div class="plus1">
		<input type="button" value="行を追加する" onclick="addColumn();">
		</div>

		<table id="table1">
		<thead>
		<tr>
		<th style="width:10%;">種類</th>
		<th style="width:30%;">変換したいキーワード&#8594;</th>
		<th style="width:30%;background:#e0ffff !important;">&#8594;変換後のキーワード</th>
		<th style="width:10%;background:#e0ffff !important;">語頭or語尾</th>
		<th style="width:15%;background:#e0ffff !important;">変換対象</th>
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
			<td style="width:5%;font-size: 14px;text-align:center;">
				<?php if ($obj->username == $username) { ?>
				<input type=button class="btn" id="btnDelete" value="削除" onclick="removeList(this, 1);">
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

</form>


</div><!-- /mainCol -->

</div><!-- /content -->


	<?php $db -> close(); ?>

<div id="footer">
<?php include('footer.php'); ?>

</div>

</body>
</html>