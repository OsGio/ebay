<?php
    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = true;   // toggle to true if going against production
    $debug              = true;   // toggle to provide debugging info
    $compatabilityLevel = 543;    // eBay API version
    
    //SiteID must also be set in the request
    //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
    //SiteID Indicates the eBay site to associate the call with
    $siteID = 0;
    $sellerID= 'yourid'; // your ebay seller id
    
    if ($production) {
        $devID = '';   // these prod keys are different from sandbox keys
        $appID = '';
        $certID = '';
        //set the Server to use (Sandbox or Production)
        $serverUrl   = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        $shoppingURL = 'http://open.api.ebay.com/shopping';
        
        // This is used in the Auth and Auth flow
        
        // This is an initial token, not to be confused with the token that is fetched by the FetchToken call
        $appToken = '';          
    } else {  
        // sandbox (test) environment
        $devID  = '';   // insert your devID for sandbox
        $appID  = '';   // different from prod keys
        $certID = '';   // need three keys and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        $shoppingURL = 'http://open.api.sandbox.ebay.com/shopping';
        
        $loginURL = 'https://signin.sandbox.ebay.com/ws/eBayISAPI.dll'; // This is the URL to start the Auth & Auth process
        $feedbackURL = 'http://feedback.sandbox.ebay.com/ws/eBayISAPI.dll'; // This is used to for link to feedback
        
        $runame = '';  // sandbox runame 
        
        // This is the sandbox application token, not to be confused with the sandbox user token that is fetched.
        // This token is a long string - do not insert new lines. 
        $appToken = '';                 
    }
    
    
?>
