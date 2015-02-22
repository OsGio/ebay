<?php
require_once('eBaySession.php');


class SC_eBay {
	
	var $production;   // toggle to true if going against production
	var $debug;   // toggle to provide debugging info
	var $compatabilityLevel;    // eBay API version
	var $findingVer; //eBay Finding API version
	var $siteID;

	var $devID;   // these prod keys are different from sandbox keys
	var $appID;
	var $certID;

	var $serverUrl;      // server URL different for prod and sandbox
	var $shoppingURL;
	var $findingURL;
	
	var $session;

	
	function __construct($devID, $appID, $certID, $token, $server,$runame) {

		$this->production         = true;   // toggle to true if going against production
		$this->debug              = false;   // toggle to provide debugging info
		$this->compatabilityLevel = 681;    // eBay API version
		$this->findingVer = "1.8.0"; //eBay Finding API version

		//SiteID must also be set in the request
		//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
		//SiteID Indicates the eBay site to associate the call with
		$this->siteID = 0;

		$this->devID = $devID;   // these prod keys are different from sandbox keys
		$this->appID = $appID;
		$this->certID = $certID;
		//set the Server to use (Sandbox or Production)
		$this->serverUrl   = $server;      // server URL different for prod and sandbox
		//$this->shoppingURL = 'http://open.api.ebay.com/shopping';
		$this->findingURL= 'http://svcs.ebay.com/services/search/FindingService/v1';

		session_start();
		$_SESSION['Token'] = $token;

        $this->loginURL = 'https://signin.ebay.com/ws/eBayISAPI.dll'; // This is the URL to start the Auth & Auth process
        $this->feedbackURL = 'http://feedback.ebay.com/ws/eBayISAPI.dll'; // This is used to for link to feedback
        $this->runame = $runame;  // runame
				
	}
	
	
	function createSession($requestName) {
		
		$this->session = new eBaySession($this->devID, $this->appID, $this->certID, $this->serverUrl, $this->compatabilityLevel, $this->siteID, $requestName);

	}
	
	

	function getEbayActiveList($EntriesPerPage, $PageNumber) {

		$this->createSession('GetMyeBaySelling');

		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= '  <RequesterCredentials>';
		$requestXmlBody .= '    <eBayAuthToken>'.$_SESSION['Token'].'</eBayAuthToken>';
		$requestXmlBody .= '  </RequesterCredentials>';
		$requestXmlBody .= '  <Version>681</Version>';
		$requestXmlBody .= '  <ActiveList>';
		$requestXmlBody .= '    <Sort>TimeLeft</Sort>';
		$requestXmlBody .= '    <Pagination>';
		$requestXmlBody .= '      <EntriesPerPage>'.$EntriesPerPage.'</EntriesPerPage>';
		$requestXmlBody .= '      <PageNumber>'.$PageNumber.'</PageNumber>';
		$requestXmlBody .= '    </Pagination>';
		$requestXmlBody .= '  </ActiveList>';
		$requestXmlBody .= '</GetMyeBaySellingRequest>';


		//send the request and get response
		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
		//var_dump($responseXml);

		$item_list = array();
		$xml = simplexml_load_string($responseXml);


		if ((string)$xml->Ack == 'Success') {

			foreach ($xml->ActiveList->ItemArray->Item as $item) {

				$item_arry = (array)$item;
				//$GLOBALS['item_list'][$item_arry['SKU']] = $item_arry['ItemID'];
				$GLOBALS['item_list'][] = array(
					'SKU' => $item_arry['SKU'],
					'ItemID' => $item_arry['ItemID']
				);
		//var_dump($item_arry);

				$item_list[] = array(
					'SKU' => $item_arry['SKU'],
					'ItemID' => $item_arry['ItemID']
				);
			}

			$PaginationResult = (array)$xml->ActiveList->PaginationResult;
			$this->TotalNumberOfEntries = (int)$PaginationResult['TotalNumberOfEntries'];		

		} else {
			mb_send_mail('minohara@wasab.net', '【WASABIアイテムストア】getEbayActiveList', $responseXml);
			exit;
		}

		return $item_list;
	}
	function getAuthSessionId() {

		$this->createSession('GetSessionID');
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<GetSessionIDRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= "<Version>".$this->compatabilityLevel."</Version>";
		$requestXmlBody .= "<RuName>".$this->runame."</RuName>";
		$requestXmlBody .= '</GetSessionIDRequest>';


		//send the request and get response
		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
		//var_dump($responseXml);
		if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
			die('<P>eBayとの通信エラー。もう一度実行ください。'.$responseXml);

		$xml = simplexml_load_string($responseXml);

		if ((string)$xml->Ack == 'Success') {
			$_SESSION['ebSession']  = (string)$xml->SessionID;
		} else {
			mb_send_mail('yanagi.rituen@gmail.com', '【WASABIアイテムストア】getAuthToken', $responseXml);
			die('<P>eBayとの通信エラー。もう一度実行ください。'.$responseXml);
		}

		return (string)$xml->SessionID;
	}

	function getToken($username,$theID) {

		$this->createSession('FetchToken');

		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
        $requestXmlBody .= '<FetchTokenRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
        $requestXmlBody .= "<RequesterCredentials><Username>$username</Username></RequesterCredentials>";
        $requestXmlBody .= "<SessionID>$theID</SessionID>";
		$requestXmlBody .= '</FetchTokenRequest>';


		//send the request and get response
		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
		//var_dump($responseXml);
        if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
            die('<P>eBayより未認証。最初からやり直しください。<a href="ebayAuth1.php">「認証画面」</a>'.$responseXml);

		$xml = simplexml_load_string($responseXml);
		if ((string)$xml->Ack == 'Success') {
			$result = (string)$xml->eBayAuthToken;
			return $result;
		} else {
			mb_send_mail('yanagi.rituen@gmail.com', '【WASABIアイテムストア】getToken', $responseXml);
            die('<P>eBayより未認証。最初からやり直しください。<a href="ebayAuth1.php">「認証画面」</a>'.$responseXml);
		}

	}

	
	
	function CompleteSale($itemID, $trackingNo, $commit_date, $feedback_msg) {

		$this->createSession('CompleteSale');

		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<CompleteSaleRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= '  <RequesterCredentials>';
		$requestXmlBody .= '    <eBayAuthToken>'.$_SESSION['Token'].'</eBayAuthToken>';
		$requestXmlBody .= '  </RequesterCredentials>';
		$requestXmlBody .= '  <FeedbackInfo>';
		$requestXmlBody .= '    <CommentText>'.$feedback_msg.'</CommentText>';
		$requestXmlBody .= '    <CommentType>Positive</CommentType>';
		$requestXmlBody .= '  </FeedbackInfo>';
		$requestXmlBody .= '  <Shipment>';
		$requestXmlBody .= '    <ShipmentTrackingDetails>';
		$requestXmlBody .= '      <ShipmentTrackingNumber>'.$trackingNo.'</ShipmentTrackingNumber>';
		$requestXmlBody .= '      <ShippingCarrierUsed>Japan Post</ShippingCarrierUsed>';
		$requestXmlBody .= '    </ShipmentTrackingDetails>';
		$requestXmlBody .= '    <ShippedTime>'.date('Y-m-d\TH:i:s\Z', $commit_date).'</ShippedTime>';
		$requestXmlBody .= '  </Shipment>';
		$requestXmlBody .= '  <Shipped>true</Shipped>';
		$requestXmlBody .= '  <ItemID>'.$itemID.'</ItemID>';
		$requestXmlBody .= '</CompleteSaleRequest>';
//		var_dump($requestXmlBody);

		//send the request and get response
		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
//		var_dump($responseXml);
		
		return simplexml_load_string($responseXml);
	}
	
	
	function getTransaction($itemID) {
		
		$this->createSession('GetItemTransactions');
		
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<GetItemTransactionsRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= '  <RequesterCredentials>';
		$requestXmlBody .= '    <eBayAuthToken>'.$_SESSION['Token'].'</eBayAuthToken>';
		$requestXmlBody .= '  </RequesterCredentials>';
		$requestXmlBody .= '  <ItemID>'.$itemID.'</ItemID>';
		$requestXmlBody .= '</GetItemTransactionsRequest>';


		//send the request and get response
		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
		$xml = simplexml_load_string($responseXml);

		return $xml;
		
	}
	
	function endItem($itemID) {
		
		$this->createSession('EndFixedPriceItem');
		
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<EndFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= "<WarningLevel>Low</WarningLevel>";
		$requestXmlBody .= '  <RequesterCredentials>';
		$requestXmlBody .= '    <eBayAuthToken>'.$_SESSION['Token'].'</eBayAuthToken>';
		$requestXmlBody .= '  </RequesterCredentials>';
		$requestXmlBody .= '  <EndingReason>OtherListingError</EndingReason>';
		$requestXmlBody .= '  <ItemID>'.$itemID.'</ItemID>';
		$requestXmlBody .= '</EndFixedPriceItemRequest>';


		//send the request and get response
		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
		$xml = simplexml_load_string($responseXml);

		return $xml;
		
	}


	function getFeedbacks($pageNumber=1) {
		
		$this->createSession('GetMyeBaySelling');

		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= '  <RequesterCredentials>';
		$requestXmlBody .= '    <eBayAuthToken>'.$_SESSION['Token'].'</eBayAuthToken>';
		$requestXmlBody .= '  </RequesterCredentials>';
		$requestXmlBody .= '  <Version>681</Version>';
		$requestXmlBody .= '  <SoldList>';
		$requestXmlBody .= '    <Sort>EndTimeDescending</Sort>';
		$requestXmlBody .= '    <Pagination>';
		$requestXmlBody .= '      <EntriesPerPage>100</EntriesPerPage>';
		$requestXmlBody .= '      <PageNumber>'.$pageNumber.'</PageNumber>';
		$requestXmlBody .= '    </Pagination>';
		$requestXmlBody .= '  </SoldList>';
		$requestXmlBody .= '</GetMyeBaySellingRequest>';


		//send the request and get response
		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
		$xml = simplexml_load_string($responseXml);

		return $xml;
		
	}
	
	


	function getEbayImageURL($imgURL) {

		$this->createSession('UploadSiteHostedPictures');
		
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
		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
	//	var_dump($responseXml);

		$xml = simplexml_load_string($responseXml);
		$FullURL = (array)$xml->SiteHostedPictureDetails->FullURL;
	//	var_dump($FullURL[0]);

		return $FullURL[0];
	}



	function uploadEbayImageURL($ebayUploadedImages, $ebayID) {

		$this->createSession('ReviseItem');
		
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
		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
		var_dump($responseXml);

	}
	
	
	
	function addItem($product, &$item_specifics) {		

		$this->createSession('AddItem');

		$product['product_name'] = substr($product['product_name'],0,80);
  
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= "<ErrorLanguage>en_US</ErrorLanguage>";
		$requestXmlBody .= "<WarningLevel>Low</WarningLevel>";
		$requestXmlBody .= '  <RequesterCredentials>';
		$requestXmlBody .= '    <eBayAuthToken>'.$_SESSION['Token'].'</eBayAuthToken>';
		$requestXmlBody .= '  </RequesterCredentials>';
		$requestXmlBody .= '    <Item>';
		$requestXmlBody .= '      <Title>'.$product['product_name'].'</Title>';
		$requestXmlBody .= '      <SKU>'.$product['CustomLabel'].'</SKU>';
		$requestXmlBody .= '      <ConditionID>'.$product['ConditionID'].'</ConditionID>';
		$requestXmlBody .= '      <ConditionDescription>'.$product['ConditionDescription'].'</ConditionDescription>';
		$requestXmlBody .= '      <Country>JP</Country>';
		$requestXmlBody .= '      <Description><![CDATA['.$product['product_description'].']]></Description>';
		$requestXmlBody .= '      <PrimaryCategory>';
		$requestXmlBody .= '        <CategoryID>'.$product['Category'].'</CategoryID>';
		$requestXmlBody .= '      </PrimaryCategory>';
		$requestXmlBody .= '      <CategoryMappingAllowed>true</CategoryMappingAllowed>';
		$requestXmlBody .= '      <Site>US</Site>';
		$requestXmlBody .= '      <Location>'.$product['Location'].'</Location>';
		$requestXmlBody .= '      <Quantity>'.$product['Quantity'].'</Quantity>';
		$requestXmlBody .= '      <StartPrice>'.$product['StartPrice'].'</StartPrice>';
		$requestXmlBody .= '      <ListingDuration>'.$product['Duration'].'</ListingDuration>';
		$requestXmlBody .= '      <ListingType>FixedPriceItem</ListingType>';
		if ($product['Format'] == 'FixedPrice') {
			$requestXmlBody .= '      <ListingType>FixedPriceItem</ListingType>';			
		} else if ($product['Format'] != 'Auction') {
			$requestXmlBody .= '      <ListingType>'.$product['Format'].'</ListingType>';
		}
		$requestXmlBody .= '      <DispatchTimeMax>'.$product['DispatchTimeMax'].'</DispatchTimeMax>';
		$requestXmlBody .= '      <ShippingDetails>';
		$requestXmlBody .= '        <ShippingType>Flat</ShippingType>';
		$requestXmlBody .= '        <ShippingServiceOptions>';
		$requestXmlBody .= '          <ShippingServicePriority>1</ShippingServicePriority>';
		$requestXmlBody .= '          <ShippingService>'.$product['ShippingService-1:Option'].'</ShippingService>';
		$requestXmlBody .= '          <ShippingServiceCost>'.$product['ShippingService-1:Cost'].'</ShippingServiceCost>';
		$requestXmlBody .= '        </ShippingServiceOptions>';
		$requestXmlBody .= '        <ShippingDiscountProfileID>'.$product['ShippingDiscountProfileID'].'</ShippingDiscountProfileID>';
		$requestXmlBody .= '        <InternationalShippingServiceOption>';
		$requestXmlBody .= '          <ShippingService>'.$product['IntlShippingService-1:Option'].'</ShippingService>';
		$requestXmlBody .= '          <ShippingServiceCost currencyID="USD">'.$product['IntlShippingService-1:Cost'].'</ShippingServiceCost>';
		$requestXmlBody .= '          <ShippingServicePriority>'.$product['IntlShippingService-1:Priority'].'</ShippingServicePriority>';
		$requestXmlBody .= '          <ShipToLocation>'.$product['IntlShippingService-1:Locations'].'</ShipToLocation>';
		$requestXmlBody .= '        </InternationalShippingServiceOption>';
		$requestXmlBody .= '      </ShippingDetails>';
		$requestXmlBody .= '      <ReturnPolicy>';
		$requestXmlBody .= '        <ReturnsAcceptedOption>'.$product['ReturnsAcceptedOption'].'</ReturnsAcceptedOption>';
		$requestXmlBody .= '        <RefundOption>'.$product['RefundOption'].'</RefundOption>';
		$requestXmlBody .= '        <ReturnsWithinOption>'.$product['ReturnsWithinOption'].'</ReturnsWithinOption>';
		$requestXmlBody .= '        <ShippingCostPaidByOption>'.$product['ShippingCostPaidBy'].'</ShippingCostPaidByOption>';
		$requestXmlBody .= '        <Description><![CDATA['.$product['AdditionalDetails'].']]></Description>';
		$requestXmlBody .= '        <RestockingFeeValueOption>'.$product['RestockingFeeValueOption'].'</RestockingFeeValueOption>';
		$requestXmlBody .= '      </ReturnPolicy>';
		$requestXmlBody .= '      <Currency>USD</Currency>';
		$requestXmlBody .= '      <PaymentMethods>PayPal</PaymentMethods>';
		$requestXmlBody .= '      <PayPalEmailAddress>'.$product['PayPalEmailAddress'].'</PayPalEmailAddress>';
		$requestXmlBody .= '      <PictureDetails>';
		$requestXmlBody .= '        <PictureURL>'.$product['PictureURL'].'</PictureURL>';
		$requestXmlBody .= '      </PictureDetails>';

		$requestXmlBody .= '      <ItemSpecifics>';
		foreach ($item_specifics as $value) {
			if ($product['C:'.$value]) {
				$requestXmlBody .= '        <NameValueList>';
				$requestXmlBody .= '          <Name>'.htmlspecialchars($value).'</Name>';
				$requestXmlBody .= '          <Value>'.$product['C:'.$value].'</Value>';
				$requestXmlBody .= '        </NameValueList>';
			}
		}
		$requestXmlBody .= '        <NameValueList>';
		$requestXmlBody .= '          <Name>C:Country of Manufacture</Name>';
		$requestXmlBody .= '          <Value>'.$product['C:Country of Manufacture'].'</Value>';
		$requestXmlBody .= '        </NameValueList>';
		$requestXmlBody .= '      </ItemSpecifics>';

		$requestXmlBody .= '    </Item>';
		$requestXmlBody .= "<WarningLevel>Low</WarningLevel>";
		$requestXmlBody .= '</AddItemRequest>';

		var_dump($requestXmlBody);

		//send the request and get response
		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
		$xml = simplexml_load_string($responseXml);
		
		//echo "555-----------".$responseXml."-----66666";
		
		return $xml;
	}
	

	function getUser() {		

		$this->createSession('GetUser');
  
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
		$requestXmlBody .= '<GetUserRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= "<ErrorLanguage>en_US</ErrorLanguage>";
		$requestXmlBody .= "<WarningLevel>Low</WarningLevel>";
		$requestXmlBody .= '  <RequesterCredentials>';
		$requestXmlBody .= '    <eBayAuthToken>'.$_SESSION['Token'].'</eBayAuthToken>';
		$requestXmlBody .= '  </RequesterCredentials>';
		$requestXmlBody .= '</GetUserRequest>';


		$responseXml = $this->session->sendHttpRequest($requestXmlBody);
		$xml = simplexml_load_string($responseXml);
				
		return $xml;
	}
	
}





