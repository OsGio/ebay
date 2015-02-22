<?php 
	 session_start();
	require_once("common/db.php");
	$username = $_SESSION["CONVERTER_USERID"];
$db = new dbclass();

?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="Content-Language" CONTENT="ja">
<title>eBay全商品カテゴリＩＤ検索 </title>

<script type="text/javascript" src="js/prototype.js"></script>

<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/template.css">

<script type="text/javascript">
var gl_catid="";
var gl_catnm="";
function sendid(idval)
{
            
        
        if(window.opener.document.rp03_002Form){
            window.opener.document.rp03_002Form.genreId.value = idval;
        }//end if
        if(window.opener.document.rp03_005Form){
            window.opener.document.rp03_005Form.genreId.value = idval;
        }//end if
        
        
        if(window.opener.document.regist_newitem){
            window.opener.document.regist_newitem.genre_id.value = idval;
        }

        
        if(window.opener.document.regist_gbuyitem){
            window.opener.document.regist_gbuyitem.genre_id.value = idval;
        }
}

function changeMenu(cm) {

  var genre_id;

  var CatMenu = new Array(5);

  for (i = 0; i < document.ListItemForSale.elements.length; i++) {
    if (document.ListItemForSale.elements[i].name.indexOf("CatMenu") != -1) {
      CatMenu[document.ListItemForSale.elements[i].name] = document.ListItemForSale.elements[i];
    }
  }

  for (i = cm+1; i < CatMenu.length; i++) {
    CatMenu["CatMenu_"+i].length = 0;
    CatMenu["CatMenu_"+i].options[CatMenu["CatMenu_"+i].length] = new Option("-----------------------------------","-1");
  }

  genre_id = CatMenu["CatMenu_"+cm].options[CatMenu["CatMenu_"+cm].selectedIndex].value;
  if (!genre_id|| genre_id == "-1") {
    return;
  }
  gl_catid = genre_id;
  gl_catnm = CatMenu["CatMenu_"+cm].options[CatMenu["CatMenu_"+cm].selectedIndex].innerText;
  
    if (cm == 5 ) {
    return;
  }

  

    //alert( genre_id);

    new Ajax.Request(

      "ebay_getCat.php?catetory_id=" + genre_id + "&level=" + (cm+1), {
        method: "post",
        asynchronous: true,
        onSuccess: function(request) {
          check(request.responseText,cm);
        },
        onFailure: function(request) { 
	                alert('読み込みに失敗しました'); 
	            }, 
	            onException: function (request) { 
	                alert('読み込み中にエラーが発生しました'); 
	            } 
      }
    );


}

function check(responseText,cm) {
  if (responseText.match(/^<SELECT[\s\S]*<\/SELECT>\n*$/i)) {
  //alert("CatMenu_" + (cm+1));
    document.getElementById("CatMenu_" + (cm+1)).innerHTML = responseText;
  } 

}
function chooseCat() {
	window.opener.setFromSub(gl_catid,gl_catnm);
	window.close();
}

</script>
</head>

<body class="choice_index">

<form name="ListItemForSale" method=post action="">

<TABLE BORDER = 0 CELLPADDING = 3 CELLSPACING = 0>
  <TR valign="top">
    <TD ALIGN = LEFT>
      <span>第１階層</span>
      <div id = "CatMenu_0">
      <SELECT name = "CatMenu_0" size = "14" onChange = "changeMenu(0);">
      <?php
      	$sql = "select * from `ebay_mst` where steps=1 ";
	$rc = $db -> Exec($sql);
    // 成功
	while ($obj = $db -> fetch_object($rc)) {

      ?>
		<OPTION value = "<?php echo_h($obj -> catetory_id);?>"><?php echo_h($obj -> jp_name);?>(<?php echo_h($obj -> catetory_name);?>)</OPTION>
		<?php
		}
				$db -> close();

		?>
		</SELECT>

      </div>
    </TD>
    <TD>
      <span>第２階層</span>
      <div id="CatMenu_1">
      <SELECT NAME="CatMenu_1" size="14" onChange="changeMenu(1);">
        <OPTION value="-1">-----------------------------------</OPTION>
      </SELECT>
      </div>　
    </TD>
    <TD>
      <span>第３階層</span>
      <div id="CatMenu_2">
      <SELECT NAME="CatMenu_2" size="14" onChange="changeMenu(2);">
        <OPTION value="-1">-----------------------------------</OPTION>
      </SELECT>
      </div>
    </TD>
    <TD>
      <span>第４階層</span>
      <div id="CatMenu_3">
      <SELECT NAME="CatMenu_3" size="14" onChange="changeMenu(3);">
        <OPTION value="-1">-----------------------------------</OPTION>
      </SELECT>
      </div>
    </TD>
    <TD>
      <span>第５階層</span>
      <div id="CatMenu_4">
      <SELECT NAME="CatMenu_4" size="14" onChange="changeMenu(4);">
        <OPTION value="-1">-----------------------------------</OPTION>
      </SELECT>
      </div>
    </TD>
    <TD>
      <span>第６階層</span>
      <div id="CatMenu_5">
      <SELECT NAME="CatMenu_5" size="14" onChange="changeMenu(5);">
        <OPTION value="-1">-----------------------------------</OPTION>
      </SELECT>
      </div>
    </TD>

  </TR>
</TABLE>
<br>

<div class="choice"><input type="button" value="選択" onclick="chooseCat();"></div>

</form>


<div class="close"><A HREF="JavaScript:window.close()">このウインドウを閉じる</A></div>


</body>

</html>

