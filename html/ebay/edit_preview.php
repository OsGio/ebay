<?php
require_once("common/auth.php");
require_once("common/db.php");
require_once("common/SC_transAPI.php");
//error_reporting(0);
session_start();

$username = $_SESSION["CONVERTER_USERID"];
$db = new dbclass();

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


//翻訳APIインスタンス生成
$sql = "select * from  `user_tbl` where username = '".$db->esc($username)."'";
$user_rc = $db -> Exec($sql);
if ($obj_user = $db -> fetch_object($user_rc)) {
	$trans = new SC_transAPI('203916a788aa313171d9c22e85b82cf9', $obj_user->trans_api_key, $obj_user->trans_api_secret_key);
}

//辞書を取得してマスタへ追加
$res = $trans->dictionary_all('ja', 'en');
foreach ($res as $item) {
	$string_mst[] = array(
		'action_type' => '英訳',
		'before_str' => $item['before_word'],
		'after_str' => $item['after_word'],
	);
}
?>

<table class="edit_preview_table">
 <thead>
	<tr>
	 <th>商品名</th>
	 <th>PC用商品説明文</th>
	 <th>PC用販売説明文</th>
	</tr>
 </thead>

 <tbody>
	 <?php
	 $limit = 20;
	 $page = (int)$_REQUEST['page'];
	 $start = $page * $limit;
	 
	 $sql = "select * from `rakuten_item_tbl` where username = '$username' LIMIT ".$db->esc($start).",".$db->esc($limit);
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

<div id="prev_next_buttons">
<?php
$sql = "select count(*) as total  from `rakuten_item_tbl` where username = '$username'";
$rc = $db -> Exec($sql);
$max = 0;
while ($obj = $db -> fetch_object($rc)) {
	$max = $obj->total;
}

if ($page > 0) {
	echo '<button onclick="preview('.($page-1).')">前の'.$limit.'件</button>';
}
if (ceil($max / $limit) > ($page+1)) {
	echo '<button onclick="preview('.($page+1).')">次の'.$limit.'件</button>';
}
?>
</div>

<?php $db -> close(); ?>


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