#!/usr/local/bin/php
<?php
/*
 * written by minohara (archtype engine KYOTO)
 * 2013.06.01
 */

// {{{ requires
require_once dirname(__FILE__).'/../require.php';
require_once(DATA_REALDIR.'module/eBayLib/keys.php');
require_once(DATA_REALDIR.'module/eBayLib/eBaySession.php');


$objQuery =& SC_Query_Ex::getSingletonInstance();
$shops = $objQuery->getAll("SELECT * FROM wcs_shops WHERE mtb_ss_id = ?", array(4));


foreach ($shops as $shop) {

	$shopdata = unserialize($shop['data']);

	//	module/eBayLib/keys.php	==================================================
	$production         = true;   // toggle to true if going against production
	$debug              = false;   // toggle to provide debugging info
	$compatabilityLevel = 681;    // eBay API version
	$findingVer = "1.8.0"; //eBay Finding API version

	//SiteID must also be set in the request
	//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
	//SiteID Indicates the eBay site to associate the call with
	$siteID = 0;

	$devID = $shopdata['shopdata_dev_id'];   // these prod keys are different from sandbox keys
	$appID = $shopdata['shopdata_app_id'];
	$certID = $shopdata['shopdata_cert_id'];
	//set the Server to use (Sandbox or Production)
	$serverUrl   = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
	$shoppingURL = 'http://open.api.ebay.com/shopping';
	$findingURL= 'http://svcs.ebay.com/services/search/FindingService/v1';

	// This is an initial token, not to be confused with the token that is fetched by the FetchToken call
	$appToken = '';

	//	module/eBayLib/keys.php	==================================================

	session_start();
	$_SESSION['Token'] = $shopdata['shopdata_token'];


	//$product_code = '55914598';
	$product_code = $_REQUEST['product_code'];
	//$ebayID = '181240748120';
	$ebayID = $_REQUEST['ebay_id'];

	//商品画像のリストを取得
	$images = get_product_images($product_code);

	//画像をebayにアップロード
	$ebayUploadedImages = array();
	foreach ($images as $image) {
		$ebayUploadedImages[] = getEbayImageURL($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, HTTP_URL.IMAGE_SAVE_URLPATH.$product_code.'/'.$image);
	}

	//eBayの商品データにebayにアップした画像のURLを適用
	uploadEbayImageURL($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $ebayUploadedImages, $ebayID);

}




	function getEbayImageURL($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $imgURL) {

		$session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, 'UploadSiteHostedPictures');
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<UploadSiteHostedPicturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= '  <RequesterCredentials>';
		$requestXmlBody .= '    <eBayAuthToken>'.$_SESSION['Token'].'</eBayAuthToken>';
		$requestXmlBody .= '  </RequesterCredentials>';
		$requestXmlBody .= '  <WarningLevel>High</WarningLevel>';
		$requestXmlBody .= '  <ExternalPictureURL>'.$imgURL.'</ExternalPictureURL>';
		$requestXmlBody .= '  <PictureName>WorldLeaders</PictureName>';
		$requestXmlBody .= '</UploadSiteHostedPicturesRequest>';


		//send the request and get response
		$responseXml = $session->sendHttpRequest($requestXmlBody);
	//	var_dump($responseXml);

		$xml = simplexml_load_string($responseXml);
		$FullURL = (array)$xml->SiteHostedPictureDetails->FullURL;
	//	var_dump($FullURL[0]);

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
		$requestXmlBody .= '    <WarningLevel>High</WarningLevel>';
		$requestXmlBody .= '    <Item>';
		$requestXmlBody .= '      <ItemID>'.$ebayID.'</ItemID>';
		$requestXmlBody .= '         <PictureDetails>';
		foreach ($ebayUploadedImages as $ebayUploadedImage) {
			$requestXmlBody .= '           <PictureURL>'.$ebayUploadedImage.'</PictureURL>';
		}
		$requestXmlBody .= '         </PictureDetails>';
		$requestXmlBody .= '    </Item>';
		$requestXmlBody .= '</ReviseItemRequest>';
//var_dump($requestXmlBody);

		//send the request and get response
		$responseXml = $session->sendHttpRequest($requestXmlBody);
		var_dump($responseXml);

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