<?php include('header.php'); ?>
<!-- /header -->
<div id="bread">
	<ul>
		<li><img src="img/icon_home.gif" width="26" height="25" alt="" /></li>
		<li><a href="menu.php"><?php echo_h(STORE_NAME);?></a> > <span>有償機能ご紹介</span></li>
	</ul>
</div>
<!-- /bread -->

<div id="content">

    <style type="text/css">
iframe {
	width:100%;
	height:1500px;
}
</style>


<div class="mainCol" id="dataImport">
<h2>有償機能ご紹介</h2>
<br><br>
<iframe src="files/optioninfo.html" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
</div>	<!-- /mainCol -->
<?php include('left.php'); ?>


	<!-- /leftCol -->
</div>


<!-- /content -->


<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
