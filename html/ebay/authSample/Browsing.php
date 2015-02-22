<?php
require_once('./sessionHeader.php');
require_once('./SingleItem.php');
require_once('./keys.php');
error_reporting(E_ALL);          // useful to see all notices in development
?>

<HTML>
<HEAD>
  <TITLE>Browsing on eBay</TITLE>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <script type="text/javascript" src="js/JQuery.js"></script>
  <script type="text/javascript" src="js/ShowDetails.js"></script>
</HEAD>

<BODY>
<H1>Browsing on eBay</H1>
<br>

<?php
global $shoppingURL, $appID, $eBayVersion, $findingURL, $compatabilityLevel, $findingVer;    // these come from keys.php
//need to urlencode the user-input keyword for the Finding API
 $safeQuery = urlencode($_POST['QueryString']);
 //construct the URL; we want to get only one returned item to keep things simple so set entriesPerPage to 1
 // (by default, only one page is returned)
 $apicall  = "$findingURL?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=$findingVer"
 			. "&GLOBAL-ID=EBAY-US"
 			. "&SECURITY-APPNAME=$appID"
 			. "&keywords=$safeQuery"
 			. "&paginationInput.entriesPerPage=1"
 			. "&outputSelector=SellerInfo";


if ($debug) {
    print "<p>$apicall</p>";    // see what call is if we're debugging - $debug comes from keys.php
}

// Load the call and capture the document returned by the Finding API
$resp = simplexml_load_file($apicall);

// Check to see if the response was loaded, else print an error
if ($resp) {
    $results = '';
    if ($resp->paginationOutput->totalEntries == 0) {
        $results .= "<BR>Sorry, there were no results found\n";
    } else {
        $results .= "<DIV ALIGN=CENTER> \n";
      		 // If the response was loaded, parse it and build links
        	// To keep things simple, we're showing only the first returned item;
        foreach($resp->searchResult->item as $item) {
        	$browseItem = new SingleItem($resp->searchResult->item->itemId);
            $results .= $browseItem->getBrowseItemAsHTML_Table();
            $results .= "<form	name=\"BidOrBuyIt\" method=\"post\" action=\"./Login.php\" >\n";
            $results .= "<INPUT TYPE=\"submit\" NAME=\"BidOrBuyIt\" VALUE=\"Bid or Buy It!\"></form>\n";
            $_SESSION['ItemID'] = (string)$browseItem->resp->Item->ItemID;  // cast to string to keep in $_SESSION
          } // for each

         $results .= "</DIV> \n";

    }
} else {
    $results = "<BR>Sorry, did not receive a search result\n";
} // if $resp

print $results;

?>
</BODY>
</HTML>
