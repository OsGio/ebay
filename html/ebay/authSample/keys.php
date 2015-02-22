<?php
    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com

    $production         = false;   // toggle to true if going against production
    $debug              = false;   // toggle to provide debugging info
    $compatabilityLevel = 681;    // eBay API version
    $findingVer = "1.8.0"; //eBay Finding API version

    //SiteID must also be set in the request
    //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
    //SiteID Indicates the eBay site to associate the call with
    $siteID = 0;

    if ($production) {
        $devID = 'fdec0311-09ab-4c7f-af74-b393c461d9b2';   // these prod keys are different from sandbox keys
        $appID = 'yuukimin-354e-4441-b41b-6b4656975539';
        $certID = '4b7097f1-8be7-444b-8d9f-28b90f3f8ed9';
        //set the Server to use (Sandbox or Production)
        $serverUrl   = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        $shoppingURL = 'http://open.api.ebay.com/shopping';
        $findingURL= 'http://svcs.ebay.com/services/search/FindingService/v1';


        // This is used in the Auth and Auth flow

        // This is an initial token, not to be confused with the token that is fetched by the FetchToken call
        $appToken = 'edgaergtasergtsadgsdfgsert3432';
    } else {
        // sandbox (test) environment
        $devID  = 'fdec0311-09ab-4c7f-af74-b393c461d9b2';   // insert your devID for sandbox
        $appID  = 'yuukimin-76ae-4112-b3ae-e74fe2ebecbb';   // different from prod keys
        $certID = 'e648827a-a927-40d0-9f92-9d96f48e3947';   // need three keys and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        $shoppingURL = 'http://open.api.sandbox.ebay.com/shopping';
        $findingURL= 'http://svcs.sandbox.ebay.com/services/search/FindingService/v1';


        $loginURL = 'https://signin.sandbox.ebay.com/ws/eBayISAPI.dll'; // This is the URL to start the Auth & Auth process
        $feedbackURL = 'http://feedback.sandbox.ebay.com/ws/eBayISAPI.dll'; // This is used to for link to feedback

        $runame = 'yuuki_minohara-yuukimin-76ae-4-pjvpqgojo';  // sandbox runame

        // This is the sandbox application token, not to be confused with the sandbox user token that is fetched.
        // This token is a long string - do not insert new lines.
        $appToken = 'ewrtaewtewatr343taset4';
    }


?>