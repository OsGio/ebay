<!DOCTYPE html>
<!-- saved from url=(0053)http://www.w3schools.com/jsref/coll_form_elements.asp -->
<html lang="en-US" style="height: 100%;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>HTML DOM Form elements Collection</title>
<style>a.menu_coll_form_elements{font-weight:bold;} a.topnav_jsref{background-color:#8AC007 !important;color:#ffffff !important;}</style>
<style>
#smallnavContainer {display:none;}
</style>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Keywords" content="HTML,CSS,XML,JavaScript,DOM,jQuery,ASP.NET,PHP,SQL,colors,tutorial,programming,development,training,learning,quiz,primer,lessons,reference,examples,source code,demos,tips,color table,w3c,cascading style sheets,active server pages,Web building,Webmaster">
<meta name="Description" content="Free HTML CSS JavaScript DOM jQuery XML AJAX Angular ASP .NET PHP SQL tutorials, references, web building examples">
<link rel="icon" href="http://www.w3schools.com/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="http://www.w3schools.com/bs/css/bootstrap_w3schools.css">
<script async="" src="./sku_files/async-ads.js"></script><script type="text/javascript" async="" src="./sku_files/cse.js"></script><script async="" type="text/javascript" src="./sku_files/gpt.js"></script><script async="" src="./sku_files/analytics.js"></script><script src="./sku_files/jquery.js"></script>
<script src="./sku_files/bootstrap.min.js"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-3855518-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');
</script>

<script type="text/javascript">
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
</script>

<script type="text/javascript">
 // GPT slots
 var gptAdSlots = [];
 googletag.cmd.push(function() {

   var leaderMapping = googletag.sizeMapping().
   // Mobile ad
   addSize([0, 0], [320, 50]). 
   // Vertical Tablet ad
   addSize([480, 0], [468, 60]). 
   // Horizontal Tablet
   addSize([700, 0], [728, 90]).
   // Desktop and bigger ad
   addSize([1200, 0], [[728, 90], [970, 90]]).build();

   gptAdSlots[0] = googletag.defineSlot('/16833175/MainLeaderboard', [[728, 90], [970, 90]], 'div-gpt-ad-1422003450156-2').
   defineSizeMapping(leaderMapping).addService(googletag.pubads());

   var skyMapping = googletag.sizeMapping().
   // Mobile ad
   addSize([0, 0], [320, 50]). 
   // Tablet ad
   addSize([975, 0], [120, 600]). 
   // Desktop
   addSize([1100, 0], [[120, 600], [160, 600]]).
   // Large Desktop
   addSize([1675, 0], [[120, 600], [160, 600], [300, 600], [300, 1050]]).build();
   gptAdSlots[1] = googletag.defineSlot('/16833175/WideSkyScraper', [[120, 600], [160, 600], [300, 600], [300, 1050]], 'div-gpt-ad-1422003450156-5').
   defineSizeMapping(skyMapping).addService(googletag.pubads());

   var lpsMapping = googletag.sizeMapping().
   // Smaller
   addSize([0, 0], []). 
   // Desktop
   addSize([1100, 0], [[728, 280], [728, 400], [728, 450]]).build();
   gptAdSlots[2] = googletag.defineSlot('/16833175/LargePS', [[723, 280], [723, 400], [728, 280], [728, 400], [728, 450]], 'div-gpt-ad-1422003450156-1').
   defineSizeMapping(lpsMapping).setCollapseEmptyDiv(true).addService(googletag.pubads());

   var spsMapping = googletag.sizeMapping().
   // Smaller
   addSize([0, 0], []). 
   // Desktop
   addSize([1100, 0], [728, 170]).build();
   gptAdSlots[3] = googletag.defineSlot('/16833175/SmallPS', [[723, 170], [728, 170]], 'div-gpt-ad-1422003450156-4').
   defineSizeMapping(spsMapping).setCollapseEmptyDiv(true).addService(googletag.pubads());

   var bmrMapping = googletag.sizeMapping().
   // Smaller
   addSize([0, 0], [[300, 250], [336, 280]]). 
   // Large Desktop
   addSize([1200, 0], [[300, 250], [336, 280], [970, 250]]).build();
   gptAdSlots[4] = googletag.defineSlot('/16833175/BottomMediumRectangle', [[300, 250], [336, 280], [970, 250]], 'div-gpt-ad-1422003450156-0').
   defineSizeMapping(bmrMapping).setCollapseEmptyDiv(true).addService(googletag.pubads());

   gptAdSlots[5] = googletag.defineSlot('/16833175/RightBottomMediumRectangle', [[300, 250], [336, 280]], 'div-gpt-ad-1422003450156-3').addService(googletag.pubads());

   googletag.pubads().setTargeting("content","jsref");
   googletag.enableServices();
 });
</script>
<script>
if (window.addEventListener) {              
    window.addEventListener("resize", browserResize);
} else if (window.attachEvent) {                 
    window.attachEvent("onresize", browserResize);
}
var wbeforeResize = window.innerWidth;
var xbeforeResize = window.innerWidth;
var ybeforeResize = window.innerWidth;

function browserResize() {
    var afterResize = window.innerWidth;
    if ((xbeforeResize < (1200 + 14) && afterResize >= (1200 + 14)) || (xbeforeResize >= (1200 + 14) && afterResize < (1200 + 14)) ||
        (xbeforeResize < (700 + 14) && afterResize >= (700 + 14)) || (xbeforeResize >= (700 + 14) && afterResize < (700 + 14)) ||
        (xbeforeResize < (480 + 17) && afterResize >= (480 + 17)) ||(xbeforeResize >= (480 + 17) && afterResize < (480 + 17))) {
        xbeforeResize = afterResize;
        googletag.cmd.push(function() {
            googletag.pubads().refresh([gptAdSlots[0]]);
        });
    }
    if ((ybeforeResize < (1675 + 14) && afterResize >= (1675 + 14)) || (ybeforeResize >= (1675 + 14) && afterResize < (1675 + 14)) ||
    	(ybeforeResize < (1100 + 14) && afterResize >= (1100 + 14)) || (ybeforeResize >= (1100 + 14) && afterResize < (1100 + 14)) ||
        (ybeforeResize < (975 + 17) && afterResize >= (975 + 17)) || (ybeforeResize >= (975 + 17) && afterResize < (975 + 17))) {
        ybeforeResize = afterResize;
        googletag.cmd.push(function() {
            googletag.pubads().refresh([gptAdSlots[1]]);
        });
    }
    if ((zbeforeResize < (1100 + 17) && afterResize >= (1100 + 17)) || (zbeforeResize >= (1100 + 17) && afterResize < (1100 + 17))) {
        zbeforeResize = afterResize;
        googletag.cmd.push(function() {
            googletag.pubads().refresh([gptAdSlots[2], gptAdSlots[3]]);
        });
    }
    if ((wbeforeResize < (1200 + 14) && afterResize >= (1200 + 14)) || (wbeforeResize >= (1200 + 14) && afterResize < (1200 + 14))) {
        wbeforeResize = afterResize;
        googletag.cmd.push(function() {
            googletag.pubads().refresh([gptAdSlots[4], gptAdSlots[5]]);
        });
	}
}
</script>
<link rel="stylesheet" type="text/css" href="./sku_files/browserref.css">
<link rel="stylesheet" type="text/css" href="./sku_files/stdtheme.css">
<script async="" type="text/javascript" src="./sku_files/pubads_impl_57.js"></script><script src="./sku_files/jsapi" type="text/javascript"></script><link type="text/css" rel="stylesheet" charset="UTF-8" href="./sku_files/translateelement.css"><script type="text/javascript" charset="UTF-8" src="./sku_files/main_ja.js"></script><script type="text/javascript" src="./sku_files/saved_resource"></script><script type="text/javascript" src="./sku_files/saved_resource(1)"></script><script type="text/javascript" charset="UTF-8" src="./sku_files/element_main.js"></script><link type="text/css" href="./sku_files/default+en.css" rel="stylesheet"><link type="text/css" href="./sku_files/default.css" rel="stylesheet"><script type="text/javascript" src="./sku_files/default+en.I.js"></script><script type="text/javascript" src="./sku_files/osd.js"></script><style id="style-1-cropbar-clipper">/* Copyright 2014 Evernote Corporation. All rights reserved. */
.en-markup-crop-options {
    top: 18px !important;
    left: 50% !important;
    margin-left: -100px !important;
    width: 200px !important;
    border: 2px rgba(255,255,255,.38) solid !important;
    border-radius: 4px !important;
}

.en-markup-crop-options div div:first-of-type {
    margin-left: 0px !important;
}
</style><style type="text/css">
.gsc-control-cse {
font-family: Arial, sans-serif;
border-color: #FFFFFF;
background-color: #FFFFFF;
}
.gsc-control-cse .gsc-table-result {
font-family: Arial, sans-serif;
}
input.gsc-input, .gsc-input-box, .gsc-input-box-hover, .gsc-input-box-focus {
border-color: #D9D9D9;
}
input.gsc-search-button, input.gsc-search-button:hover, input.gsc-search-button:focus {
border-color: #2F5BB7;
background-color: #357AE8;
background-image: none;
filter: none;
}
.gsc-tabHeader.gsc-tabhInactive {
border-color: #CCCCCC;
background-color: #FFFFFF;
}
.gsc-tabHeader.gsc-tabhActive {
border-color: #CCCCCC;
border-bottom-color: #FFFFFF;
background-color: #FFFFFF;
}
.gsc-tabsArea {
border-color: #CCCCCC;
}
.gsc-webResult.gsc-result,
.gsc-results .gsc-imageResult {
border-color: #FFFFFF;
background-color: #FFFFFF;
}
.gsc-webResult.gsc-result:hover,
.gsc-imageResult:hover {
border-color: #FFFFFF;
background-color: #FFFFFF;
}
.gs-webResult.gs-result a.gs-title:link,
.gs-webResult.gs-result a.gs-title:link b,
.gs-imageResult a.gs-title:link,
.gs-imageResult a.gs-title:link b {
color: #1155CC;
}
.gs-webResult.gs-result a.gs-title:visited,
.gs-webResult.gs-result a.gs-title:visited b,
.gs-imageResult a.gs-title:visited,
.gs-imageResult a.gs-title:visited b {
color: #1155CC;
}
.gs-webResult.gs-result a.gs-title:hover,
.gs-webResult.gs-result a.gs-title:hover b,
.gs-imageResult a.gs-title:hover,
.gs-imageResult a.gs-title:hover b {
color: #1155CC;
}
.gs-webResult.gs-result a.gs-title:active,
.gs-webResult.gs-result a.gs-title:active b,
.gs-imageResult a.gs-title:active,
.gs-imageResult a.gs-title:active b {
color: #1155CC;
}
.gsc-cursor-page {
color: #1155CC;
}
a.gsc-trailing-more-results:link {
color: #1155CC;
}
.gs-webResult .gs-snippet,
.gs-imageResult .gs-snippet,
.gs-fileFormatType {
color: #333333;
}
.gs-webResult div.gs-visibleUrl,
.gs-imageResult div.gs-visibleUrl {
color: #009933;
}
.gs-webResult div.gs-visibleUrl-short {
color: #009933;
}
.gs-webResult div.gs-visibleUrl-short {
display: none;
}
.gs-webResult div.gs-visibleUrl-long {
display: block;
}
.gs-promotion div.gs-visibleUrl-short {
display: none;
}
.gs-promotion div.gs-visibleUrl-long {
display: block;
}
.gsc-cursor-box {
border-color: #FFFFFF;
}
.gsc-results .gsc-cursor-box .gsc-cursor-page {
border-color: #CCCCCC;
background-color: #FFFFFF;
color: #1155CC;
}
.gsc-results .gsc-cursor-box .gsc-cursor-current-page {
border-color: #CCCCCC;
background-color: #FFFFFF;
color: #1155CC;
}
.gsc-webResult.gsc-result.gsc-promotion {
border-color: #F6F6F6;
background-color: #F6F6F6;
}
.gsc-completion-title {
color: #1155CC;
}
.gsc-completion-snippet {
color: #333333;
}
.gs-promotion a.gs-title:link,
.gs-promotion a.gs-title:link *,
.gs-promotion .gs-snippet a:link {
color: #1155CC;
}
.gs-promotion a.gs-title:visited,
.gs-promotion a.gs-title:visited *,
.gs-promotion .gs-snippet a:visited {
color: #1155CC;
}
.gs-promotion a.gs-title:hover,
.gs-promotion a.gs-title:hover *,
.gs-promotion .gs-snippet a:hover {
color: #1155CC;
}
.gs-promotion a.gs-title:active,
.gs-promotion a.gs-title:active *,
.gs-promotion .gs-snippet a:active {
color: #1155CC;
}
.gs-promotion .gs-snippet,
.gs-promotion .gs-title .gs-promotion-title-right,
.gs-promotion .gs-title .gs-promotion-title-right * {
color: #333333;
}
.gs-promotion .gs-visibleUrl,
.gs-promotion .gs-visibleUrl-short {
color: #009933;
}
</style><style type="text/css">.gscb_a{display:inline-block;font:27px/13px arial,sans-serif}.gsst_a .gscb_a{color:#a1b9ed;cursor:pointer}.gsst_a:hover .gscb_a,.gsst_a:focus .gscb_a{color:#36c}.gsst_a{display:inline-block}.gsst_a{cursor:pointer;padding:0 4px}.gsst_a:hover{text-decoration:none!important}.gsst_b{font-size:16px;padding:0 2px;position:relative;user-select:none;-webkit-user-select:none;white-space:nowrap}.gsst_e{opacity:0.55;}.gsst_a:hover .gsst_e,.gsst_a:focus .gsst_e{opacity:0.72;}.gsst_a:active .gsst_e{opacity:1;}.gsst_f{background:white;text-align:left}.gsst_g{background-color:white;border:1px solid #ccc;border-top-color:#d9d9d9;box-shadow:0 2px 4px rgba(0,0,0,0.2);-webkit-box-shadow:0 2px 4px rgba(0,0,0,0.2);margin:-1px -3px;padding:0 6px}.gsst_h{background-color:white;height:1px;margin-bottom:-1px;position:relative;top:-1px}.gsib_a{width:100%;padding:4px 6px 0}.gsib_a,.gsib_b{vertical-align:top}.gssb_c{border:0;position:absolute;z-index:989}.gssb_e{border:1px solid #ccc;border-top-color:#d9d9d9;box-shadow:0 2px 4px rgba(0,0,0,0.2);-webkit-box-shadow:0 2px 4px rgba(0,0,0,0.2);cursor:default}.gssb_f{visibility:hidden;white-space:nowrap}.gssb_k{border:0;display:block;position:absolute;top:0;z-index:988}.gsdd_a{border:none!important}.gsq_a{padding:0}.gscsep_a{display:none}.gssb_a{padding:0 7px}.gssb_a,.gssb_a td{white-space:nowrap;overflow:hidden;line-height:22px}#gssb_b{font-size:11px;color:#36c;text-decoration:none}#gssb_b:hover{font-size:11px;color:#36c;text-decoration:underline}.gssb_g{text-align:center;padding:8px 0 7px;position:relative}.gssb_h{font-size:15px;height:28px;margin:0.2em;-webkit-appearance:button}.gssb_i{background:#eee}.gss_ifl{visibility:hidden;padding-left:5px}.gssb_i .gss_ifl{visibility:visible}a.gssb_j{font-size:13px;color:#36c;text-decoration:none;line-height:100%}a.gssb_j:hover{text-decoration:underline}.gssb_l{height:1px;background-color:#e5e5e5}.gssb_m{color:#000;background:#fff}.gsfe_a{border:1px solid #b9b9b9;border-top-color:#a0a0a0;box-shadow:inset 0px 1px 2px rgba(0,0,0,0.1);-moz-box-shadow:inset 0px 1px 2px rgba(0,0,0,0.1);-webkit-box-shadow:inset 0px 1px 2px rgba(0,0,0,0.1);}.gsfe_b{border:1px solid #4d90fe;outline:none;box-shadow:inset 0px 1px 2px rgba(0,0,0,0.3);-moz-box-shadow:inset 0px 1px 2px rgba(0,0,0,0.3);-webkit-box-shadow:inset 0px 1px 2px rgba(0,0,0,0.3);}.gssb_a{padding:0 9px}.gsib_a{padding-right:8px;padding-left:8px}.gsst_a{padding-top:3px}.gssb_e{border:0}.gssb_l{margin:5px 0}.gssb_c .gsc-completion-container{position:static}.gssb_c{z-index:5000}.gsc-completion-container table{background:transparent;font-size:inherit;font-family:inherit}.gssb_c > tbody > tr,.gssb_c > tbody > tr > td,.gssb_d,.gssb_d > tbody > tr,.gssb_d > tbody > tr > td,.gssb_e,.gssb_e > tbody > tr,.gssb_e > tbody > tr > td{padding:0;margin:0;border:0}.gssb_a table,.gssb_a table tr,.gssb_a table tr td{padding:0;margin:0;border:0}</style></head>
<body data-feedly-mini="yes" style="position: relative; min-height: 100%; top: 0px;"><div id="lingualy-logged-in" style="display:none;"></div><div id="lingualy-translate-btn" style="display: none;">	<a class="lingualy-translate-close"></a>	<img id="lingualy-translate-logo" src="chrome-extension://iilcekgoelpgecpjnnoikhbleipnjdhf/lookup/assets/translate/logo.png">	<a id="lingualy-translate-link">Translate?</a></div><div id="lingualy-installed" style="display:none;"></div><div id="lingualypopup" class="lingualy_popup bottom" style="display: none; height: 20px; width: 46px; margin-left: -23px;"></div>
<div id="leftBackground"></div><div id="topDIV" class="top"><div id="topLogo"><a href="http://www.w3schools.com/"><img src="./sku_files/w3logotest2.png" alt="W3Schools.com" style="border:0;"></a></div></div><div id="topnavDIV" class="topnavContainer"><div class="container-fluid" style="max-width:1600px;margin-left:0px;padding-left:0;"><ul class="nav nav-pills topnav"><li><a href="http://www.w3schools.com/default.asp" class="topnav_home" title="Home">&nbsp;</a></li><li><a href="http://www.w3schools.com/html/default.asp" class="topnav_html" title="HTML Tutorial">HTML</a></li><li><a href="http://www.w3schools.com/css/default.asp" class="topnav_css" title="CSS Tutorial">CSS</a></li><li><a href="http://www.w3schools.com/js/default.asp" class="topnav_js" title="JavaScript Tutorial">JAVASCRIPT</a></li><li><a href="http://www.w3schools.com/sql/default.asp" class="topnav_sql" title="SQL Tutorial">SQL</a></li><li><a href="http://www.w3schools.com/php/default.asp" class="topnav_php" title="PHP Tutorial">PHP</a></li><li><a href="http://www.w3schools.com/jquery/default.asp" class="topnav_jquery" title="jQuery Tutorial">jQUERY</a></li><li><a href="http://www.w3schools.com/bootstrap/default.asp" class="topnav_bootstrap" title="Bootstrap Tutorial">BOOTSTRAP</a></li><li><a href="http://www.w3schools.com/angular/default.asp" class="topnav_angular" title="Angular Tutorial">ANGULAR</a></li><li><a href="http://www.w3schools.com/xml/default.asp" class="topnav_xml" title="XML Tutorial">XML</a></li><li><a id="dropdownTutorialsBtn" href="http://www.w3schools.com/jsref/coll_form_elements.asp#" class="topnav_tutorials" title="More Tutorials">TUTORIALS <span class="caret"></span></a></li><li><a id="dropdownReferencesBtn" href="http://www.w3schools.com/jsref/coll_form_elements.asp#" class="topnav_references" title="More References">REFERENCES <span class="caret"></span></a></li><li><a id="dropdownExamplesBtn" href="http://www.w3schools.com/jsref/coll_form_elements.asp#" class="topnav_examples" title="More Examples">EXAMPLES <span class="caret"></span></a></li><li><a href="http://www.w3schools.com/forum/default.asp" class="topnav_forum" title="W3Schools Forum">FORUM</a></li><li class="menuBtn"><a href="javascript:void(0)" class="topnav_menu" onclick="vismenyen()" title="Menu"><hr><hr><hr></a></li><li class="menuSearch"><a id="dropdownSearchBtn" href="javascript:void(0);" class="topnav_search" title="Search W3Schools">&nbsp;</a></li><li class="menuTranslate"><a id="dropdownTranslateBtn" href="javascript:void(0);" class="topnav_translate" title="Translate W3Schools">&nbsp;</a></li></ul></div></div><div class="container-fluid master"><div class="row"><div class="col-lg-2 col-md-2 col-sm-3 menu"><div id="menyen"><div class="notranslate">
<h2 class="left"><span class="left_h2">JavaScript</span> Reference</h2>
<a target="_top" href="http://www.w3schools.com/jsref/default.asp" class="menu_default">Overview</a>
<br>
<h2 class="left"><span class="left_h2">JavaScript</span></h2>
<a target="_top" href="http://www.w3schools.com/jsref/jsref_obj_string.asp" class="menu_jsref_obj_string">JS String</a>
<a target="_top" href="http://www.w3schools.com/jsref/jsref_obj_number.asp" class="menu_jsref_obj_number">JS Number</a>
<a target="_top" href="http://www.w3schools.com/jsref/jsref_operators.asp" class="menu_jsref_operators">JS Operators</a>
<a target="_top" href="http://www.w3schools.com/jsref/jsref_statements.asp" class="menu_jsref_statements">JS Statements</a>
<a target="_top" href="http://www.w3schools.com/jsref/jsref_obj_math.asp" class="menu_jsref_obj_math">JS Math</a>
<a target="_top" href="http://www.w3schools.com/jsref/jsref_obj_date.asp" class="menu_jsref_obj_date">JS Date</a>
<a target="_top" href="http://www.w3schools.com/jsref/jsref_obj_array.asp" class="menu_jsref_obj_array">JS Array</a>
<a target="_top" href="http://www.w3schools.com/jsref/jsref_obj_boolean.asp" class="menu_jsref_obj_boolean">JS Boolean</a>
<a target="_top" href="http://www.w3schools.com/jsref/jsref_obj_regexp.asp" class="menu_jsref_obj_regexp">JS RegExp</a>
<a target="_top" href="http://www.w3schools.com/jsref/jsref_obj_global.asp" class="menu_jsref_obj_global">JS Global</a>
<br>
<h2 class="left"><span class="left_h2">Browser BOM</span></h2>
<a target="_top" href="http://www.w3schools.com/jsref/obj_window.asp" class="menu_obj_window">Window</a>
<a target="_top" href="http://www.w3schools.com/jsref/obj_navigator.asp" class="menu_obj_navigator">Navigator</a>
<a target="_top" href="http://www.w3schools.com/jsref/obj_screen.asp" class="menu_obj_screen">Screen</a>
<a target="_top" href="http://www.w3schools.com/jsref/obj_history.asp" class="menu_obj_history">History</a>
<a target="_top" href="http://www.w3schools.com/jsref/obj_location.asp" class="menu_obj_location">Location</a>
<br>
<h2 class="left"><span class="left_h2">HTML DOM</span></h2>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_document.asp" class="menu_dom_obj_document">DOM Document</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_all.asp" class="menu_dom_obj_all">DOM Elements</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_attributes.asp" class="menu_dom_obj_attributes">DOM Attributes</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_event.asp" class="menu_dom_obj_event">DOM Events</a>
<br>
<h2 class="left"><span class="left_h2">HTML Objects</span></h2>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_anchor.asp" class="menu_dom_obj_anchor">&lt;a&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_abbr.asp" class="menu_dom_obj_abbr">&lt;abbr&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_address.asp" class="menu_dom_obj_address">&lt;address&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_area.asp" class="menu_dom_obj_area">&lt;area&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_article.asp" class="menu_dom_obj_article">&lt;article&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_aside.asp" class="menu_dom_obj_aside">&lt;aside&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_audio.asp" class="menu_dom_obj_audio">&lt;audio&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_b.asp" class="menu_dom_obj_b">&lt;b&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_base.asp" class="menu_dom_obj_base">&lt;base&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_bdo.asp" class="menu_dom_obj_bdo">&lt;bdo&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_blockquote.asp" class="menu_dom_obj_blockquote">&lt;blockquote&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_body.asp" class="menu_dom_obj_body">&lt;body&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_br.asp" class="menu_dom_obj_br">&lt;br&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_pushbutton.asp" class="menu_dom_obj_pushbutton">&lt;button&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_canvas.asp" class="menu_dom_obj_canvas">&lt;canvas&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_caption.asp" class="menu_dom_obj_caption">&lt;caption&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_cite.asp" class="menu_dom_obj_cite">&lt;cite&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_code.asp" class="menu_dom_obj_code">&lt;code&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_col.asp" class="menu_dom_obj_col">&lt;col&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_colgroup.asp" class="menu_dom_obj_colgroup">&lt;colgroup&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_datalist.asp" class="menu_dom_obj_datalist">&lt;datalist&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_dd.asp" class="menu_dom_obj_dd">&lt;dd&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_del.asp" class="menu_dom_obj_del">&lt;del&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_details.asp" class="menu_dom_obj_details">&lt;details&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_dfn.asp" class="menu_dom_obj_dfn">&lt;dfn&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_dialog.asp" class="menu_dom_obj_dialog">&lt;dialog&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_div.asp" class="menu_dom_obj_div">&lt;div&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_dl.asp" class="menu_dom_obj_dl">&lt;dl&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_dt.asp" class="menu_dom_obj_dt">&lt;dt&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_em.asp" class="menu_dom_obj_em">&lt;em&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_embed.asp" class="menu_dom_obj_embed">&lt;embed&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_fieldset.asp" class="menu_dom_obj_fieldset">&lt;fieldset&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_figcaption.asp" class="menu_dom_obj_figcaption">&lt;figcaption&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_figure.asp" class="menu_dom_obj_figure">&lt;figure&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_footer.asp" class="menu_dom_obj_footer">&lt;footer&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_form.asp" class="menu_dom_obj_form">&lt;form&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_head.asp" class="menu_dom_obj_head">&lt;head&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_header.asp" class="menu_dom_obj_header">&lt;header&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_hgroup.asp" class="menu_dom_obj_hgroup">&lt;hgroup&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_heading.asp" class="menu_dom_obj_heading">&lt;h1&gt; - &lt;h6&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_hr.asp" class="menu_dom_obj_hr">&lt;hr&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_html.asp" class="menu_dom_obj_html">&lt;html&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_i.asp" class="menu_dom_obj_i">&lt;i&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_frame.asp" class="menu_dom_obj_frame">&lt;iframe&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_image.asp" class="menu_dom_obj_image">&lt;img&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_ins.asp" class="menu_dom_obj_ins">&lt;ins&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_button.asp" class="menu_dom_obj_button">&lt;input&gt; button</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_checkbox.asp" class="menu_dom_obj_checkbox">&lt;input&gt; checkbox</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_color.asp" class="menu_dom_obj_color">&lt;input&gt; color</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_date.asp" class="menu_dom_obj_date">&lt;input&gt; date</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_datetime.asp" class="menu_dom_obj_datetime">&lt;input&gt; datetime</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_datetime-local.asp" class="menu_dom_obj_datetime-local">&lt;input&gt; datetime-local</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_email.asp" class="menu_dom_obj_email">&lt;input&gt; email</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_fileupload.asp" class="menu_dom_obj_fileupload">&lt;input&gt; file</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_hidden.asp" class="menu_dom_obj_hidden">&lt;input&gt; hidden</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_input_image.asp" class="menu_dom_obj_input_image">&lt;input&gt; image</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_month.asp" class="menu_dom_obj_month">&lt;input&gt; month</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_number.asp" class="menu_dom_obj_number">&lt;input&gt; number</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_password.asp" class="menu_dom_obj_password">&lt;input&gt; password</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_radio.asp" class="menu_dom_obj_radio">&lt;input&gt; radio</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_range.asp" class="menu_dom_obj_range">&lt;input&gt; range</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_reset.asp" class="menu_dom_obj_reset">&lt;input&gt; reset</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_search.asp" class="menu_dom_obj_search">&lt;input&gt; search</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_submit.asp" class="menu_dom_obj_submit">&lt;input&gt; submit</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_text.asp" class="menu_dom_obj_text">&lt;input&gt; text</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_input_time.asp" class="menu_dom_obj_input_time">&lt;input&gt; time</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_url.asp" class="menu_dom_obj_url">&lt;input&gt; url</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_week.asp" class="menu_dom_obj_week">&lt;input&gt; week</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_kbd.asp" class="menu_dom_obj_kbd">&lt;kbd&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_keygen.asp" class="menu_dom_obj_keygen">&lt;keygen&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_label.asp" class="menu_dom_obj_label">&lt;label&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_legend.asp" class="menu_dom_obj_legend">&lt;legend&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_li.asp" class="menu_dom_obj_li">&lt;li&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_link.asp" class="menu_dom_obj_link">&lt;link&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_map.asp" class="menu_dom_obj_map">&lt;map&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_mark.asp" class="menu_dom_obj_mark">&lt;mark&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_menu.asp" class="menu_dom_obj_menu">&lt;menu&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_menuitem.asp" class="menu_dom_obj_menuitem">&lt;menuitem&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_meta.asp" class="menu_dom_obj_meta">&lt;meta&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_meter.asp" class="menu_dom_obj_meter">&lt;meter&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_nav.asp" class="menu_dom_obj_nav">&lt;nav&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_object.asp" class="menu_dom_obj_object">&lt;object&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_ol.asp" class="menu_dom_obj_ol">&lt;ol&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_optgroup.asp" class="menu_dom_obj_optgroup">&lt;optgroup&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_option.asp" class="menu_dom_obj_option">&lt;option&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_output.asp" class="menu_dom_obj_output">&lt;output&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_paragraph.asp" class="menu_dom_obj_paragraph">&lt;p&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_param.asp" class="menu_dom_obj_param">&lt;param&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_pre.asp" class="menu_dom_obj_pre">&lt;pre&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_progress.asp" class="menu_dom_obj_progress">&lt;progress&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_quote.asp" class="menu_dom_obj_quote">&lt;q&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_s.asp" class="menu_dom_obj_s">&lt;s&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_samp.asp" class="menu_dom_obj_samp">&lt;samp&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_script.asp" class="menu_dom_obj_script">&lt;script&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_section.asp" class="menu_dom_obj_section">&lt;section&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_select.asp" class="menu_dom_obj_select">&lt;select&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_small.asp" class="menu_dom_obj_small">&lt;small&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_source.asp" class="menu_dom_obj_source">&lt;source&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_span.asp" class="menu_dom_obj_span">&lt;span&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_strong.asp" class="menu_dom_obj_strong">&lt;strong&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_style.asp" class="menu_dom_obj_style">&lt;style&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_sub.asp" class="menu_dom_obj_sub">&lt;sub&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_summary.asp" class="menu_dom_obj_summary">&lt;summary&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_sup.asp" class="menu_dom_obj_sup">&lt;sup&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_table.asp" class="menu_dom_obj_table">&lt;table&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_tabledata.asp" class="menu_dom_obj_tabledata">&lt;td&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_tablehead.asp" class="menu_dom_obj_tablehead">&lt;th&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_tablerow.asp" class="menu_dom_obj_tablerow">&lt;tr&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_textarea.asp" class="menu_dom_obj_textarea">&lt;textarea&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_time.asp" class="menu_dom_obj_time">&lt;time&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_title.asp" class="menu_dom_obj_title">&lt;title&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_track.asp" class="menu_dom_obj_track">&lt;track&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_u.asp" class="menu_dom_obj_u">&lt;u&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_ul.asp" class="menu_dom_obj_ul">&lt;ul&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_var.asp" class="menu_dom_obj_var">&lt;var&gt;</a>
<a target="_top" href="http://www.w3schools.com/jsref/dom_obj_video.asp" class="menu_dom_obj_video">&lt;video&gt;</a>
<br>
</div></div></div><div class="col-lg-10 col-md-10 col-sm-9 leaderboard"><div id="mainLeaderboard" style="overflow:hidden;"><!--<img src='/images/testbanner.png'>--><!-- MainLeaderboard--><div id="div-gpt-ad-1422003450156-2"><script type="text/javascript">googletag.cmd.push(function() { googletag.display('div-gpt-ad-1422003450156-2'); });</script><div id="google_ads_iframe_/16833175/MainLeaderboard_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/16833175/MainLeaderboard_0" name="google_ads_iframe_/16833175/MainLeaderboard_0" width="728" height="90" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom;"></iframe></div><iframe id="google_ads_iframe_/16833175/MainLeaderboard_0__hidden__" name="google_ads_iframe_/16833175/MainLeaderboard_0__hidden__" width="0" height="0" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom; visibility: hidden; display: none;"></iframe></div></div><div class="row"><div class="col-lg-10 col-md-10 col-sm-12 main"><div>
<h1>Form <span class="color_h1">elements</span> Collection</h1>
<p lingdex="0"><a href="http://www.w3schools.com/jsref/dom_obj_form.asp"><img class="navup" src="./sku_files/up.gif" alt="Form Object Reference"> Form Object</a></p>

<div class="example">
<h2 class="example">Example</h2>
	<p lingdex="1">Find out how many elements there are in a specified &lt;form&gt; element:</p>
<div class="example_code notranslate jsHigh">
	<span class="highELE">var</span> x = document.getElementById(<span class="highVAL">"myForm"</span>).elements.length;</div>
	<p lingdex="2">The result of <em>x</em> will be:</p>
<div class="example_code notranslate">
	3</div>
<br>
<a target="_blank" class="tryitbtn" href="http://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_form_elements_length">Try it yourself »</a>
</div>
<p lingdex="3">More "Try it Yourself" examples below.</p>
<hr>

<h2>Definition and Usage</h2>
<p lingdex="4">The elements collection returns a collection of all elements in a form.</p>
<p lingdex="5"><b>Note:</b> The elements in the collection are sorted as they appear in the source code.</p>
<p lingdex="6"><strong>Note:</strong> The elements collection returns all <strong>elements</strong> inside the &lt;form&gt; element, not all &lt;form&gt; elements in the document. To get all &lt;form&gt; elements in the document, use the <a href="http://www.w3schools.com/jsref/coll_doc_forms.asp">document.forms</a> collection instead.</p>
<hr>

<h2>Browser Support</h2>
<table class="browserref notranslate">
  <tbody><tr>
    <th style="width:20%;font-size:16px;text-align:left;">Collection</th>
    <th style="width:16%;" class="bsChrome" title="Chrome"></th>
    <th style="width:16%;" class="bsIE" title="Internet Explorer"></th>
    <th style="width:16%;" class="bsFirefox" title="Firefox"></th>
    <th style="width:16%;" class="bsSafari" title="Safari"></th>
    <th style="width:16%;" class="bsOpera" title="Opera"></th>                
  </tr>
  <tr>
    <td style="text-align:left;">elements</td>
    <td>Yes</td>
    <td>Yes</td>
    <td>Yes</td>
    <td>Yes</td>
    <td>Yes</td>
  </tr>
</tbody></table>

<hr>

<h2>Syntax</h2>
<div class="code notranslate"><div>
	<em>formObject</em>.elements</div></div>
<h2>Properties</h2>
<table class="reference notranslate">
  <tbody><tr>
    <th style="width:20%">Property</th>
    <th>Description</th>
  </tr>
  <tr>
    <td>length</td>
    <td>Returns the number of elements in the &lt;form&gt; element.<br>
	<br><strong>Note:</strong> This property is read-only</td>
  </tr>
</tbody></table>

<h2>Methods</h2>
<table class="reference notranslate">
  <tbody><tr>
    <th style="width:20%">Method</th>
    <th>Description</th>
  </tr>
  <tr>
    <td>[<i>index</i>]</td>
    <td>Returns the element in &lt;form&gt; with the specified index 
	(starts at 0).<br><br><strong>Note:</strong> Returns null if the index 
	number is out of range</td>
    </tr>
  <tr>
    <td>item(<i>index</i>)</td>
    <td>Returns the element in &lt;form&gt; with the specified index 
	(starts at 0).<br><br><strong>Note:</strong> Returns null if the index number 
	is out of range</td>
    </tr>
  <tr>
    <td>namedItem(<i>id</i>)</td>
    <td>Returns the element in &lt;form&gt; with the specified id.<br><br>
	<strong>Note:</strong> Returns null if the id does not exist</td>
    </tr>
</tbody></table>

<h2>Technical Details</h2>
<table class="tecspec">
  <tbody><tr>
	<th style="width:20%;">DOM Version:</th>
	<td>Core Level 2 Document Object</td>
  </tr>
  <tr>
	<th style="width:20%;">Return Value:</th>
	<td>An HTMLFormsControlCollection Object, representing all elements in a &lt;form&gt; element. The elements in the collection are sorted as they appear 
	in the source code</td>
  </tr>
</tbody></table>

<hr>

<div class="tryit_ex">
<img src="./sku_files/tryitimg.gif" style="width:40px;height:46px" alt="Examples">
<h2>More Examples</h2>
</div>
<div class="example">
<h2 class="example">Example</h2>
<p lingdex="7">[<em>index</em>]</p>
	<p lingdex="8">Get the value of the first element (index 0) in a form:</p>
<div class="example_code notranslate jsHigh">
	<span class="highELE">var</span> x = document.getElementById(<span class="highVAL">"myForm"</span>).elements[<span class="highVAL">0</span>].value;</div>
			<p lingdex="9">The result of <em>x</em> will be:</p>
<div class="example_code notranslate">
	Donald</div>
<br>
<a target="_blank" class="tryitbtn" href="http://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_form_elements_index">Try it yourself »</a>
</div>
<br>

<div class="example">
<h2 class="example">Example</h2>
<p lingdex="10">item(<em>index</em>)</p>
	<p lingdex="11">Get the value of the first element (index 0) in a form:</p>
<div class="example_code notranslate jsHigh">
	<span class="highELE">var</span> x = document.getElementById(<span class="highVAL">"myForm"</span>).elements.item(<span class="highVAL">0</span>).value;</div>
		<p lingdex="12">The result of <em>x</em> will be:</p>
<div class="example_code notranslate">
	Donald</div>
<br>
<a target="_blank" class="tryitbtn" href="http://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_form_elements_item">Try it yourself »</a>
</div>
<br>

<div class="example">
<h2 class="example">Example</h2>
<p lingdex="13">namedItem(<em>id</em>)</p>
	<p lingdex="14">Get the value of the element with name="fname" in a form:</p>
<div class="example_code notranslate jsHigh">
	<span class="highELE">var</span> x = document.getElementById(<span class="highVAL">"myForm"</span>).elements.namedItem(<span class="highVAL">"fname"</span>).value;</div>
		<p lingdex="15">The result of <em>x</em> will be:</p>
<div class="example_code notranslate">
	Donald</div>
<br>
<a target="_blank" class="tryitbtn" href="http://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_form_elements_nameditem">Try it yourself »</a>
</div>
<br>

<div class="example">
<h2 class="example">Example</h2>
<p lingdex="16">Loop through all elements in a form and output the value of each element:</p>
<div class="example_code notranslate jsHigh">
	<span class="highELE">var</span> x = document.getElementById(<span class="highVAL">"myForm"</span>);<br><span class="highELE">var</span> txt = <span class="highVAL">""</span>;<br>
	<span class="highELE">var</span> i;<br><span class="highELE">for</span> (i = <span class="highVAL">0</span>; i &lt; x.length; i++)
	{<br>&nbsp;&nbsp;&nbsp; txt = txt + x.elements[i].value + <span class="highVAL">"&lt;br&gt;"</span>;<br>
	}<br>
	document.getElementById(<span class="highVAL">"demo"</span>).innerHTML = txt;</div>
<p lingdex="17">The result of <em>txt</em> will be:</p>
<div class="example_code notranslate">
Donald<br>
Duck<br>
Submit</div>
<br>
<a target="_blank" class="tryitbtn" href="http://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_form_elements">Try it yourself »</a>
</div>
<hr>
<a href="http://www.w3schools.com/jsref/dom_obj_form.asp"><img class="navup" src="./sku_files/up.gif" alt="Form Object Reference"> Form Object</a>

     <br>
    </div>
   </div>
   <div class="col-lg-2 col-md-2 col-sm-12">
    <div class="row">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sidesection" style="margin-bottom:5px;">
      <h3>WEB HOSTING</h3>
      <a target="_blank" rel="nofollow" href="https://www.heartinternet.uk/?utm_source=w3schools&utm_medium=cpc&utm_campaign=w3schools%20text%20link">UK Reseller Hosting</a>
     </div>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sidesection">
      <h3>WEB BUILDING</h3>
      <a target="_blank" rel="nofollow" href="http://www.wix.com/eteamhtml/templatesnr-a-d-e-w3?utm_campaign=ma_w3schools.com&experiment_id=ma_w3schools.comlink1_templatesnr-a-d-e-w3">FREE Website BUILDER</a>
      <a target="_blank" rel="nofollow" href="http://www.wix.com/eteamhtml/templatesnr-a-d-e-w3?utm_campaign=ma_w3schools.com&experiment_id=ma_w3schools.comlink2_freehtml5templates_templatesnr-a-d-e-w3">Free HTML5 Templates</a>        
     </div>
    </div>
    <div class="row">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sidesection" style="margin-top:10px;padding:0;overflow:visible;">
      <div id="skyscraper">
       <div id="div-gpt-ad-1422003450156-5"> 
        <script>
         googletag.cmd.push(function() {
         googletag.display('div-gpt-ad-1422003450156-5');
         });
        </script> 
       <div id="google_ads_iframe_/16833175/WideSkyScraper_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/16833175/WideSkyScraper_0" name="google_ads_iframe_/16833175/WideSkyScraper_0" width="300" height="600" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom;"></iframe></div><iframe id="google_ads_iframe_/16833175/WideSkyScraper_0__hidden__" name="google_ads_iframe_/16833175/WideSkyScraper_0__hidden__" width="0" height="0" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom; visibility: hidden; display: none;"></iframe></div>
      </div>
     </div>
    </div>
    <div class="row">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sidesection" style="padding:0;overflow:hidden;">
      <h3>W3SCHOOLS EXAMS</h3>
      <a target="_blank" href="http://www.w3schools.com/cert/default.asp">HTML, CSS, JavaScript, PHP, jQuery, and XML Certifications</a>
     </div>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sidesection">
      <h3>SHARE THIS PAGE</h3>
      <div class="shareContainer">
       <script>
       <!--
       try{
       loc=location.pathname;
       if (loc.toUpperCase().indexOf(".ASP")<0) loc=loc+"default.asp";
       txt='<ul id="sharelist">'
       txt=txt+'<li id="facebook"><a href="http://www.facebook.com/sharer.php?u=http://www.w3schools.com'+loc+'" target="_blank" title="Facebook"></a></li>';
       txt=txt+'<li id="twitter"><a href="http://twitter.com/home?status=Currently reading http://www.w3schools.com'+loc+'" target="_blank" title="Twitter"></a></li>';
       txt=txt+'<li id="email"><a href="mailto:?&amp;subject='+document.title+'&amp;body=Take%20a%20look%20at%20this%20page%20at%20W3Schools.com:%20http://www.w3schools.com'+loc+'" target="_blank"  title="E-mail"></a></li>';
       txt=txt+'<li id="googleplus"><a href="https://plus.google.com/share?url=http://www.w3schools.com'+loc+'" target="_blank" title="Google+"></a></li>';
       txt=txt+'</ul>';
       document.write(txt);
       }
       catch(e) {}
       //-->
       </script><ul id="sharelist"><li id="facebook"><a href="http://www.facebook.com/sharer.php?u=http://www.w3schools.com/jsref/coll_form_elements.asp" target="_blank" title="Facebook"></a></li><li id="twitter"><a href="http://twitter.com/home?status=Currently%20reading%20http://www.w3schools.com/jsref/coll_form_elements.asp" target="_blank" title="Twitter"></a></li><li id="email"><a href="mailto:?&subject=HTML%20DOM%20Form%20elements%20Collection&body=Take%20a%20look%20at%20this%20page%20at%20W3Schools.com:%20http://www.w3schools.com/jsref/coll_form_elements.asp" target="_blank" title="E-mail"></a></li><li id="googleplus"><a href="https://plus.google.com/share?url=http://www.w3schools.com/jsref/coll_form_elements.asp" target="_blank" title="Google+"></a></li></ul>
      </div>
     </div>
    </div>
    <div class="row">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sidesection" style="padding:0;margin-top:0;overflow:hidden;">
      <h3>COLOR PICKER</h3>
      <a href="http://www.w3schools.com/tags/ref_colorpicker.asp">
      <img src="./sku_files/colorpicker.gif" alt="colorpicker"></a>
     </div>
    </div>
   </div>
  </div>
  
  <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">

<hr style="margin-bottom:0;">
<div style="overflow:hidden;">
<!-- SmallPS -->
<div id="div-gpt-ad-1422003450156-4">
<script type="text/javascript">
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1422003450156-4'); });
</script>
<div id="google_ads_iframe_/16833175/SmallPS_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/16833175/SmallPS_0" name="google_ads_iframe_/16833175/SmallPS_0" width="728" height="170" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom;"></iframe></div><iframe id="google_ads_iframe_/16833175/SmallPS_0__hidden__" name="google_ads_iframe_/16833175/SmallPS_0__hidden__" width="0" height="0" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom; visibility: hidden; display: none;"></iframe></div>
<!-- LargePS -->
<div id="div-gpt-ad-1422003450156-1" style="display: none;">
<script type="text/javascript">
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1422003450156-1'); });
</script>
<div id="google_ads_iframe_/16833175/LargePS_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/16833175/LargePS_0" name="google_ads_iframe_/16833175/LargePS_0" width="728" height="280" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom;"></iframe></div><iframe id="google_ads_iframe_/16833175/LargePS_0__hidden__" name="google_ads_iframe_/16833175/LargePS_0__hidden__" width="0" height="0" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom; visibility: hidden; display: none;"></iframe></div>
<!-- BottomMediumRectangle -->
<div id="div-gpt-ad-1422003450156-0">
<script type="text/javascript">
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1422003450156-0'); });
</script>
<div id="google_ads_iframe_/16833175/BottomMediumRectangle_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/16833175/BottomMediumRectangle_0" name="google_ads_iframe_/16833175/BottomMediumRectangle_0" width="970" height="250" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom;"></iframe></div><iframe id="google_ads_iframe_/16833175/BottomMediumRectangle_0__hidden__" name="google_ads_iframe_/16833175/BottomMediumRectangle_0__hidden__" width="0" height="0" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom; visibility: hidden; display: none;"></iframe></div>
<!-- RightBottomMediumRectangle -->
<div id="div-gpt-ad-1422003450156-3">
<script type="text/javascript">
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1422003450156-3'); });
</script>
<div id="google_ads_iframe_/16833175/RightBottomMediumRectangle_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/16833175/RightBottomMediumRectangle_0" name="google_ads_iframe_/16833175/RightBottomMediumRectangle_0" width="336" height="280" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom;"></iframe></div><iframe id="google_ads_iframe_/16833175/RightBottomMediumRectangle_0__hidden__" name="google_ads_iframe_/16833175/RightBottomMediumRectangle_0__hidden__" width="0" height="0" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:"<html><body style='background:transparent'></body></html>"" style="border: 0px; vertical-align: bottom; visibility: hidden; display: none;"></iframe></div>
<div style="clear:both"></div>
</div>



    <div class="footer">
     <hr style="margin-bottom:14px;margin-top:0px;">
     <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-12">
	   <a href="" onclick="displayError();return false" style="white-space:nowrap;">REPORT ERROR</a>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-12">
       <a href="" target="_blank" onclick="printPage();return false;">PRINT PAGE</a>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-12">
       <a href="http://www.w3schools.com/forum/default.asp" target="_blank">FORUM</a>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-12">
	   <a href="http://www.w3schools.com/about/default.asp" target="_top">ABOUT</a>
      </div>
     </div>
     <hr style="margin-bottom:2px;margin-top:14px;">
     <div class="container-fluid jumbotron" id="err_form">
      <button type="button" class="close" onclick="hideError()"><span>×</span></button>
      <h2>Your Suggestion:</h2>
      <form role="form">
      <div class="form-group">
        <label for="err_email">Your Email:</label>
        <input class="form-control" type="email" id="err_email" name="err_email">
      </div>
      <div class="form-group">
        <label for="err_email">Page address:</label>
        <input class="form-control" type="text" id="err_url" name="err_url" disabled="disabled">
      </div>
      <div class="form-group">
        <label for="err_email">Description:</label>
        <textarea rows="10" class="form-control" id="err_desc" name="err_desc"></textarea>
      </div>
      <div class="form-group">        
        <button type="button" class="btn btn-default" onclick="sendErr()">Submit</button>
      </div>
      </form>
     </div>
     <div class="container-fluid jumbotron" id="err_sent" style="clear:both;">
      <button type="button" class="close" onclick="hideSent()"><span>×</span></button>
      <h2>Thank You For Helping Us!</h2>
      <p lingdex="18">Your message has been sent to W3Schools.</p>
     </div>
         
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="top10">
                  <h3>Top 10 Tutorials</h3>
                  <a href="http://www.w3schools.com/html/default.asp">HTML Tutorial</a><br>
                  <a href="http://www.w3schools.com/css/default.asp">CSS Tutorial</a><br>
                  <a href="http://www.w3schools.com/js/default.asp">JavaScript Tutorial</a><br>
                  <a href="http://www.w3schools.com/sql/default.asp">SQL Tutorial</a><br>
                  <a href="http://www.w3schools.com/php/default.asp">PHP Tutorial</a><br>
                  <a href="http://www.w3schools.com/jquery/default.asp">jQuery Tutorial</a><br>
                  <a href="http://www.w3schools.com/bootstrap/default.asp">Bootstrap Tutorial</a><br>
                  <a href="http://www.w3schools.com/angular/default.asp">Angular Tutorial</a><br>
                  <a href="http://www.w3schools.com/aspnet/default.asp">ASP.NET Tutorial</a><br>
                  <a href="http://www.w3schools.com/xml/default.asp">XML Tutorial</a><br>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="top10">
                  <h3>Top 10 References</h3>
                  <a href="http://www.w3schools.com/tags/default.asp">HTML Reference</a><br>
                  <a href="http://www.w3schools.com/cssref/default.asp">CSS Reference</a><br>
                  <a href="http://www.w3schools.com/jsref/default.asp">JavaScript Reference</a><br>
                  <a href="http://www.w3schools.com/browsers/default.asp">Browser Statistics</a><br>
                  <a href="http://www.w3schools.com/jsref/dom_obj_document.asp">HTML DOM</a><br>
                  <a href="http://www.w3schools.com/php/php_ref_array.asp">PHP Reference</a><br>
                  <a href="http://www.w3schools.com/jquery/jquery_ref_selectors.asp">jQuery Reference</a><br>
                  <a href="http://www.w3schools.com/tags/ref_colornames.asp">HTML Colors</a><br>
                  <a href="http://www.w3schools.com/charsets/default.asp">HTML Character Sets</a><br>
                  <a href="http://www.w3schools.com/dom/dom_nodetype.asp">XML DOM</a><br>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="top10">
                  <h3>Top 10 Examples</h3>
                  <a href="http://www.w3schools.com/html/html_examples.asp">HTML Examples</a><br>
                  <a href="http://www.w3schools.com/css/css_examples.asp">CSS Examples</a><br>
                  <a href="http://www.w3schools.com/js/js_examples.asp">JavaScript Examples</a><br>
                  <a href="http://www.w3schools.com/js/js_dom_examples.asp">HTML DOM Examples</a><br>
                  <a href="http://www.w3schools.com/php/php_examples.asp">PHP Examples</a><br>
                  <a href="http://www.w3schools.com/jquery/jquery_examples.asp">jQuery Examples</a><br>
                  <a href="http://www.w3schools.com/xml/xml_examples.asp">XML Examples</a><br>
                  <a href="http://www.w3schools.com/dom/dom_examples.asp">XML DOM Examples</a><br>
                  <a href="http://www.w3schools.com/asp/asp_examples.asp">ASP Examples</a><br>
                  <a href="http://www.w3schools.com/svg/svg_examples.asp">SVG Examples</a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="top10">
                  <h3>Web Certificates</h3>
                  <a href="http://www.w3schools.com/cert/default.asp">HTML Certificate</a><br>
                  <a href="http://www.w3schools.com/cert/default.asp">HTML5 Certificate</a><br>
                  <a href="http://www.w3schools.com/cert/default.asp">CSS Certificate</a><br>
                  <a href="http://www.w3schools.com/cert/default.asp">JavaScript Certificate</a><br>
                  <a href="http://www.w3schools.com/cert/default.asp">jQuery Certificate</a><br>
                  <a href="http://www.w3schools.com/cert/default.asp">PHP Certificate</a><br>
                  <a href="http://www.w3schools.com/cert/default.asp">XML Certificate</a><br>
                  
                </div>
              </div>        
            </div>        
     <hr>
    </div>
     <div class="footer">
       W3Schools is optimized for learning, testing, and training. Examples might be simplified to improve reading and basic understanding.
       Tutorials, references, and examples are constantly reviewed to avoid errors, but we cannot warrant full correctness of all content.
       While using this site, you agree to have read and accepted our <a href="http://www.w3schools.com/about/about_copyright.asp">terms of use</a>,
       <a href="http://www.w3schools.com/about/about_privacy.asp">cookie and privacy policy</a>.
       <a href="http://www.w3schools.com/about/about_copyright.asp">Copyright 1999-2015</a> by Refsnes Data. All Rights Reserved.<br><br>
       <a href="http://www.w3schools.com/">
       <img style="width:150px;height:28px;border:0" src="./sku_files/w3schoolscom_gray.gif" alt="W3Schools.com"></a>
     </div>

   </div>
  </div>
 </div>

</div>
</div>
<div id="w3dropdowntutorials" class="w3DropdownMenu container-fluid w3DropdownMenuNotScroll">
<div class="w3DropdownInner">
<button type="button" class="close w3DropdownClose" onclick="hideDropdownMenu()" title="Close"><span>×</span></button>
<br>
<div class="w3DropdownItem">
<h3>HTML/CSS</h3>
<a href="http://www.w3schools.com/html/default.asp">HTML Tutorial</a>
<a href="http://www.w3schools.com/html/html5_intro.asp">HTML5 Tutorial</a>
<a href="http://www.w3schools.com/css/default.asp">CSS Tutorial</a>
<a href="http://www.w3schools.com/css/css3_intro.asp">CSS3 Tutorial</a>
<a href="http://www.w3schools.com/bootstrap/default.asp">Bootstrap Tutorial</a>
</div>
<div class="w3DropdownItem">
<h3>JavaScript</h3>
<a href="http://www.w3schools.com/js/default.asp">JavaScript Tutorial</a>
<a href="http://www.w3schools.com/jquery/default.asp">jQuery Tutorial</a>
<a href="http://www.w3schools.com/jquerymobile/default.asp">jQuery Mobile Tutorial</a>
<a href="http://www.w3schools.com/angular/default.asp">AngularJS Tutorial</a>
<a href="http://www.w3schools.com/ajax/default.asp">AJAX Tutorial</a>
<a href="http://www.w3schools.com/json/default.asp">JSON Tutorial</a>
</div>
<div class="w3DropdownItem">
<h3>Graphics</h3>
<a href="http://www.w3schools.com/canvas/default.asp">Canvas Tutorial</a>
<a href="http://www.w3schools.com/svg/default.asp">SVG Tutorial</a>
<a href="http://www.w3schools.com/googleapi/default.asp">Google Maps Tutorial</a>
</div>
<div class="w3DropdownItem">
<h3>Server Side</h3>
<a href="http://www.w3schools.com/sql/default.asp">SQL Tutorial</a>
<a href="http://www.w3schools.com/php/default.asp">PHP Tutorial</a>
<a href="http://www.w3schools.com/asp/default.asp">ASP Tutorial</a>
<a href="http://www.w3schools.com/aspnet/default.asp">ASP.NET Tutorial</a>
<a href="http://www.w3schools.com/vbscript/default.asp">VBScript Tutorial</a>
<a href="http://www.w3schools.com/appml/default.asp">AppML Tutorial</a>
</div>
<div class="w3DropdownItem">
<h3>Web</h3>
<a href="http://www.w3schools.com/website/default.asp">Web Building</a>
<a href="http://www.w3schools.com/browsers/default.asp">Web Statistics</a>
<a href="http://www.w3schools.com/cert/default.asp">Web Certification</a>
</div>
<div class="w3DropdownItem">
<h3>XML</h3>
<a href="http://www.w3schools.com/xml/default.asp">XML Tutorial</a>
<a href="http://www.w3schools.com/dtd/default.asp">DTD Tutorial</a>
<a href="http://www.w3schools.com/schema/default.asp">Schema Tutorial</a>
<a href="http://www.w3schools.com/dom/default.asp">XML DOM Tutorial</a>
<a href="http://www.w3schools.com/xpath/default.asp">XPath Tutorial</a>
<a href="http://www.w3schools.com/xsl/default.asp">XSLT Tutorial</a>
<a href="http://www.w3schools.com/xquery/default.asp">XQuery Tutorial</a>
<a href="http://www.w3schools.com/rss/default.asp">RSS Tutorial</a>
<a href="http://www.w3schools.com/webservices/default.asp">WSDL Tutorial</a>
</div>
</div>
</div>
<div id="w3dropdownreferences" class="w3DropdownMenu container-fluid w3DropdownMenuNotScroll">
<div class="w3DropdownInner">
<button type="button" class="close w3DropdownClose" onclick="hideDropdownMenu()" title="Close"><span>×</span></button>
<br>
<div class="w3DropdownItem">
<h3>HTML/CSS</h3>
<a href="http://www.w3schools.com/tags/default.asp">HTML Tag Reference</a>
<a href="http://www.w3schools.com/tags/ref_eventattributes.asp">HTML Event Reference</a>
<a href="http://www.w3schools.com/tags/ref_colornames.asp">HTML Color Reference</a>
<a href="http://www.w3schools.com/cssref/default.asp">CSS 1,2,3 Reference</a>
<a href="http://www.w3schools.com/bootstrap/bootstrap_ref_css_text.asp">Bootstrap Reference</a>
</div>
<div class="w3DropdownItem">
<h3>JavaScript</h3>
<a href="http://www.w3schools.com/jsref/default.asp">JavaScript Reference</a>
<a href="http://www.w3schools.com/jsref/default.asp">HTML DOM Reference</a>
<a href="http://www.w3schools.com/jquery/jquery_ref_selectors.asp">jQuery Reference</a>
<a href="http://www.w3schools.com/jquerymobile/jquerymobile_ref_data.asp">jQuery Mobile Reference</a>
<a href="http://www.w3schools.com/googleAPI/google_maps_ref.asp">Google Maps Reference</a>
</div>
<div class="w3DropdownItem">
<h3>Server Side</h3>
<a href="http://www.w3schools.com/php/php_ref_array.asp">PHP Reference</a>
<a href="http://www.w3schools.com/sql/sql_quickref.asp">SQL Reference</a>
<a href="http://www.w3schools.com/asp/asp_ref_response.asp">ASP Reference</a>
<a href="http://www.w3schools.com/vbscript/vbscript_ref_functions.asp">VBScript Reference</a>
<a href="http://www.w3schools.com/aspnet/webpages_ref_classes.asp">Razor Reference</a>
<a href="http://www.w3schools.com/aspnet/aspnet_refhtmlcontrols.asp">ASP.NET Reference</a>
</div>
<div class="w3DropdownItem">
<h3>XML</h3>
<a href="http://www.w3schools.com/dom/dom_nodetype.asp">XML DOM Reference</a>
<a href="http://www.w3schools.com/xsl/xsl_w3celementref.asp">XSLT Reference</a>
<a href="http://www.w3schools.com/xpath/xpath_functions.asp">XPath Reference</a>
<a href="http://www.w3schools.com/xquery/xquery_reference.asp">XQuery Reference</a>
<a href="http://www.w3schools.com/schema/schema_elements_ref.asp">Schema Reference</a>
<a href="http://www.w3schools.com/rss/rss_reference.asp">RSS Reference</a>
<a href="http://www.w3schools.com/svg/svg_reference.asp">SVG Reference</a>
</div>
<div class="w3DropdownItem">
<h3>HTML Charsets</h3>
<a href="http://www.w3schools.com/charsets/default.asp">HTML Character Sets</a>
<a href="http://www.w3schools.com/charsets/ref_html_ascii.asp">HTML ASCII</a>
<a href="http://www.w3schools.com/charsets/ref_html_ansi.asp">HTML ANSI</a>
<a href="http://www.w3schools.com/charsets/ref_html_ansi.asp">HTML Windows-1252</a>
<a href="http://www.w3schools.com/charsets/ref_html_8859.asp">HTML ISO-8859-1</a>
<a href="http://www.w3schools.com/charsets/ref_html_symbols.asp">HTML Symbols</a>
<a href="http://www.w3schools.com/charsets/ref_html_utf8.asp">HTML UTF-8</a>
</div>
</div>
</div>
<div id="w3dropdownexamples" class="w3DropdownMenu container-fluid w3DropdownMenuNotScroll">
<div class="w3DropdownInner">
<button type="button" class="close w3DropdownClose" onclick="hideDropdownMenu()" title="Close"><span>×</span></button>
<br>
<div class="w3DropdownItem">
<h3>HTML/CSS</h3>
<a href="http://www.w3schools.com/html/html_examples.asp">HTML Examples</a>
<a href="http://www.w3schools.com/css/css_examples.asp">CSS Examples</a>
</div>
<div class="w3DropdownItem">
<h3>JavaScript</h3>
<a href="http://www.w3schools.com/js/js_examples.asp" target="_top">JavaScript Examples</a>
<a href="http://www.w3schools.com/js/js_dom_examples.asp" target="_top">HTML DOM Examples</a>
<a href="http://www.w3schools.com/jquery/jquery_examples.asp" target="_top">jQuery Examples</a>
<a href="http://www.w3schools.com/jquerymobile/jquerymobile_examples.asp" target="_top">jQuery Mobile Examples</a>
<a href="http://www.w3schools.com/angular/angular_examples.asp" target="_top">AngularJS Examples</a>
<a href="http://www.w3schools.com/ajax/ajax_examples.asp" target="_top">AJAX Examples</a>
</div>
<div class="w3DropdownItem">
<h3>Server Side</h3>
<a href="http://www.w3schools.com/php/php_examples.asp" target="_top">PHP Examples</a>
<a href="http://www.w3schools.com/asp/asp_examples.asp" target="_top">ASP Examples</a>
<a href="http://www.w3schools.com/vbscript/vbscript_examples.asp" target="_top">VBScript Examples</a>
<a href="http://www.w3schools.com/aspnet/webpages_examples.asp" target="_top">Razor Examples</a>
<a href="http://www.w3schools.com/aspnet/aspnet_examples.asp" target="_top">.NET Examples</a>
</div>
<div class="w3DropdownItem">
<h3>XML</h3>
<a href="http://www.w3schools.com/xml/xml_examples.asp" target="_top">XML Examples</a>
<a href="http://www.w3schools.com/dtd/dtd_examples.asp" target="_top">DTD Examples</a>
<a href="http://www.w3schools.com/dom/dom_examples.asp" target="_top">XML DOM Examples</a>
<a href="http://www.w3schools.com/xsl/xsl_examples.asp" target="_top">XSL Examples</a>
<a href="http://www.w3schools.com/xsl/xsl_examples.asp" target="_top">XSLT Examples</a>
<a href="http://www.w3schools.com/xpath/xpath_examples.asp" target="_top">XPath Examples</a>
<a href="http://www.w3schools.com/xquery/xquery_example.asp" target="_top">XQuery Examples</a>
<a href="http://www.w3schools.com/schema/schema_example.asp" target="_top">Schema Examples</a>
<a href="http://www.w3schools.com/rss/rss_examples.asp" target="_top">RSS Examples</a>
<a href="http://www.w3schools.com/svg/svg_examples.asp" target="_top">SVG Examples</a>
</div>
</div>
</div>
<div id="w3dropdownsearch" class="w3DropdownMenu container-fluid w3DropdownMenuNotScroll">
<div class="w3DropdownInner" style="padding:20px;">
<button type="button" class="close w3DropdownClose" onclick="hideDropdownMenu()" title="Close"><span>×</span></button>
<br>
Search w3schools.com:
<div id="googleSearch"><div id="___gcse_0"><div class="gsc-control-cse gsc-control-cse-en"><div class="gsc-control-wrapper-cse" dir="ltr"><form class="gsc-search-box gsc-search-box-tools" accept-charset="utf-8"><table cellspacing="0" cellpadding="0" class="gsc-search-box"><tbody><tr><td class="gsc-input"><div class="gsc-input-box" id="gsc-iw-id1"><table cellspacing="0" cellpadding="0" id="gs_id50" class="gstl_50 " style="width: 100%; padding: 0px;"><tbody><tr><td id="gs_tti50" class="gsib_a"><input autocomplete="off" type="text" size="10" class="gsc-input" name="search" title="search" id="gsc-i-id1" dir="ltr" spellcheck="false" style="width: 100%; padding: 0px; border: none; margin: 0px; height: auto; outline: none; background: url(http://www.google.com/cse/intl/en/images/google_custom_search_watermark.gif) 0% 50% no-repeat rgb(255, 255, 255);"></td><td class="gsib_b"><div class="gsst_b" id="gs_st50" dir="ltr"><a class="gsst_a" href="javascript:void(0)" style="display: none;"><span class="gscb_a" id="gs_cb50">×</span></a></div></td></tr></tbody></table></div><input type="hidden" name="bgresponse" id="bgresponse"></td><td class="gsc-search-button"><input type="image" src="./sku_files/search_box_icon.png" class="gsc-search-button gsc-search-button-v2" title="search"></td><td class="gsc-clear-button"><div class="gsc-clear-button" title="clear results">&nbsp;</div></td></tr></tbody></table><table cellspacing="0" cellpadding="0" class="gsc-branding"><tbody><tr><td class="gsc-branding-user-defined"></td><td class="gsc-branding-text"><div class="gsc-branding-text">powered by</div></td><td class="gsc-branding-img"><img src="./sku_files/small-logo.png" class="gsc-branding-img"></td></tr></tbody></table></form><div class="gsc-results-wrapper-overlay"><div class="gsc-results-close-btn" tabindex="0"></div><div class="gsc-tabsAreaInvisible"><div class="gsc-tabHeader gsc-inline-block gsc-tabhActive">Custom Search</div><span class="gs-spacer"> </span></div><div class="gsc-tabsAreaInvisible"></div><div class="gsc-above-wrapper-area-invisible"><table cellspacing="0" cellpadding="0" class="gsc-above-wrapper-area-container"><tbody><tr><td class="gsc-result-info-container"><div class="gsc-result-info-invisible"></div></td></tr></tbody></table></div><div class="gsc-adBlockInvisible"></div><div class="gsc-wrapper"><div class="gsc-adBlockInvisible"></div><div class="gsc-resultsbox-invisible"><div class="gsc-resultsRoot gsc-tabData gsc-tabdActive"><table cellspacing="0" cellpadding="0" class="gsc-resultsHeader"><tbody><tr><td class="gsc-twiddleRegionCell"><div class="gsc-twiddle"><div class="gsc-title">Web</div></div><div class="gsc-stats"></div><div class="gsc-results-selector gsc-all-results-active"><div class="gsc-result-selector gsc-one-result" title="show one result">&nbsp;</div><div class="gsc-result-selector gsc-more-results" title="show more results">&nbsp;</div><div class="gsc-result-selector gsc-all-results" title="show all results">&nbsp;</div></div></td><td class="gsc-configLabelCell"></td></tr></tbody></table><div><div class="gsc-expansionArea"></div></div></div></div></div></div><div class="gsc-modal-background-image" tabindex="0"></div></div></div></div></div>
</div>
</div>
<div id="w3dropdowntranslate" class="w3DropdownMenu container-fluid w3DropdownMenuNotScroll">
<div class="w3DropdownInner" style="padding:20px;">
<button type="button" class="close w3DropdownClose" onclick="hideDropdownMenu()" title="Close"><span>×</span></button>
<br>
<div id="translateSection"><div id="google_translate_element"><div class="skiptranslate goog-te-gadget" dir="ltr"><div id=":0.targetLanguage" class="goog-te-gadget-simple" style="white-space: nowrap;"><img src="./sku_files/cleardot.gif" class="goog-te-gadget-icon" style="background-image: url(https://translate.googleapis.com/translate_static/img/te_ctrl3.gif); background-position: -65px 0px;"><span style="vertical-align: middle;"><a class="goog-te-menu-value" href="javascript:void(0)"><span>言語を選択</span><img src="./sku_files/cleardot.gif" width="1" height="1"><span style="border-left-width: 1px; border-left-style: solid; border-left-color: rgb(187, 187, 187);">​</span><img src="./sku_files/cleardot.gif" width="1" height="1"><span style="color: rgb(155, 155, 155);">▼</span></a></span></div></div></div></div>
</div>
</div>

<script>
var menu = $('#topnavDIV'), pos = menu.offset();
$(window).scroll(function(){
    if($(this).scrollTop() > pos.top && menu.hasClass('topnavContainer')){
        menu.removeClass('topnavContainer').addClass('topnavContainer2');
        $("#topDIV").removeClass('top').addClass('top2');
        $(".w3DropdownMenu").removeClass('w3DropdownMenuNotScroll').addClass('w3DropdownMenuScroll');
     } else if($(this).scrollTop() <= pos.top && menu.hasClass('topnavContainer2')){
        menu.removeClass('topnavContainer2').addClass('topnavContainer');
        $("#topDIV").removeClass('top2').addClass('top');
        $(".w3DropdownMenu").removeClass('w3DropdownMenuScroll').addClass('w3DropdownMenuNotScroll');
     } });
$(document).ready(function(){
  $("#dropdownTutorialsBtn").click(function(){
    closeTheOthers("tutorials");
    if ($("#w3dropdowntutorials").css("display") == "none") {
      $("#dropdownTutorialsBtn").css("background-color","#f5f5f5");
      $("#dropdownTutorialsBtn").css("color","#555555");
    } else {
      $("#dropdownTutorialsBtn").css("background-color","");
      $("#dropdownTutorialsBtn").css("color","");
    }
    $("#w3dropdowntutorials").fadeToggle(200, function () {
    });
    return false;      
  });
  $("#dropdownReferencesBtn").click(function(){
    closeTheOthers("references");
    if ($("#w3dropdownreferences").css("display") == "none") {
      $("#dropdownReferencesBtn").css("background-color","#f5f5f5");
      $("#dropdownReferencesBtn").css("color","#555555");
    } else {
      $("#dropdownReferencesBtn").css("background-color","");
      $("#dropdownReferencesBtn").css("color","");
    }
    $("#w3dropdownreferences").fadeToggle(200);
    return false;      
  });
  $("#dropdownExamplesBtn").click(function(){
    closeTheOthers("examples");
    if ($("#w3dropdownexamples").css("display") == "none") {
      $("#dropdownExamplesBtn").css("background-color","#f5f5f5");
      $("#dropdownExamplesBtn").css("color","#555555");
    } else {
      $("#dropdownExamplesBtn").css("background-color","");
      $("#dropdownExamplesBtn").css("color","");
    }
    $("#w3dropdownexamples").fadeToggle(200);
    return false;      
  });
  $("#dropdownSearchBtn").click(function(){
    closeTheOthers("search");
    if ($("#w3dropdownsearch").css("display") == "none") {
      $("#dropdownSearchBtn").css("background-color","#f5f5f5");
      $("#dropdownSearchBtn").css("color","#555555");
    } else {
      $("#dropdownSearchBtn").css("background-color","");
      $("#dropdownSearchBtn").css("color","");
    }
    $("#w3dropdownsearch").fadeToggle(200, function(){$("#gsc-i-id1").focus();});
    return false;      
  });
  $("#dropdownTranslateBtn").click(function(){
    closeTheOthers("translate");
    if ($("#w3dropdowntranslate").css("display") == "none") {
      $("#dropdownTranslateBtn").css("background-color","#f5f5f5");
      $("#dropdownTranslateBtn").css("color","#555555");
    } else {
      $("#dropdownTranslateBtn").css("background-color","");
      $("#dropdownTranslateBtn").css("color","");
    }
    $("#w3dropdowntranslate").fadeToggle(200);
    return false;      
  });
  $(".main").click(function(){
    closeTheOthers();
  });
  $(".top").click(function(){
    closeTheOthers();
  });
});
function closeTheOthers(x) {
    if (x != "tutorials") { 
        $("#dropdownTutorialsBtn").css("background-color","");
        $("#dropdownTutorialsBtn").css("color","");
        $("#w3dropdowntutorials").fadeOut(100);
    }
    if (x != "references") { 
        $("#dropdownReferencesBtn").css("background-color","");
        $("#dropdownReferencesBtn").css("color","");
        $("#w3dropdownreferences").fadeOut(100);
    }
    if (x != "examples") { 
        $("#dropdownExamplesBtn").css("background-color","");
        $("#dropdownExamplesBtn").css("color","");
        $("#w3dropdownexamples").fadeOut(100);
    }
    if (x != "search") { 
        $("#dropdownSearchBtn").css("background-color","");
        $("#dropdownSearchBtn").css("color","");
        $("#w3dropdownsearch").fadeOut(100);
    }
    if (x != "translate") { 
        $("#dropdownTranslateBtn").css("background-color","");
        $("#dropdownTranslateBtn").css("color","");
        $("#w3dropdowntranslate").fadeOut(100);
    }
}
var menyknapp_hartrykket = 0;
function vismenyen() {
closeTheOthers();
x = document.getElementById("menyen");
if (menyknapp_hartrykket == 0) {
	x.style.position = "fixed";
	x.style.zIndex = "1000";	
	x.style.top = "90px";	
	x.style.bottom = "0";	
	x.style.overflow = "auto";	
	x.style.display = "block";
	x.style.right = "0";
	x.style.backgroundColor = "#ffffff";
	x.style.padding = "20px";
	x.style.borderLeft = "2px solid #f1f1f1";
	x.style.borderBottom = "2px solid #f1f1f1";
    menyknapp_hartrykket = 1;
} else {
    x.style.display = "none";
    menyknapp_hartrykket = 0;
}
}
function hideDropdownMenu() {
    closeTheOthers();
}
</script>
<script src="./sku_files/w3schools.js"></script>
<script src="./sku_files/element.js"></script><iframe src="./sku_files/container.html" style="visibility: hidden; display: none;"></iframe>
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>  
<![endif]-->

<div id="goog-gt-tt" class="skiptranslate" dir="ltr"><div style="padding: 8px;"><div><div class="logo"><img src="./sku_files/translate-32.png" width="20" height="20"></div></div></div><div class="top" style="padding: 8px; float: left; width: 100%;"><h1 class="title gray">原文</h1></div><div class="middle" style="padding: 8px;"><div class="original-text"></div></div><div class="bottom" style="padding: 8px;"><div class="activity-links"><span class="activity-link">翻訳を改善する</span><span class="activity-link"></span></div><div class="started-activity-container"><hr style="color: #CCC; background-color: #CCC; height: 1px; border: none;"><div class="activity-root"></div></div></div><div class="status-message" style="display: none;"></div></div><style type="text/css">.lingualy-translate-close {background: url("chrome-extension://iilcekgoelpgecpjnnoikhbleipnjdhf/lookup/assets/translate/x_normal.png") no-repeat;}.lingualy-translate-close:hover {background: url("chrome-extension://iilcekgoelpgecpjnnoikhbleipnjdhf/lookup/assets/translate/x_over.png");}.lingualy_popup .lingualy_close {background: url("chrome-extension://iilcekgoelpgecpjnnoikhbleipnjdhf/lookup/assets/andy-sprite.png") no-repeat 0 -50px;}</style><iframe frameborder="0" class="goog-te-menu-frame skiptranslate" style="visibility: visible; box-sizing: content-box; width: 823px; height: 263px; display: none;"></iframe><div id="feedly-mini" title="feedly Mini tookit"></div><table cellspacing="0" cellpadding="0" class="gstl_50 gssb_c" style="width: 2px; display: none; top: 3px; left: -1px; position: absolute;"><tbody><tr><td class="gssb_f"></td><td class="gssb_e" style="width: 100%;"></td></tr></tbody></table><div id="shadowMeasureIt"></div><div id="divCoordMeasureIt"></div><div id="divRectangleMeasureIt"><div id="divRectangleBGMeasureIt"></div></div><iframe id="google_osd_static_frame_6061517558991" name="google_osd_static_frame" style="display: none; width: 0px; height: 0px;"></iframe></body></html>