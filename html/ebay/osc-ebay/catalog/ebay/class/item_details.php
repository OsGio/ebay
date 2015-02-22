<?
/*
Title: OSC-Ebay
Description: Automatically sync your oscmax store with your ebay store
Project URL: http://code.google.com/p/ebay-osc/
Author: Jason Clark 
Release: Oct 22, 2011
Version: 1.0
*/
require_once('sessionHeader.php');
require_once('keys.php');
require_once('eBaySession.php');
require_once('configure.php');

class item_details
{     
var $itemID;
var $verb;
var $myip;
var $requestXmlBody;
var $session;
var $resp;
var $responseXml;
var $testresponseXml="tests/itemdetails.xml";
var $debug;
var $test;


function __construct(){
    global $test,$debug;
    $this->debug=$debug;
    $this->test=$test;
}
public function get_item_details($itemID){
    if($this->debug == true)
    echo '<br>'.$itemID.'<br><br>';
    global $appID,$devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb,$appToken;
$this->verb = 'GetItem';       
        
$myIP   = '000.000.0.0';  // use the client's external IP address  
/* xml request*/
$this->requestXmlBody  = '<?xml version="1.0" encoding="utf-8"?>';
$this->requestXmlBody .= '<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
$this->requestXmlBody .=' <DetailLevel>ItemReturnDescription</DetailLevel>';
$this->requestXmlBody .= '<ItemID>'.$itemID.'</ItemID>';
$this->requestXmlBody .= '<RequesterCredentials>';
$this->requestXmlBody .= '<eBayAuthToken>'. $appToken .'</eBayAuthToken>';
$this->requestXmlBody .= '</RequesterCredentials>';
$this->requestXmlBody .= '<OutputSelector>Item.Quantity</OutputSelector>';
$this->requestXmlBody .= '<OutputSelector>Item.ShippingDetails.CalculatedShippingRate.WeightMajor</OutputSelector>';
$this->requestXmlBody .= '<OutputSelector>Item.ShippingDetails.CalculatedShippingRate.WeightMinor</OutputSelector>';
$this->requestXmlBody .= '<OutputSelector>Item.ShippingDetails.CalculatedShippingRate.PackageLength</OutputSelector>';
$this->requestXmlBody .= '<OutputSelector>Item.ShippingDetails.CalculatedShippingRate.PackageWidth</OutputSelector>';
$this->requestXmlBody .= '<OutputSelector>Item.ShippingDetails.CalculatedShippingRate.PackageDepth</OutputSelector>';
$this->requestXmlBody .= '<OutputSelector>Item.Description</OutputSelector>';
$this->requestXmlBody .= '<Version>543</Version>';
$this->requestXmlBody .= '</GetItemRequest>';

$this->session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $this->verb);
	
//send the request and get response vars are in keys.php

if ($this->test==false)
{
$this->responseXml = $this->session->sendHttpRequest($this->requestXmlBody);
if(stristr($this->responseXml, 'HTTP 404') || $this->responseXml == '')
{
die('<P>Error sending request');       
}
//print "RESPONSE_XML = \n $responseXml \n\n";  
$this->resp = simplexml_load_string($this->responseXml);
	if ($this->debug==true)
	{
	var_dump($this->resp);
	}

}else{
		
$this->resp = simplexml_load_file($this->testresponseXml);
trim($this->resp['comment'][2]['Errors']);
trim($this->resp['comment'][2]['Item']);
		if ($this->debug==true)
		{
		var_dump($this->resp);
		}
    }
    return $this;
 }
 }
 ?>
