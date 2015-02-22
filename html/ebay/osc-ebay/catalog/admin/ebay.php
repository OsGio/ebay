<?php
/*
  $Id: vendors.php,v 1.20 2006/03/25 by Craig Garrison Sr www.blucollarsales.com for MVS V1.0 2006/03/25 JCK/CWG
  $Loc: /catalog/admin/ $
  $Mod: MVS V1.2 2009/02/28 JCK/CWG $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2006 osCommerce
*/

  require ('includes/application_top.php');

  $action = (isset ($HTTP_POST_VARS['action']) ? $HTTP_POST_VARS['action'] : '');
  $error = false;
  $processed = false;


  if (tep_not_null($action)) {
    switch ($action) {
	  case 'update' :
	  $update_successful=update_vendors($_POST[shipmethods],$_POST[vendors]);
	  break;
	  case 'description' :
	  add_rule($_POST['add_rule']);
	  break;
	  case 'sync_method':
	  update_sync($_POST['sync_method']);
	  break;
	  }
	  }
	  //var_dump($sql);
	  //////////Start of functions
function get_vendors_array()
{		
$sql = 'SELECT vendors_id, vendors_name FROM vendors ORDER BY vendors_id';
$sqlquery=mysql_query($sql);
$i=0;
while ($container= mysql_fetch_assoc($sqlquery))
{
$dbshiparray[$i]=$container;
$i++;
}
return $dbshiparray;
}

function get_ship_methods(){
$sql = 'SELECT * FROM ebay ORDER BY ID';
$sqlquery=mysql_query($sql);

$i=0;
while ($container= mysql_fetch_assoc($sqlquery))
{
$dbshiparray[$i]=$container;
$i++;
}
return $dbshiparray;
}

function build_dropdown($name,$value)
{
global $shipmethods;

$result ='<select name='.$name.' size="1">';
$result .='<option value=""';
for ($i=0;$i<count($value);$i++)
{
$result .='<option value="' . $value[$i]["vendors_id"]; 
$venname=$value[$i][vendors_name];
for ($a=0;$a<count($shipmethods);$a++)
{
$vendorkey=in_array($venname,$shipmethods[$a]);
if($vendorkey !=null || $vendorkey !=0)
{
(int)$key=$a;
}
}
$result .='">';
$result .= $value[$i]["vendors_name"] . '</option>' ."\n";
}
return $result;
}

function assoc_ship_2_vendor($shipmethods,$vendors)
{
foreach ($shipmethods as $value)
{
$vendorskey=array_search($value['vendor'],$vendors);
$vendorsarray['shiptype']=$vendorskey;
}

return $vendorsarray;
}

$shipmethods=get_ship_methods();
$vendors=get_vendors_array();

function update_vendors($shipmethods,$vendors)
{
$j=count($_POST[shipmethods]);
for ($i=0;$i<$j;$i++)
{
if ($_POST[vendors][$i] == null)
{
}else{
$vendornamesql= 'SELECT `vendors_name` FROM `vendors` WHERE `vendors_id` =' .$_POST[vendors][$i];
$vendornameres=mysql_query($vendornamesql);
$vendorname=mysql_fetch_assoc($vendornameres);
$sql = "UPDATE `ebay` SET `vendor` = ". $_POST[vendors][$i]." , `vendorname` = "."'".$vendorname['vendors_name']."'"." WHERE `ebay`.`ID` = $i";
$success=mysql_query($sql);
}
}
}

function update_sync($type){
    $sql = "UPDATE `ebay_settings` SET `sync_mode` = '".$type."' WHERE `ID` = 1;";
$success=mysql_query($sql);
}

function get_settings()
{
$sql = 'SELECT * FROM `ebay_settings`';
$query=mysql_query($sql) or die ('cannot get descriptions error: ' .mysql_error());
$settings=mysql_fetch_assoc($query);
return $settings;
}

function get_params()
{
$i=0;
$sql = 'SELECT `ID`, `text2parse` FROM `ebay_description`';
$query=mysql_query($sql) or die ('cannot get descriptions error: ' .mysql_error());
while ($container=mysql_fetch_assoc($query))
{
//var_dump ($container);
$descriptionsarray[$i]=$container;
$i++;
//var_dump($descriptionsarray);
}
if ( count($descriptionsarray)>1 )
{
$finaldesc ='|';
foreach ($descriptionsarray as $value)
{
$finaldesc .=$value['text2parse'];
$finaldesc .=' | ';
}
return $finaldesc;
}else{
$descriptionsarray=$descriptionsarray[0]['text2parse'];
//var_dump($descriptionsarray);
if($descriptionsarray==null)
{
$descriptionsarray='you are not filtering any text';
}
return $descriptionsarray;
}
}

function add_rule($description=null)
{
trim($description);
$success=false;
if($description !=''){
$sql = 'INSERT INTO `ebay_description` (`ID`, `text2parse`) VALUES (NULL,'."'". $description."'".');';
//echo $sql;
$success=mysql_query($sql);
}
return $success;
}
//////End of functions
$settings=get_settings();
?>
	  <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft"
	  !doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
	
	
	<?php

  if ($action == 'edit' || $action == 'update' || $action == 'new' || $action == 'insert' || $action == 'setflag') //{ //eof is here
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">
<?php

    if ($action == 'insert') {
      echo HEADING_TITLE_ADD;
    } else {
      echo HEADING_TITLE;
    }
?>
           </td>
	   <td align='right' text-align='right'>
	   Last Run: <?php echo $settings['last_kron'];?>
	   </td>
	   <tr>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
	  <tr>
	  <td>
	  <?php echo $settings['products_inserted']; ?> New Products added on <?php echo $settings['last_update']; ?>
	  </td>
	  </tr>
	  <tr>
	      <td>
	  <?php echo $settings['products_syncd']; ?> Existing Products Synced on <?php echo $settings['last_sync']; ?>
	  </td>
	  </tr>
      
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
       <tr>

	<td class="formAreaTitle"><?php echo TEXT_BOX_ADMIN; ?></td>
	<td class="formAreaTitle"></td>
	<td class="formAreaTitle"></td>
</tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
		
        <tr>
	    <?php 
	    if(isset($vendors)){
		?>
<form method="post" action="<? echo $_SERVER['PHP_SELF']	?>"> 
<?php
for ($i=0; $i<count($shipmethods); $i++)
{
?>
<td class="main">
<input type="hidden" size="1" maxlength="255" name="shipmethods[<? echo $i; ?>]" value=" <? echo $shipmethods[$i][description]; ?>">
<input type="hidden" name="action" value='update'>
            <td class="main"><?php echo $shipmethods[$i][description]; 
	//    var_dump($shipmethods);
	    ?>
			</td>
			<td class="main"></td><td class="main"></td><td class="main">
			</td>
            <td class="main">
			<?php 
			
			$varray=build_dropdown(vendors.'['.$i.']',$vendors,$shipmethods); 
			echo $varray;
			
			?>
			</td>
			
			</td> 
			<td class="main"></td><td class="main"></td><td class="main">
			</td>
			<td class="main" align='left' border='0'>   Current Vendor | <?php echo '<font color="red">';
			if($shipmethods[$i][vendorname] !='')
			echo $shipmethods[$i][vendorname];
			else
			echo 'none';
			echo '</font>'; 
			?> |
			</td>
            <td class="main">
			
			
			</td>
          </tr>
		  
		  
		  <? } ?>
		  
		  
        </table>
		</td>
		
      </tr>
	  
      <tr>
	  
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
	  
      <tr>
        <td align="right" class="main">
		<input type="submit" value="Update Vendors"></td>
	  </form>
<?php }

    if ($action == 'new') {}else{};
	?>
	</tr>
	<table>
	<tr>
	<td>
	    <form name="sync_method" method="post" action="<? echo $_SERVER['PHP_SELF']	?>">
	    Sync Method:
		    <?php 
/*
		    $availmethods=array('EBAY_AUTHORITY','SMART_SYNC','OSC_AUTHORITY');
		    $syncarray=build_dropdown('SYNC_METHOD',$availmethods,$availmethods); 
		    echo $syncarray;
*/
$syncoptions;
$availmethods=array('EBAY_AUTHORITY','SMART_SYNC','OSC_AUTHORITY');
foreach( $availmethods as $k=>$v)
{
    if($v==$settings['sync_mode'])
    {
	$syncoptions .='<option selected value="'.$v.'">'.$v.'</option>';
    }else{
	$syncoptions .='<option value ="'.$v.'">'.$v.'</option>';
    }
}

		    ?>
		    <select size="1" name="sync_method">
		  <?php echo $syncoptions; ?>
		    </select>
	    <input type="hidden" name="action" value='sync_method'>
	    <input type="submit" value="Update">
	    </td>
	    </form>

	</td>
	</tr>
	</table>
	<table cellpadding="2" cellspacing="2">
	<tr>
	<td class="main">
	Add new rules to filter
	</td>
	
	</tr>
	<tr>
	<td>
	<? //var_dump($_POST);?>
	<form name="add_rule" method="post" action="<? echo $_SERVER['PHP_SELF']	?>">
	<input type="hidden" name="action" value='description'>
	<input type="text" name="add_rule">   <input type="submit"  value="Add rule">   </td>
	</form>
	</tr>
	<tr>
	<td class="main">
	what is currently being filtered from your ebay ads
	</td>
	</tr>
	<tr>
	<td class="main" align='left'>
	<? $parsed_out=get_params(); ?>
	<textarea name="textarea" cols="38" rows="9" wrap="VIRTUAL" align='right'><? echo $parsed_out ?></textarea>
	</td>
	</tr>
	</table>
    </table></td>
      </tr>
	  
<?php

  
?>

    </table></td>

  </tr>
</table>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
	
