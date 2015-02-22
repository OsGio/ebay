<?php

function translateText2($inputStr) {
    $ret = $inputStr;
    try {
        //Client ID of the application.
        $clientID       = "62704483-a2ac-40b9-8522-eacb2bd38786";
        //Client Secret key of the application.
        $clientSecret = "1A3lLodZyl4xdpPMGJI//oT2cQVghaxDH0KGNSQvlNg=";
        //OAuth Url.
        $authUrl      = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/";
        //Application Scope Url
        $scopeUrl     = "http://api.microsofttranslator.com";
        //Application grant type
        $grantType    = "client_credentials";

        //Create the AccessTokenAuthentication object.
        $authObj      = new AccessTokenAuthentication();
        //Get the Access token.
        $accessToken  = $authObj->getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl);
        //Create the authorization Header string.
        $authHeader = "Authorization: Bearer ". $accessToken;

        //Set the params.//
        $fromLanguage = "ja";
        $toLanguage   = "en";
        //$inputStr     = $_POST["txtToTranslate"];
        $contentType  = 'text/plain';
        $category     = 'general';
    
        $params = "text=".urlencode($inputStr)."&to=".$toLanguage."&from=".$fromLanguage;
        $translateUrl = "http://api.microsofttranslator.com/v2/Http.svc/Translate?$params";
    
        //Create the Translator Object.
        $translatorObj = new HTTPTranslator();
    
        //Get the curlResponse.
        $curlResponse = $translatorObj->curlRequest($translateUrl, $authHeader);
    
        //Interprets a string of XML into an object.
        $xmlObj = simplexml_load_string($curlResponse);
        foreach((array)$xmlObj[0] as $val){
            $translatedStr = $val;
        }
	$ret =$translatedStr;
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage() . PHP_EOL;
    }
    return $ret;
}

?>