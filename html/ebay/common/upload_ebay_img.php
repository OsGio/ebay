<?php

// {{{ requires
require_once('eBaySession.php');
function url_exists($url) {
  $header = @get_headers($url);
  if(preg_match('#^HTTP/.*\s+[200|302]+\s#i', $header[0])) {
    return true;
  }
  return false;
}
function url_exists2($url) {
  $ch = curl_init();
 
    curl_setopt($ch, CURLOPT_URL,            $url);
    curl_setopt($ch, CURLOPT_HEADER,         true);
    curl_setopt($ch, CURLOPT_NOBODY,         true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT,        2);
 
    $r = curl_exec($ch);
    $r = split("\n", $r);
    if (preg_match('/200/', $r[0])) {
    return true;
  }
  return false;
}
function getEbayImg($imgURL,$product_code) {
	$images = explode(" ",$imgURL);
	
	if(empty($images)) {
		return $imgURL;
	}
	//echo 'bbbbbbbbbbbbbbb==='.count($images);
	//	module/eBayLib/keys.php	==================================================
	$production         = true;   // toggle to true if going against production
	$debug              = false;   // toggle to provide debugging info
	$compatabilityLevel = 681;    // eBay API version
	$findingVer = "1.8.0"; //eBay Finding API version

	//SiteID must also be set in the request
	//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
	//SiteID Indicates the eBay site to associate the call with
	$siteID = 0;

	require_once('EBAY_CONS.php');
	$devID = API_DEV_NAME;   //  sandbox keys
	$appID = API_APP_NAME;
	$certID = API_CERT_NAME;
	//set the Server to use (Sandbox or Production)
	$serverUrl   = EBAY_SERVER;      // server URL different for prod and sandbox
	$shoppingURL = 'http://open.api.ebay.com/shopping';
	$findingURL= 'http://svcs.ebay.com/services/search/FindingService/v1';

	$ebayID = $product_code;
	//商品画像のリストを取得
	//$images = get_product_images($product_code);



	$appToken = '';

	//	module/eBayLib/keys.php	==================================================
	session_start();
	$_SESSION['Token'] = AUTH_TOKEN;



	//画像をebayにアップロード
	$ebayUploadedImages = array();
	foreach ($images as $image) {
		if(url_exists($image))
		{
			$pic_url = getEbayImageURL($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $image);
			if($pic_url <> "" && !is_null ($pic_url)) {
				$ebayUploadedImages[] = $pic_url;
			}
		}
		else
		{
			// echo 'URLが存在しません。'.$image;
		}
	}

	//eBayの商品データにebayにアップした画像のURLを適用
	uploadEbayImageURL($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $ebayUploadedImages, $ebayID);
	
	$imgNames = implode("|", $ebayUploadedImages);
	return $imgNames;
}




	function getEbayImageURL($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $imgURL) {
	//echo "eee..".$_SESSION['Token'];
		//echo "1111--".$imgURL;
		$session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, 'UploadSiteHostedPictures');
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<UploadSiteHostedPicturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= '  <RequesterCredentials>';
		$requestXmlBody .= '    <eBayAuthToken>'.$_SESSION['Token'].'</eBayAuthToken>';
		$requestXmlBody .= '  </RequesterCredentials>';
		$requestXmlBody .= '  <WarningLevel>Low</WarningLevel>';
		$requestXmlBody .= '  <ExternalPictureURL>'.$imgURL.'</ExternalPictureURL>';
		$requestXmlBody .= '  <PictureName>WorldLeaders</PictureName>';
		$requestXmlBody .= '</UploadSiteHostedPicturesRequest>';


		//send the request and get response
		$responseXml = $session->sendHttpRequest($requestXmlBody);
	//	var_dump($responseXml);
		//echo "bbb--".$responseXml;

		$xml = simplexml_load_string($responseXml);
		$FullURL = (array)$xml->SiteHostedPictureDetails->FullURL;
	//	var_dump($FullURL[0]);
		//echo "==ggggggggggggg--".$responseXml;
		//echo "==222222--".$FullURL[0];
		return $FullURL[0];
	}



	function uploadEbayImageURL($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $ebayUploadedImages, $ebayID) {

		$session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, 'ReviseItem');
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<ReviseItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= '  <RequesterCredentials>';
		$requestXmlBody .= '    <eBayAuthToken>'.$_SESSION['Token'].'</eBayAuthToken>';
		$requestXmlBody .= '  </RequesterCredentials>';
		$requestXmlBody .= '    <ErrorLanguage>en_US</ErrorLanguage>';
		$requestXmlBody .= '    <WarningLevel>Low</WarningLevel>';
		$requestXmlBody .= '    <Item>';
		$requestXmlBody .= '      <ItemID>'.$ebayID.'</ItemID>';
		$requestXmlBody .= '         <PictureDetails>';
		foreach ($ebayUploadedImages as $ebayUploadedImage) {
		//echo "ddddddd--".$ebayUploadedImage;
			$requestXmlBody .= '           <PictureURL>'.$ebayUploadedImage.'</PictureURL>';
		}
		$requestXmlBody .= '         </PictureDetails>';
		$requestXmlBody .= '    </Item>';
		$requestXmlBody .= '</ReviseItemRequest>';
//var_dump($requestXmlBody);

		//send the request and get response
		$responseXml = $session->sendHttpRequest($requestXmlBody);
		//var_dump($responseXml);

	}
	
	
	
	//商品画像の有無を配列で返す
	function get_product_images($product_code) {
		
		$product_images = array();
		$i=0;
		$targetFiles = scandir(HTML_REALDIR . "upload/save_image/".$product_code.'/');
		if (! empty($targetFiles)) {
			foreach ($targetFiles as $targetFilesVal) {
				// ファイルのみを抽出
				if (is_file(HTML_REALDIR . "upload/save_image/".$product_code.'/' . $targetFilesVal) && preg_match('/\.jpg/', $targetFilesVal)) {
					if (SHOP_DOMAIN == 'kyoto-komaki.jp' ) {
						
						if (!preg_match('/-m/', $targetFilesVal)) {
							$product_images[$i] = $targetFilesVal;
							$i++;
						}
						
					} else {
						$product_images[$i] = $targetFilesVal;
						$i++;
					}

				}
			}
		}

		 return $product_images;
	}	
?>