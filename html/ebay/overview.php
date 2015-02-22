<?php include('header.php'); ?>
<!-- /header -->
<div id="bread">
	<ul>
		<li><img src="img/icon_home.gif" width="26" height="25" alt="" /></li>
		<li><a href="menu.php"><?php echo_h(STORE_NAME);?></a> > <span>概要説明</span></li>
	</ul>
</div>
<!-- /bread -->

<div id="content">

    <style type="text/css">
iframe {
	width:100%;
	height:2300px;
}
</style>


<div class="mainCol" id="dataImport">
<h2>概要説明</h2>
<iframe src="files/overview_sc.html" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
</div>
	<!-- /mainCol -->
<?php include('left.php'); ?>


	<!-- /leftCol -->
</div>


<!-- /content -->


<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
