<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */




function translateText($string)
{
	
	mb_regex_encoding ('UTF-8');

		//全角文字を半角に
		$string = mb_convert_kana($string, 'Kvrn', 'UTF-8');
		
		//全角スペースを半角に
		$string = preg_replace('/　/', ' ', $string);
		
		//改行文字を別の文字に置き換え
		$string = preg_replace('/[\n]/', "?<newline />", $string);
 
		$result_str = '';
		$split_str = mb_split("[｡!\?。！？]", $string);

		if (count($split_str) > 1) {
			foreach ($split_str as $value) {
				
				$value = trim($value);
				
				if ($value) {
					$data = file_get_contents("http://www.google.co.jp/translate_t?langpair=ja|en&oe=UTF-8&text=".urlencode($value."。"));

					$r = "/<span id=result_box .*?>(.*?)<\/span>/";
					preg_match($r, $data, $m);

					$result_str .= strip_tags($m[1]).' ';
					
				}
			}

		} else {
				$data = file_get_contents("http://www.google.co.jp/translate_t?langpair=ja|en&oe=UTF-8&text=".urlencode($string));

				$r = "/<span id=result_box .*?>(.*?)<\/span>/";
				preg_match($r, $data, $m);

				$result_str = strip_tags($m[1]);
		}


		//置き換え文字を改行文字に置き換え
		$result_str = preg_replace('!<newline />!', "\r\n", $result_str);		

		$result_str = str_replace("&quot;",'"'.'"',$result_str);
		$result_str = str_replace("&amp;",'&',$result_str);
		$result_str = str_replace("&lt;",'<',$result_str);
		$result_str = str_replace("&gt;",'>',$result_str);
		$result_str = str_replace("&nbsp;",' ',$result_str);
		$result_str = str_replace("&copy;",'©',$result_str);
		$result_str = str_replace("&#39;",'\'',$result_str);
		//$result_str = str_replace("<. -.",'<!--',$result_str);
		//$result_str = str_replace("->.",'-->',$result_str);
		//$result_str = str_replace("<I",'<i',$result_str);
		//$result_str = str_replace("</ D",'</d',$result_str);
		//$result_str = str_replace("</ T",'</t',$result_str);
		//$result_str = str_replace("</ ",'</',$result_str);
		
		//ｃｍをインチに変換
		$result_str = preg_replace_callback('/[0-9¥.]+cm/', 'trans_cm2inch', $result_str);

		//mmをインチに変換
		$result_str = preg_replace_callback('/[0-9¥.]+mm/', 'trans_mm2inch', $result_str);		
		
		return $result_str;		
			
}

?>
