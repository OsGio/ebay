<?php
require_once dirname(__FILE__).'/HTTP/Request2.php';

class SC_HTTP_Request2
{

	var $cookies;

	var $refere;

	function __construct() {
		$this->cookies = array();
		$this->refere = '';
	}
	
	function init(&$req) {
		$req->setHeader('User-Agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727)');
		$req->setHeader('Accept-Language', 'ja,en-us;q=0.7,en;q=0.3');
		$req->setConfig(array(
			'ssl_verify_host' => false,
			'ssl_verify_peer' => false,
		));
		$req->addCookie("version", phpversion());		
	}
	
	/**
	 * URLのページ内容を取得する
	 * 
	 * 指定したURLのページ内容を取得する。POSTでのパラメータを指定できるほか、Cookieにも対応しているので、ログインしなければアクセスできないページの内容も取得できる。
	 * 
	 * @param string $url 内容を取得したいURL
	 * @param array $data_arry GETおよびPOSTで渡すパラメータ
	 * @return string ページ内容
	 */
	function get_content($url, $data=NULL, $files=NULL) {

		$req =& new HTTP_Request2($url);
		$this->init($req);

		//渡すパラメータをセット
		if (count($data)) {
			foreach($data as $key => $d){
			$req->addPostParameter($key, $d);
			}
			$req->setMethod(HTTP_Request2::METHOD_POST);
		} else {
			$req->setMethod(HTTP_Request2::METHOD_GET);
		}
		
		//POSTするファイルをセット
		if (count($files)) {
			foreach ($files as $file) {
//				$finfo = finfo_open(FILEINFO_MIME_TYPE);
//				$file_content_type = finfo_file($finfo, $file[1]);
//				finfo_close($finfo);
				$req->addUpload($file[0], $file[1], $file[2], $file[3]);
			}
			$req->setMethod(HTTP_Request2::METHOD_POST);
		}
		
		// クッキーをセット
		if(!empty($this->cookies) ){//クッキーが設定しているなら
			foreach($this->cookies as $key=>$c){
				$req->addCookie($key, $c);
			}
		}

		
		//リクエストを送信
		$response = $req->send();
		
		//Cookieを保存
		$cookies =$response->getCookies();
		foreach ($cookies as $cookie) {
			$this->cookies[$cookie['name']] = $cookie['value'];
		}
		
		//リファラを設定
		$this->refere = $url;
//var_dump($req);		
		return $response->getBody();
	}

	

	/**
	 * URLのページ内容を取得する
	 * 
	 * 指定したURLのページ内容を取得する。POSTでのパラメータを指定できるほか、Cookieにも対応しているので、ログインしなければアクセスできないページの内容も取得できる。
	 * 
	 * @param string $url 内容を取得したいURL
	 * @param array $data_arry GETおよびPOSTで渡すパラメータ
	 * @return string ページ内容
	 */
	function get_content2($url, $body) {

		$req =& new HTTP_Request2($url);
		$this->init($req);

		//渡すパラメータをセット
		$req->setMethod(HTTP_Request2::METHOD_POST);
		$req->setBody($body);
		
		// クッキーをセット
		if(!empty($this->cookies) ){//クッキーが設定しているなら
			foreach($this->cookies as $key=>$c){
				$req->addCookie($key, $c);
			}
		}

		
		//リクエストを送信
		$response = $req->send();
		
		//Cookieを保存
		$cookies =$response->getCookies();
		foreach ($cookies as $cookie) {
			$this->cookies[$cookie['name']] = $cookie['value'];
		}
		
		//リファラを設定
		$this->refere = $url;
//var_dump($req);		
		return $response->getBody();
	}

	

	/**
	 * URLのヘッダを取得する
	 * 
	 * 指定したURLのページ内容を取得する。POSTでのパラメータを指定できるほか、Cookieにも対応しているので、ログインしなければアクセスできないページの内容も取得できる。
	 * 
	 * @param string $url 内容を取得したいURL
	 * @param array $data_arry GETおよびPOSTで渡すパラメータ
	 * @return string ページ内容
	 */
	function get_header($url, $data=NULL, $files=NULL) {

		$req =& new HTTP_Request2($url);
		$this->init($req);

		//渡すパラメータをセット
		if (count($data)) {
			foreach($data as $key => $d){
			$req->addPostParameter($key, $d);
			}
			$req->setMethod(HTTP_Request2::METHOD_POST);
		} else {
			$req->setMethod(HTTP_Request2::METHOD_GET);
		}
		
		//POSTするファイルをセット
		if (count($files)) {
			foreach ($files as $file) {
//				$finfo = finfo_open(FILEINFO_MIME_TYPE);
//				$file_content_type = finfo_file($finfo, $file[1]);
//				finfo_close($finfo);
				$req->addUpload($file[0], $file[1], $file[2], $file[3]);
			}
			$req->setMethod(HTTP_Request2::METHOD_POST);
		}
		
		// クッキーをセット
		if(!empty($this->cookies) ){//クッキーが設定しているなら
			foreach($this->cookies as $key=>$c){
				$req->addCookie($key, $c);
			}
		}

		
		//リクエストを送信
		$response = $req->send();
		
		//Cookieを保存
		$cookies =$response->getCookies();
		foreach ($cookies as $cookie) {
			$this->cookies[$cookie['name']] = $cookie['value'];
		}
		
		//リファラを設定
		$this->refere = $url;
//var_dump($req);		
		
		return $response->getHeader();
	}

}
