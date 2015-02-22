<?php include('header.php'); 
$username = $_SESSION["CONVERTER_USERID"];
$db = new dbclass();
?>

<style>
input[type="text"] {width: 120px;}
#list_area {
	height: 400px;
	overflow: auto;
	margin-top: 10px;
}
</style>

<script src="js/jquery.bottom.js" type="text/javascript"></script>
<script src="js/feedback_me/js/jquery.feedback_me.js" type="text/javascript"></script>
<link rel="stylesheet" href="js/feedback_me/css/jquery.feedback_me.css" />
<!-- /header -->




<section id="title_space">
<div>
<h2 class="edit_dictionary"><span style="font-weight:bold;background:url(img/title_logo_05.png) no-repeat 0 50%;padding:10px 0 10px 50px;background-size:40px 40px;">英訳辞書登録</span></h2>

<p>
コンバート翻訳時の個別辞書設定ができます。<br>
自動翻訳ではありますが、ユーザー様の思ったとおりの翻訳結果で出ない場合もあります。<br>
その際は、こちらの個別辞書に登録しておくと、ご希望の翻訳結果になります。
</p>

</div>
</section>






<div id="content">

	<script src="js/jquery.tablefix_1.0.1.js" type="text/javascript"></script>
	
    <script type="text/javascript">

//取得するページ
var page = 1;

//ページ数が終端かどうか
var page_terminated = false;

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
	
	
	//スクロールが下まで来たら次ページを自動取得
	$("#list_area").bottom({proximity: 0.05});
	$("#list_area").bind("bottom", function() {
		//ページ数が終端でなければ取得
		if (page_terminated == false) {
			getList();
		}
	});
	
	//まず1ページ目を取得
	getList();

});
	

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

//辞書に追加
function addItem(obj) {
		
	var tr = obj.parentNode.parentNode;
	
	//入力チェック
	if ($('input[name="before_str[]"]', tr).val() == '') {
		alert('日本語側が空欄です。');
	} else if ($('input[name="after_str[]"]', tr).val() == '') {
		alert('英語側が空欄です。');
		
	} else {
		//入力されてれば投げる
		$.ajax({
			type: "POST",
			url: './edit_dictionary_action.php',
			data: 'action=add&before_str='+encodeURI($('input[name="before_str[]"]', tr).val())+'&after_str='+encodeURI($('input[name="after_str[]"]', tr).val()),
			success: function(content){
				var res = JSON.parse(content);
				if (res['code'] == 200) {

					//新しい行を追加
					var new_row = '<tr>';
					new_row += '<td style="width:35%;font-size: 14px; "><input type="text" name="before_str[]" value="'+$('input[name="before_str[]"]', tr).val()+'" class="form-control" style="width:98%;"></td>';
					new_row += '<td style="width:35%;font-size: 14px; "><input type="text" name="after_str[]" value="'+$('input[name="after_str[]"]', tr).val()+'" class="form-control" style="width:98%;"></td>';
					new_row += '<td style="width:5%;font-size: 14px;text-align:center;"><input type="button" value="更新" onclick="updateItem(this,\''+res['data']['before_id']+'\');" class="btn btnEdit"></td>';
					new_row += '<td style="width:5%;font-size: 14px;text-align:center;"><input type="button" value="削除" onclick="removeItem(this,\''+res['data']['before_id']+'\');" class="btn btnDelete"></td>';
					new_row += '</tr>';
					$('#list_area tbody').append(new_row);
					
					//フォームを初期化
					$('input[name="before_str[]"]', tr).val('');
					$('input[name="after_str[]"]', tr).val('');
					
					alert('英訳辞書への追加が完了しました。');

					//最初の100件を取得
					preview(0);					
					
				} else {
					alert('エラー：'+res['message']);
				}
			}
		});
	}

}


//辞書を更新
function updateItem(obj, word_id) {
		
	var tr = obj.parentNode.parentNode;
	
	//入力チェック
	if ($('input[name="before_str[]"]', tr).val() == '') {
		alert('日本語側が空欄です。');
	} else if ($('input[name="after_str[]"]', tr).val() == '') {
		alert('英語側が空欄です。');
		
	} else {
		//入力されてれば投げる
		$.ajax({
			type: "POST",
			url: './edit_dictionary_action.php',
			data: 'action=update&before_str='+encodeURI($('input[name="before_str[]"]', tr).val())+'&after_str='+encodeURI($('input[name="after_str[]"]', tr).val())+'&word_id='+word_id,
			success: function(content){
				var res = JSON.parse(content);	
				if (res['code'] == 200) {
					$('input.btnEdit', tr).attr('onclick', 'updateItem(this,\''+res['data']['before_id']+'\');');
					$('input.btnDelete', tr).attr('onclick', 'removeItem(this,\''+res['data']['before_id']+'\');');
					alert('英訳辞書の更新が完了しました。');
					
					//最初の100件を取得
					preview(0);	
					
				} else {
					alert('エラー：'+res['message']);
				}
			}
		});
	}

}


//辞書から削除
function removeItem(obj, word_id) {
	
	var tr = obj.parentNode.parentNode;
	
	if (window.confirm('「'+$('input[name="before_str[]"]', tr).val()+'」→「'+$('input[name="after_str[]"]', tr).val()+'」を削除します。よろしいですか？')) {

		$.ajax({
			type: "POST",
			url: './edit_dictionary_action.php',
			data: 'action=delete&word_id='+word_id,
			success: function(content){
				var res = JSON.parse(content);				
				if (res['code'] == 200) {

					$(tr).remove();
					
					alert('削除が完了しました。');					
					
					//最初の100件を取得
					preview(0);						
					
				} else {
					alert('エラー：'+res['message']);
				}
			}
		});
		
	}
	
}


//一覧を取得
function getList() {
	$.ajax({
		type: "POST",
		url: './edit_dictionary_action.php',
		data: 'action=list&p='+page,
		success: function(content){
			if (content == 'false') {
				page_terminated = true;
			} else {
				$('#list_area tbody').append(content);
				page++;
			}
		}
	});
}
</script>

    <div class="mainCol" id="datadetail" style="overflow:visible;">

<?php if ($GLOBALS['announce']) { ?><div class="attention"><?php echo_h($GLOBALS['announce']); ?></div><?php } ?>


<form action="edit_dictionary.php" method="post" name="form1">
	<input type="hidden" name="mode" >
	<input type="hidden" name="p" value="<?php echo_h($_REQUEST['p']) ?>" >
	
	<div id="tab_content2">
		
		<div>
			<table style="margin-bottom: 50px;">
			<tr>
				<td style="width:35%;font-size: 14px; "><span class="icon_jap" style="margin:10px;">日本語</span><input type="text" name="before_str[]" value="" class="form-control" style="width: 70%; display: inline;"></td>
				<td style="width:35%;font-size: 14px; "><span class="icon_eng" style="margin:10px;">英語</span><input type="text" name="after_str[]" value="" class="form-control" style="width: 70%; display: inline;"></td>
				<td style="width:5%;font-size: 14px;text-align:center;"><input type=button id="btnEdit" value="追加" onclick="addItem(this);" class="btn"></td>
			</tr>			
			</table>
		</div>

		
		<div id="list_area">
			
			<table id="table1">
			<thead>
			<tr>
			<th style="width:30%;"><span class="icon_jap" style="margin:10px;">日本語</span></th>
			<th style="width:30%;"><span class="icon_eng" style="margin:10px;">英語</span></th>
			<th style="width:5%;padding:10px;">更新</th>
			<th style="width:5%;padding:10px;">削除</th>
			</tr>
			</thead>
			<tbody id="dir-tbody2">
			</tbody>
			</table>
			
		</div>

	</div>
	<!-- tab_content2 -->

</form>


</div><!-- /mainCol -->

</div><!-- /content -->



	<?php $db -> close(); ?>

<div id="footer">
<?php include('footer.php'); ?>

</div>

</body>
</html>