<?php
require_once("common/HTTP/Request.php");
	
class SC_transAPI {
	
	var $api_key;
	var $api_secret_key;
	var $token;
	var $wasabi_api_hash;
	
	var $api_url = 'http://www.world-honyaku.com/';

	
	function __construct($wasabi_api_hash, $api_key=false, $api_secret_key=false) {
			
		$this->api_key = $api_key;
		$this->api_secret_key = $api_secret_key;
		$this->wasabi_api_hash = $wasabi_api_hash;
		
		//API等が既にある状態なら、アクセストークンを取得
		if ($api_key && $api_secret_key && $wasabi_api_hash) {
			$this->access_token();
		}
	}
	
	
	//代表者登録
	function regist ($name, $password, $mail, $group_name) {

		$req =& new HTTP_Request($this->api_url.'api/regist');
		$req->addHeader("Wasabi-Api-Hash", $this->wasabi_api_hash);
		
		$req->setMethod(HTTP_REQUEST_METHOD_POST);
		$req->addPostData('name', $name);
		$req->addPostData('password', $password);
		$req->addPostData('mail', $mail);
		$req->addPostData('group_name', $group_name);
		
		$response = $req->sendRequest();

		if (PEAR::isError($response)) {
			$json_result = $response->getMessage();
			return false;
		} else {
			$json_result = $req->getResponseBody();
//var_dump($json_result);

			$res = json_decode($json_result);
			
			$this->api_key = $res->data->api_key;
			$this->api_secret_key = $res->data->api_secret;			
			
			return $res;
		}

	}
	
	
	// 既存ユーザのAPIキー&APIシークレットキーを取得
	function get_keys($mail) {

		$req =& new HTTP_Request($this->api_url.'api/reget_keys');
		$req->addHeader("Wasabi-Api-Hash", $this->wasabi_api_hash);
		
		$req->setMethod(HTTP_REQUEST_METHOD_POST);
		$req->addPostData('mail', $mail);

		
		$response = $req->sendRequest();

		if (PEAR::isError($response)) {
			$json_result = $response->getMessage();
			return false;
		} else {
			$json_result = $req->getResponseBody();
//var_dump($json_result);

			$res = json_decode($json_result);
			
			$this->api_key = $res->data->api_key;
			$this->api_secret_key = $res->data->api_secret;
			
			return $res;
		}
		
	}
	
	
	//アクセストークンを取得
	function access_token() {
		
		$req =& new HTTP_Request($this->api_url.'api/access_token');
		$req->addHeader("Wasabi-Api-Hash", $this->wasabi_api_hash);
		
		$req->setMethod(HTTP_REQUEST_METHOD_POST);
		$req->addPostData('key', $this->api_key);
		$req->addPostData('secret', $this->api_secret_key);
		
		$response = $req->sendRequest();

		if (PEAR::isError($response)) {
			$json_result = $response->getMessage();
			return false;
		} else {
			$json_result = $req->getResponseBody();
//var_dump($json_result);
			$res = json_decode($json_result);
			$this->token = $res->data;			
			
			return $res;
		}		
		
	}
	
	
	//登録辞書をページごとに取得
	function dictionary($before_lang, $after_lang, $page=1, $keyword='') {
		
		$req =& new HTTP_Request($this->api_url.'api/dictionary');
		$req->addHeader("Wasabi-Api-Hash", $this->wasabi_api_hash);
		
		$req->setMethod(HTTP_REQUEST_METHOD_POST);
		$req->addPostData('token', $this->token);
		$req->addPostData('before_lang', $before_lang);
		$req->addPostData('after_lang', $after_lang);
		$req->addPostData('page', $page);
		$req->addPostData('keyword', $keyword);
		
		$response = $req->sendRequest();

		if (PEAR::isError($response)) {
			$json_result = $response->getMessage();
			return false;
		} else {
			$json_result = $req->getResponseBody();
//var_dump($json_result);
			$res = json_decode($json_result);	
			
			return $res;
		}
	}
	
	
	//登録辞書をすべて取得
	function dictionary_all($before_lang, $after_lang, $keyword='') {

		$dictionary = array();
		
		//まず1ページ目を取得
		$res = $this->dictionary($before_lang, $after_lang, 1, $keyword);		
		foreach ($res->data->dictionary as $item) {
			$dictionary[] = (array)$item;
		}
		
		//総ページ数を取得
		$page_max = $res->data->page_num + 1;
		
		//2ページ以降があるなら繰り返して取得
		if ($page_max > 1) {
			for ($i=2; $i<=$page_max; $i++) {
				$res = $this->dictionary($before_lang, $after_lang, $i, $keyword);
				foreach ($res->data->dictionary as $item) {
					$dictionary[] = (array)$item;
				}
			}
		}
		
		return $dictionary;
	}
	
	//追加
	function add($before_word, $after_word, $before_lang, $after_lang, $word_type) {

		$req =& new HTTP_Request($this->api_url.'api/dictionary/add');
		$req->addHeader("Wasabi-Api-Hash", $this->wasabi_api_hash);
		
		$req->setMethod(HTTP_REQUEST_METHOD_POST);
		$req->addPostData('token', $this->token);
		$req->addPostData('before_word', $before_word);
		$req->addPostData('after_word', $after_word);
		$req->addPostData('before_lang', $before_lang);
		$req->addPostData('after_lang', $after_lang);
		$req->addPostData('word_type', $word_type);
		
		$response = $req->sendRequest();

		if (PEAR::isError($response)) {
			$json_result = $response->getMessage();
			return false;
		} else {
			$json_result = $req->getResponseBody();
//var_dump($json_result);
			$res = json_decode($json_result);	
			
			return $res;
		}
	}
	
	
	//編集
	function edit($word_id, $after_word, $before_lang, $after_lang) {

		$req =& new HTTP_Request($this->api_url.'api/dictionary/edit');
		$req->addHeader("Wasabi-Api-Hash", $this->wasabi_api_hash);
		
		$req->setMethod(HTTP_REQUEST_METHOD_POST);
		$req->addPostData('token', $this->token);
		$req->addPostData('word_id', $word_id);
		$req->addPostData('after_word', $after_word);
		$req->addPostData('before_lang', $before_lang);
		$req->addPostData('after_lang', $after_lang);
		
		$response = $req->sendRequest();

		if (PEAR::isError($response)) {
			$json_result = $response->getMessage();
			return false;
		} else {
			$json_result = $req->getResponseBody();
//var_dump($json_result);
			$res = json_decode($json_result);	
			
			return $res;
		}
	}
	

	//削除
	function delete($word_id, $before_lang, $after_lang) {

		$req =& new HTTP_Request($this->api_url.'api/dictionary/delete');
		$req->addHeader("Wasabi-Api-Hash", $this->wasabi_api_hash);
		
		$req->setMethod(HTTP_REQUEST_METHOD_POST);
		$req->addPostData('token', $this->token);
		$req->addPostData('word_id', $word_id);
		$req->addPostData('before_lang', $before_lang);
		$req->addPostData('after_lang', $after_lang);
		
		$response = $req->sendRequest();

		if (PEAR::isError($response)) {
			$json_result = $response->getMessage();
			return false;
		} else {
			$json_result = $req->getResponseBody();
//var_dump($json_result);
			$res = json_decode($json_result);	
			
			return $res;
		}
	}
	

	//翻訳
	function trans($query, $before_lang, $after_lang) {

		$req =& new HTTP_Request($this->api_url.'api/trans');
		$req->addHeader("Wasabi-Api-Hash", $this->wasabi_api_hash);
		
		$req->setMethod(HTTP_REQUEST_METHOD_POST);
		$req->addPostData('token', $this->token);
		$req->addPostData('query', $query);
		$req->addPostData('before_lang', $before_lang);
		$req->addPostData('after_lang', $after_lang);
		
		$response = $req->sendRequest();

		if (PEAR::isError($response)) {
			$json_result = $response->getMessage();
			return false;
		} else {
			$json_result = $req->getResponseBody();
echo ($json_result);
			$res = json_decode($json_result);	
			
			return $res->data;
		}
	}
	
}





