<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__));
require_once dirname(__FILE__).'/SC_HTTP_Request2.php';
require_once dirname(__FILE__).'/simple_html_dom.php';



function smarty_modifier_trans2en($string)
{

	if (strlen($string) == 0) {
		return '';
	}
	
	mb_regex_encoding ('UTF-8');

	//全角文字を半角に
	$string = mb_convert_kana($string, 'Kvrn', 'UTF-8');

	//全角スペースを半角に
	$string = preg_replace('/　/', ' ', $string);	
	
	//改行文字を別の文字に置き換え
	$string = preg_replace('/[\n]/', "<newline />", $string);	
	
	//iframeがあればもとのURLを保存・置換
	preg_match_all('/<iframe[0-9a-z="\-_\.\s:;\/\?&]+><\/iframe>/i', $string, $iframe_matches);
	for ($i=0; $i<count($iframe_matches[0]); $i++) {
		$string = preg_replace('!'.preg_quote($iframe_matches[0][$i]).'!i', '<iframe id="iframe_'.$i.'"></iframe>', $string);
	}
	
	//リンクがあればもとのURLを保存・置換
	preg_match_all('/<a[0-9a-z="\-_\.\s:;\/\?&]+>/i', $string, $link_matches);
	for ($i=0; $i<count($link_matches[0]); $i++) {
		$string = preg_replace('!'.preg_quote($link_matches[0][$i]).'!i', '<a id="link_'.$i.'">', $string);
	}
	
	//翻訳する文字列を一時ファイルに保存
	$tmp_filename = tempnam(sys_get_temp_dir(), 'trans_en');
	file_put_contents($tmp_filename, $string);

	$tmp_filename_array = explode('/', $tmp_filename);
	$url = 'http://world-converter.com/ebay/trans_disp.php?tmp_filename='.$tmp_filename_array[count($tmp_filename_array)-1];
//	$url = 'http://wasab.sakura.ne.jp/eBay_converter/trans_disp.php?tmp_filename='.$tmp_filename_array[count($tmp_filename_array)-1];		//テスト環境

//var_dump(sys_get_temp_dir());	
//var_dump($url);
	
	$req = new SC_HTTP_Request2();
	
	//トークンみたいなのを取得
	$tmp_html = $req->get_content('http://translate.google.com/translate?act=url&depth=1&hl=ja&ie=UTF8&prev=_t&rurl=translate.google.co.jp&sl=ja&tl=en&u='.rawurlencode($url));
	preg_match('/usg=([0-9a-z\-_]+)"/i', $tmp_html, $match);


	//翻訳済みページのURLを取得
	$tmp_html = 'http://translate.google.com/translate_p?act=url&hl=ja&ie=UTF8&prev=_t&rurl=translate.google.co.jp&sl=ja&tl=en&depth=2&u='.rawurlencode($url).'&depth=2&usg='.$match[1];
	$header = $req->get_header($tmp_html);
	$encode_url = $header['location'];


	//翻訳済みのHTMLを取得
	$html = $req->get_content($encode_url);


	//Google翻訳が差し込んだ余分なタグを除去
	$dom = str_get_html($html);
	foreach ($dom->find('span.google-src-text') as $google_src_text) {
		$google_src_text->outertext = '';
	}
	foreach ($dom->find('span.notranslate') as $notranslate) {
		$notranslate->class = null;
		$notranslate->onmouseover = null;
		$notranslate->onmouseout = null;
	}
	$dom->find('iframe',0)->outertext = '';
	$tmp_scripts = $dom->find('script');
	$tmp_scripts[count($tmp_scripts)-1]->outertext = '';


	//一時ファイルを削除
	unlink($tmp_filename);
	
	
	//置き換え文字を改行文字に置き換え
	$result_str = preg_replace('!<newline />!', "\r\n", $dom->find('body',0)->innertext);
	
	//置き換えたiframeを元に戻す
	for ($i=0; $i<count($iframe_matches[0]); $i++) {
		$result_str = preg_replace('!<iframe id=iframe_'.$i.'></iframe>!i', $iframe_matches[0][$i], $result_str);
	}

	//置き換えたリンクを元に戻す
	for ($i=0; $i<count($link_matches[0]); $i++) {
		$result_str = preg_replace('!<a id=link_'.$i.'>!i', $link_matches[0][$i], $result_str);
	}	
	
	//無駄なspanタグを除去
	$result_str = preg_replace('!<span>\s+</span>!i', '', $result_str);
	
	//ｃｍをインチに変換
	$result_str = preg_replace_callback('/[0-9¥.]+cm/', 'trans_cm2inch', $result_str);

	//mmをインチに変換
	$result_str = preg_replace_callback('/[0-9¥.]+mm/', 'trans_mm2inch', $result_str);	
	
	return $result_str;
}



//cmをインチ変換
function trans_cm2inch($value) {

	preg_match('/[0-9¥.]+/', $value[0], $match);
	//$value[0] = round((float)$match[0] * 0.393700787, 1);
	$value[0] = (float)$match[0] * 0.393700787;

	return round($value[0],1).'inch';
}

//mmをインチ変換
function trans_mm2inch($value) {

	preg_match('/[0-9¥.]+/', $value[0], $match);
	$value[0] = (float)$match[0] * 0.0393700787;

	return round($value[0],1).'inch';
}
?>
