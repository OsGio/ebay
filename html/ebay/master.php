<?php 
	 session_start();
	require_once("common/db.php");
	$username = $_SESSION["CONVERTER_USERID"];
	if($username != ADMIN){
		header("Location: login.php?errorMsg=管理者権限が必要です。再度ログインしてください。");
	}
include('header.php'); 
?>

<script type="text/javascript">
  function doUp(){
	  	document.frm.action = "user.php";
	  	document.frm.submit();
  }

</script>
<!-- /header -->



<section id="title_space">
<div>
<h2 class="edit_dictionary">管理者メニュー</h2>


</div>
</section>




<div id="content">

    <div class="mainCol" id="dataImport">



<form action="master.php" name="frm"  method="post" accept-charset="utf-8">

<p align="center">
		<input type="button" value=" ユーザ管理 " onclick="doUp();" class="btn_basic" />
</p>

</form>

</div>

	<!-- /mainCol -->




</div>


<!-- /content -->


<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
