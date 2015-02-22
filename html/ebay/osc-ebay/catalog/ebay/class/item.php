<?PHP
/*
Title: OSC-Ebay
Description: Automatically sync your oscmax store with your ebay store
Project URL: http://code.google.com/p/ebay-osc/
Author: Jason Clark 
Release: Oct 22, 2011
Version: 1.0
*/
error_reporting(E_ALL);          // useful to see all notices in development 
require_once('keys.php');
require_once('item_details.php');
require_once('configure.php');

class items
{

var $itemID;
var $resp;
var $itemarray;
var $sqlcount;
var $debug;
var $shippingarray;
var $startdate;
var $apicall;
var $test;
var $testapicall="tests/storeprodlist.xml";
var $text2parse;
var $settings;
var $db;
var $mvs;

function __construct()
{
	global $shoppingURL, $appID, $compatabilityLevel, $sellerID,$test,$debug; 
    $this->debug=$debug;
    $this->test=$test;
	$startdate= date("Y").'-'.date("m").'-'. date("d") .'T00:00:00.768Z' ;
    $this->connect();
    $this->text2parse=$this->get_text2parse();
    $this->settings=$this->get_settings();
    $this->startdate=$this->settings['last_kron'];
    $this->loadxml($this->startdate);
    $this->get_shipping_array();
    $this->get_item_details();
    $this->insert_into_db();
    $this->disconnect();
}

private function get_text2parse()
{
$i=0;
$sql = 'SELECT `text2parse` FROM `ebay_description`';
$query=mysql_query($sql) or die ('cannot get descriptions error: ' .mysql_error());
while ($container=mysql_fetch_assoc($query))
{
$descriptionsarray[$i]=$container['text2parse'];
$i++;
}
if ( count($descriptionsarray)>1 )
{

}else{
$descriptionsarray=$descriptionsarray[0];
}
return $descriptionsarray;
}

private function get_settings()
{
$sql = 'SELECT * FROM `ebay_settings`';
$query=mysql_query($sql) or die ('cannot get descriptions error: ' .mysql_error());
$settings=mysql_fetch_assoc($query);
return $settings;
}

private function loadxml($startdate){
if ($this->test===true)
{
    if($this->debug===true)
   echo 'loading test xml<br>';
$this->resp=simplexml_load_file($this->testapicall);
}else{
$this->apicall = "$shoppingURL?callname=FindItemsAdvanced&version=$compatabilityLevel&siteid=0". "&appid=$appID&ItemType=StoreInventoryOnly&ModTimeFrom=$startdate&MaxEntries=200&SellerID=$sellerID";
if($this->debug === true)
{
echo 'loading xml<br>';
var_dump(trim($this->apicall));
}

// Load the call and capture the document returned by eBay API

$this->resp=simplexml_load_file($this->apicall);
}
}

private function get_shipping_array()
{

$i=0;
$dbshiparay = 'SELECT * FROM `ebay_shipping` ORDER BY ID';
$dbshiparay = mysql_query ($dbshiparay) 
or die ('cannot get shipping methods error: ' .mysql_error());
while ($container=mysql_fetch_assoc($dbshiparay))
{
$dbshiparray[$i]=$container;
$i++;
}
if ($this->debug === true)
{
    echo 'getting shipping array<br>';
var_dump($dbshiparray);
}
$this->shippingarray=$dbshiparray;
//return $dbshiparray;
}

private function remove_text($text,$description)
{
$new_str = str_replace($text, ' ', $description);

if ($this->debug === true)
{ 
    echo 'removing text<br>';
echo 'pattern '.$text;
echo '<br><br>';
echo 'str_replace('.$text. ', \' \', ' .$description.')'.'<br><br>';
echo $new_str;
}

return $new_str;
}

private function insert_into_db()
{
$j=count ($this->itemarray);
$this->get_products_total();
if ($this->debug === true){
    echo 'inserting into the db<br>';
echo '$this->sqlcount call returns <br>';
var_dump($this->sqlcount);
echo '<br><br>';}

$s=0; //sync counter
$u=0; // products inserted counter 
for ($i=0; $i<$j;$i++)
{
$duplicate=false;
//echo "duplicate is ";
$duplicate=$this->in_database($this->itemarray['title'][$i]); //duplicate is the row returned or false if none
//var_dump($duplicate);
if($duplicate === false ) 
{
    if($this->mvs==true)
    $query=$this->products_query_mvs($i);
    else
    $query=$this->products_query($i);

if ($this->debug === true)
    echo $query . '<br>';

 $success=mysql_query ($query);
 if ($success == null or $success ==0 )
 {
    if ($this->debug === true)
    echo 'the sql query was not inserted query was <br><br>' . $query;
 }else{
 $query=$this->products_2_cat_query($i);
    if ($this->debug === true)
    echo  $query .'<br>';
 
 mysql_query ($query) or die ('cannot update database error: ' .mysql_error());

 $query=$this->products_desc_query($i);
    if ($this->debug === true)
    echo  $query .'<br>';
  
 mysql_query ( $query ) or die (' Cannot update database error: ' .mysql_error());
 }
 $u++;
}else{
    
    if($this->debug === true)
    echo $this->itemarray['title'][$i].". is a duplicate item<br>";

        $query=$this->get_products_query($i);
        $details=mysql_query ($query) or die ('cannot retrieve result from database error: ' .mysql_error());
        $details=mysql_fetch_array($details);
        
    switch($this->settings['sync_mode'])
    {
        case 'EBAY_AUTHORITY':  //this will always use ebays stored values when updating record
        //compare the weight
        if($details['products_weight']==$this->itemarray['weight'][$i]){
            if($this->debug === true)
            echo "weights are the same<br>";
        }else{
            if($this->debug === true)
            {
            echo "weights are different<br>updating stores product weight to ";
            echo $this->itemarray['weight'][$i] ."<br>";
            }
            $this->update_weight($duplicate['products_id'],$this->itemarray['weight'][$i]);
            $syncd=true;
        }
        //compare the stock
        if($details['products_quantity']==$this->itemarray['quantity'][$i]){
            if($this->debug === true)
            echo "quantity is the same<br>";
        }else{
            if($this->debug === true)
            {
            echo "quantity is different <br>updating stores product quantity to ";
            echo $this->itemarray['quantity'][$i]. "<br><br>";
            }
           $this->update_stock($duplicate['products_id'],$this->itemarray['quantity'][$i],$duplicate['products_quantity']);
           $syncd=true;
        }
        break;
        case 'SMART_SYNC':  //this will compare ebays stored values with osc values compare and update record
        //compare the stock
        if($details['products_quantity']==$this->itemarray['quantity'][$i]){
            if($this->debug === true)
            echo "quantity is the same<br>";
        }else{
            if($this->debug === true)
            {
            echo "quantity is different <br> ";
            echo 'old item stock was ' . $details['last_ebay_quantity']. "<br>"; 
            echo 'current item stock is ' . $details['products_quantity']. "<br>"; 
            echo 'ebay item stock is ' .$this->itemarray['quantity'][$i]. "<br>";
            echo '------ Computing '.$this->itemarray['title'][$i].' Stock ------<br><br>';
            }
            $currentstockdiff=(int)$details['last_ebay_quantity'] - (int)$details['products_quantity'];
            $computedstockdiff=(int)$this->itemarray['quantity'][$i] - $currentstockdiff;
            $this->update_stock($duplicate['products_id'],$computedstockdiff);
            $syncd=true;
            
        }
        break;
    }
    if($syncd==true)
     $s++; // since we synced we update counter
}
  $this->sqlcount++;
}	
$lastsync=$this->settings['last_sync'];
$lastupdate=$this->settings['last_update'];

if(isset($s) && $s>0)
 $lastsync=date('Y-m-d');
 
 if(isset($u) && $u>0)
 $lastsync=date('Y-m-d');

$this->update_settings($sync=$s,$inserted=$u,date('Y-m-d'),$update=$lastupdate,$lsync=$lastsync);
}

 private function now()
 {
$date= date('Y').'-'.date('m').'-'.date('d'). ' '.date('G').'-'.date('i').'-'.date('s');
return $date;
 }
 

 public function copy_images_2_server($imagename,$localfile)
{
if($this->debug === true){
    echo 'copying images to server<br>';
}
$file =$imagename;
// The  file that you wish to be copied
// make sure curl is installed
if (function_exists('curl_init')) {
   // initialize a new curl resource
   $ch = curl_init();
   // set the url to fetch
   curl_setopt($ch, CURLOPT_URL, '$imagename');
   // don't give me the headers just the content
   curl_setopt($ch, CURLOPT_HEADER, 0);
   // return the value instead of printing the response to browser
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   // use a user agent to mimic a browser
   curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
   $data = curl_exec($ch);
   // remember to always close the session and free all resources
   curl_close($ch);
} else {
// curl library is not installed so we better use something else
$data = @file_get_contents($file); 
}

@$fm = fopen($localfile, 'w') ;// or die("can't open file");
@fwrite($fm, $data);
if(isset($fm))
fclose($fm);
 }
 
private function strip_html_tags( $text )
{
    if($this->debug === true){
    echo 'stripping html tags<br>';
}
$subject=array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
            '@\'@',		
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        );
        
	$replace=array(
            ' ',' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        );
        
    $text = preg_replace($subject,$replace,$text );
    return strip_tags( $text );
}

private function in_database($name){
    $sql = "SELECT * FROM `products_description` WHERE `products_name` = '$name' LIMIT 0, 30 ";
    $res= mysql_query ($sql) ;//or die ('in database error: ' .mysql_error());
    $in_db=mysql_fetch_assoc($res);
    return $in_db;
}

private function update_prod(){
    
}
private function update_settings($sync=0,$inserted=0,$kron=0,$lsync=null,$update=null){
    $sql = "UPDATE ebay_settings SET products_inserted = $inserted, products_syncd = $sync, last_kron='$kron', last_sync='$lsync',  last_update='$update'  WHERE ID = 1;";
    if($this->debug===true)
    {
    echo "<br>settings are updated<br>";
    echo $sql .'<br>';
    }
    $res= mysql_query ($sql) ;//or die ('cannot update database error: ' .mysql_error());
    return $res;
}
private function update_desc(){
    
}
private function update_price($id,$i){
    $sql = "UPDATE products SET products_price = $i WHERE products_id = $id;";
    $res= mysql_query ($sql) ;//or die ('cannot update database error: ' .mysql_error());
    return $res;
}
private function update_stock($id,$i,$last_quantity){
    
    //get old stock
    //addd to sql under last_ebay_quantity
    $sql = "UPDATE products SET products_quantity = $i WHERE products_id = $id;";
 //   echo $sql;
    $res= mysql_query ($sql) ;//or die ('cannot update database error: ' .mysql_error());
     $sql = "UPDATE products SET last_ebay_quantity = $last_quantity WHERE products_id = $id;";
    return $res;
}
private function update_weight($id,$i){
    $sql = "UPDATE products` SET products_weight = $i WHERE products_id = $id;";
   // $res= mysql_query ($sql) or die ('cannot update database error: ' .mysql_error());
    return $sql;
}


private function products_query_mvs($i=0){
    $query = "INSERT INTO products (products_id, Ebay_Id,products_price, products_quantity, products_weight,products_length,products_width,products_height,products_image,vendors_id,products_status,
products_date_added)
Values ('NULL', 
'".$this->itemarray['ebayid'][$i]."', 
'".$this->itemarray['price'][$i]."', 
'".$this->itemarray['quantity'][$i]."', 
'".$this->itemarray['weight'][$i]."', 
'".$this->itemarray['length'][$i]."', 
'".$this->itemarray['width'][$i]."', 
'".$this->itemarray['height'][$i]."', 
'".$this->itemarray['thumbpicurl'][$i]."',
'".$this->itemarray['vendor'][$i]."',
'1',
'".$this->now()."'".")";
return $query;
}

private function products_query($i=0){
    $query = "INSERT INTO products (products_id, Ebay_Id,products_price, products_quantity, products_weight,products_length,products_width,products_height,products_image,products_status,
products_date_added)
Values ('NULL', 
'".$this->itemarray['ebayid'][$i]."', 
'".$this->itemarray['price'][$i]."', 
'".$this->itemarray['quantity'][$i]."', 
'".$this->itemarray['weight'][$i]."', 
'".$this->itemarray['length'][$i]."', 
'".$this->itemarray['width'][$i]."', 
'".$this->itemarray['height'][$i]."', 
'".$this->itemarray['thumbpicurl'][$i]."',
'1',
'".$this->now()."'".")";
return $query;
}

private function get_products_desc_query($i=0)
{
    $sql = "SELECT * FROM `products_description` WHERE `products_id` = $i LIMIT 0, 30 ";
    return $sql;
}

private function get_products_total(){
    $this->sqlcount = 'SELECT products_id FROM products_to_categories ORDER BY products_id DESC LIMIT 0,1';
    $this->sqlcount=mysql_query ($this->sqlcount) or die ('cannot count database error: ' .mysql_error());
    $this->sqlcount=mysql_fetch_assoc($this->sqlcount);
    $this->sqlcount=$this->sqlcount['products_id']+1;
}
private function get_products_query($i=0)
{
    $sql = "SELECT * FROM `products` WHERE `products_id` = $i LIMIT 0, 30 ";
    return $sql;
}

private function products_desc_query($i=0){
    //$this->itemarray['description'][$i]=str_replace($this->text2parse,'',$this->itemarray['description'][$i]);
 $query = "INSERT INTO products_description (products_id, language_id, products_name, products_description, products_url, products_viewed)Values ('NULL', '1', '".$this->itemarray['title'][$i]."', '".$this->itemarray['description'][$i]."', 'NULL', '0')";
 return $query;
}

private function products_2_cat_query($i=0){
    $query = "INSERT INTO products_to_categories (products_id, categories_id) VALUES ($this->sqlcount, '1')"; 
    return $query;
}
private function get_item_details(){
    $i=0;
    if($this->debug === true){
    echo 'getting item details<br>';
    }
    $this->itemdetails=new item_details();
     $this->itemarray = array("ebayid"=>array(),"title"=>array(),"price"=>array(),"picurl"=>array(),"shiptype"=>array(),"weight"=>array(),"description"=>array(),"quantity"=>array(),"weightmajor"=>array(),"weightminor"=>array(),"length"=>array(),"width"=>array(),"height"=>array(),'thumbpicurl'=>array(),'localpicurl'=>array(),'vendor'=>array());
    // return $itemdetails;
     foreach($this->resp->SearchResult->ItemArray->Item as $item) 
	{
        $link  = (string)$item->ViewItemURLForNaturalSearch; 
        $title = (string)$item->Title;
		$picurl = (string)$item->GalleryURL;
		$price = (string)$item->ConvertedCurrentPrice;
		$itemid = (string)$item->ItemID;
		$shippingtype = (string)$item->ShippingCostSummary->ShippingType;        
$this->itemarray['ebayid'][$i]=$itemid;
$this->itemarray['title'][$i]=$title;
$this->itemarray['picurl'][$i]=$picurl;
$this->itemarray['price'][$i]=$price;
$this->itemarray['shiptype'][$i]=$shippingtype;
$this->itemarray['localpicurl'][$i]=''.strtolower(preg_replace('/(\/|"| )/','',$this->itemarray['title'][$i])).'.jpg';
$this->itemarray['thumbpicurl'][$i]='thumbs/'.$this->itemarray['localpicurl'][$i];

if($this->mvs == true){
$this->get_vendor-shipping();
}else{
$this->itemarray['vendor'][$i]=1;
}


$itemdetails=$this->itemdetails->get_item_details($itemid);


	if($this->debug === true)
	{
	echo '<br>Itemdetails object is<br>';
	//var_dump($itemdetails);
	echo '<br><br>';
	}

	

$this->itemarray['quantity'][$i]=trim((string)$itemdetails->resp->Item->Quantity);

$this->itemarray['weightmajor'][$i]=trim((string)$itemdetails->resp->Item->ShippingDetails->CalculatedShippingRate->WeightMajor);
$this->itemarray['weightminor'][$i]=trim((string)$itemdetails->resp->Item->ShippingDetails->CalculatedShippingRate->WeightMinor);
$this->itemarray['description'][$i]=trim($this->strip_html_tags((string)$itemdetails->resp->Item->Description));
$this->itemarray['length'][$i]=trim((string)$itemdetails->resp->Item->ShippingDetails->CalculatedShippingRate->PackageLength);
$this->itemarray['width'][$i]=trim((string)$itemdetails->resp->Item->ShippingDetails->CalculatedShippingRate->PackageWidth);
$this->itemarray['height'][$i]=trim((string)$itemdetails->resp->Item->ShippingDetails->CalculatedShippingRate->PackageDepth);
if((int)$this->itemarray['weightmajor'][$i]==null)
{
$this->itemarray['weight'][$i]=0;
}else{
$this->itemarray['weight'][$i]=(int)$this->itemarray['weightmajor'][$i] .'.'. (int)$this->itemarray['weightminor'][$i];
}
$this->itemarray['description'][$i]=$this->remove_text($this->text2parse,$this->itemarray['description'][$i]);
$this->get_ebay_description($i);

@$this->copy_images_2_server($this->itemarray['picurl'][$i],DIR_FS_CATALOG_IMAGES_THUMBS.$this->itemarray['localpicurl'][$i]); 

if($this->debug === true)
{
var_dump($this->itemarray);
}
//$this->get_shiptype();
$i++;
   }
}

private function get_shiptype(){
for ($l=0; $l < count($this->shippingarray)-1; $l++)
{
if ($this->shippingarray[$l]['shiptype'] == $this->itemarray['shiptype'][$i])
{
$this->itemarray['shiptype'][$i]=$this->shippingarray[$l]['vendor'];
}
}
}

private function get_vendor_shipping(){
//Determine wich vendor to put the product in based on shipping type


for ($i=0; $i<count($this->shippingarray);$i++)
 {
 if (strtolower(trim($this->itemarray['shiptype'][$i]))==strtolower($this->shippingarray[$i]['shiptype']))
  {
  $this->itemarray['vendor'][$i]=$this->shippingarray[$i]['vendor'];
  }
  }   
}

private function get_ebay_description($i=0){
$description = '<br>original item description<br>';
$description .=$this->itemarray['description'][$i];
$description .= $this->text2parse;
$description .= '<br><br>altered description<br><bR>';
$description .= $this->itemarray['description'][$i];
$description .='<br><br>';
$description .= 'str_replace('.$this->text2parse.',\'\','.$this->itemarray['description'][$i].')';    
return $description;
}

private function connect(){
    if($this->debug === true){
    echo 'connecting to database<br>';
}
    mysql_connect (DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD) or die ('cannot connect:  ' .mysql_error());
    mysql_select_db (DB_DATABASE);
}

private function disconnect(){
    if($this->debug === true){
    echo 'disconnecting from database<br>';
}
if (isset($this->db))
{
mysql_close($connection);
}
}

}
