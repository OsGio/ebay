<?php
	require_once("common/auth.php");
	require_once("common/db.php");
	//error_reporting(0);
	 session_start();
	DEFINE("STORE_NAME",'使える！簡単！海外ネットショップへの移行・変換なら、ebay対応の【海外販売ネットショップ商品データ移行】');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">

<title>使える！簡単！海外ネットショップへの移行・変換なら、ebay対応の【海外販売ネットショップ商品データ移行】</title>

<link href="/favicon.png" type="image/png" rel="icon" />
<link href="/favicon.png" type="image/png" rel="shortcut icon" />

<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/jquery-ui-timepicker-addon.css" />

<script src="//code.jquery.com/jquery-1.11.0.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js" type="text/javascript"></script>
<script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
<script src="js/jquery.ui.datepicker-ja.js" type="text/javascript"></script>
<script src="js/cpick.js" type="text/javascript"></script>
<script src="js/jquery.easing.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/bootstrap-theme.js" type="text/javascript"></script>
<script src="js/bootstrap-theme.min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/template.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">

<style type="text/css"><!--
@import url(http://fonts.googleapis.com/css?family=Montserrat:400,700);
    #example2 .dropdown:hover .dropdown-menu,
    #example3 .dropdown:hover .dropdown-menu{
        display: block;
    }
}
--></style>


	    <script type="text/javascript" src="js/jquery.lavalamp.js"></script>
		<script type="text/javascript">
	        $(function() {

				path = location.pathname;
				if(path.match("/import_data")){
					$("#nav li.gn01").addClass("current");
				} else if(path.match("/exhibit_setting")){
					$("#nav li.gn02").addClass("current");
				} else if(path.match("/sale_setting")){
					$("#nav li.gn03").addClass("current");
				} else if(path.match("/directory")){
					$("#nav li.gn04").addClass("current");
				} else if(path.match("/edit_keyword")){
					$("#nav li.gn05").addClass("current");
				} else if(path.match("/edit_dictionary")){
					$("#nav li.gn06").addClass("current");
				} else if(path.match("/convert")){
					$("#nav li.gn07").addClass("current");
				} else {
					$("#nav li.gn01").addClass("current");
				}
						
	            $("#nav1, #nav2, #nav3").lavaLamp({
	                fx: "easeOutElastic",
	                speed: 1000
	            });
							
	        });
		</script>


<script type="text/javascript">  
$('.dropdown-toggle').click(function() {
    var location = $(this).attr('href');
    window.location.href = location;
    return false;
});
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-34847294-10', 'auto');
  ga('send', 'pageview');

</script>

</head>

<body>


<div class="remodal-bg">

<div id="top_bar">
<div class="inner">

<div class="logo">
<a href="top.php"><img src="img/logo_new.png" /></a>
</div>

<p class="head_subtitle">最短４ステップでeBayデータにコンバート！[ WORLD CONVERTER ]</p>

<div class="top_menu">
<?php if ($_SESSION["CONVERTER_USERID"] == ADMIN){ ?>
<div class="help">
<a href="master.php">管理者メニュー</a>
</div>
<?php } else { ?>
<div class="help">
<a href="http://wasab.net/howto/converter/" target="_blank">ヘルプ</a>
</div>
<?php } ?>

<nav id="example2" role="navigation" class="menu">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown"><img src="img/icon_people.png"></a>
          <ul class="dropdown-menu" role="menu" style="margin-left:-102px;padding:5px;">
            <li style="background:#fff;">ID:<?php echo_h($_SESSION["CONVERTER_USERID"]);?></li>
            <li class="divider"></li>
            <li style="margin-bottom:3px;"><a href="account_setting.php" style="background:#D6EFB9;">アカウント設定</a></li>
            <li><a href="login.php?logout=1" style="background:#dcdcdc;">ログアウト</a></li>
          </ul>
        </li>
      </ul>
</nav>

</div>

</div>
</div>


<div id="nav">

         <ul class="lavaLampBottomStyle" id="nav3">

             <li class="gn01"><a href="import_data.php"><img src="img/no01.png" /><span>データ取り込み</span></a></li>
             <li class="gn02"><a href="exhibit_setting.php"><img src="img/no02.png" /><span>出品設定</span></a></li>
             <li class="gn03"><a href="sale_setting.php"><img src="img/no03.png" /><span>商品データ設定</span></a></li>
             <li class="gn04"><a href="directory.php"><img src="img/no00.png" /><span>eBayカテゴリ変換</span></a></li>
             <li class="gn05"><a href="edit_keyword.php"><img src="img/no00.png" /><span>キーワード変換</span></a></li>
             <li class="gn06"><a href="edit_dictionary.php"><img src="img/no00.png" /><span>英訳辞書</span></a></li>
             <li class="gn07"><a href="convert.php"><img src="img/no04.png" /><span>コンバート・出品</span></a></li>

         </ul>

</div>


