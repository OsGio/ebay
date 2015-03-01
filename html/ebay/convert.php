<?php
include('header.php');

$username = $_SESSION["CONVERTER_USERID"];
$uploaddir = 'csv/';
$uploadfile = $uploaddir .$username."_". $_FILES['item']['name'];

$db = new dbclass();


$create_time = date('Y-m-d H:i:s', time()-86400);
$sql = "select id from `ebay_result_tbl` where username = '".$db->esc($username)."' AND create_time > '".$db->esc($create_time)."'";
$rc = $db -> Exec($sql);

if ($db->NumRows($rc) > 0) {
	$convert_message = 'コンバートが完了いたしました。下記の各操作が行えます。';
}


if (isset($_GET["exec"]) && $_GET["exec"] == "1") {

//fortest	$sql = "delete from  `ebay_result_tbl` where username = '".$db->esc($username)."'";
	$rc = $db -> Exec($sql);
	if(!rc) {
		$message = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $sql;
		die($message);
	}

	//exec("php /home/wasab/www/eBay_converter/convert_rakuten.php $username");
	exec("nohup /usr/bin/php /var/www/html/ebay/convert_rakuten.php $username > /dev/null 2>&1 &");
	$convert_message = '商品データをeBay向けデータへ変換しています。。。';
	$finish_message = 'データの変換が完了しました！';

} elseif (isset($_GET["exec"]) && $_GET["exec"] == "3") {

	//exec("php /home/wasab/www/eBay_converter/ebay_addItem.php $username");
	exec("nohup /usr/bin/php /var/www/html/ebay/ebay_addItem.php $username > /dev/null 2>&1 &");
	$convert_message = 'eBayへ商品を出品しています。。。';
	$finish_message = 'eBayへの出品が完了しました！';
}
?>

<script type="text/javascript">
    var timer_process;

	<?php if (isset($_GET["exec"])) { ?>
    $(function() {
        timer_process = setInterval("get_batch_progress()", 1000);
    });
	<?php } ?>

    function get_batch_progress() {
        $.ajax({
            type: "GET",
            url: './log_exist_check.php',
            success: function(data){
                    console.log(data);
                    if (data == 'true') {
                        clearInterval(timer_process);
                        // alert('<?php //echo $finish_message; ?>(変換・実行ログ画面に移動します)');
							alert('変換・実行ログ画面に移動します');
					location.href = './log.php';
                    }
            }
        });
    }

	function doChange(){
		if(confirm("データ変換がバックグランドで実行され、変換完了時登録メールに送信致します。実行してよろしいですか？")) {
			document.frm.action = "convert.php?exec=1";
			document.frm.submit();
		}
	}
    function doDl(){
  	if(confirm("CSVをダウンロードしますか？")) {
	  	document.frm.action = "csv.php";
	  	document.frm.submit();
  	}
  }
  function doUp(){
  	if(confirm("実行してよろしいですか？")) {
	  	document.frm.action = "convert.php?exec=3";
	  	document.frm.submit();
  	}
  }

</script>
<!-- /header -->



<section id="title_space">
<div>
<h2 class="convert"><span style="font-weight:bold;background:url(img/title_logo_07.png) no-repeat 0 50%;padding:10px 0 10px 50px;background-size:40px 40px;">4. eBayデータへコンバート・出品</span></h2>

<p>
設定された情報を元に、コンバート（変換）をします。<br>
変換完了後、CSVデータとしてダウンロードするか、そのままワンクリックで出品するかを選択できます。<br>
コンバート時のエラーチェックもこちらで行えます。
</p>

</div>
</section>





<div id="content">

    <div class="mainCol" id="">


<?php if ($GLOBALS['announce']) { ?><div class="attention"><?php echo $GLOBALS['announce']; ?></div><?php } ?>

<form action="convert.php" name="frm"  enctype="multipart/form-data" id="/mypage/indexIndexForm" method="post" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST"/>


<div class="conv">
		<a href="#" onclick="doChange();"><img src="img/btn_conv.gif"  alt="" /></a>
</div>

<?php if (isset($_GET["exec"])) { ?>
	<div id="convert_message">
		<img src="img/loading.gif"><br />
		<?php echo_h($convert_message); ?>
	</div>
<?php } ?>



<div align="center" style="margin:20px 0;">
<img src="img/arrow3.gif" />
</div>





<table>

<tr>

<td align="center" width="33%">
		<img src="img/conv01_icon.gif" alt="" /><br>
		<a href="log.php"><img src="img/conv01_btn.gif" alt="変換結果を見る" /></a>
		<div class="conv_info">
		エラーログなどの変換結果が確認できます。
		</div>
</td>



<td align="center" width="34%">
		<img src="img/conv02_icon.gif" alt="" /><br>
		<a href="#" onclick="doDl();"><img src="img/conv02_btn.gif" alt="CSVダウンロード" /></a>
		<div class="conv_info">
		変換後のデータをCSV形式でダウンロードできます。<br>
		eBayアプリ「<a href="http://pages.ebay.com/sellerinformation/sellingresources/fileexchange.html" target="_blank"  style="text-decoration:underline">File Exchange</a>」などでアップロードが可能です。<br><br>
		<a href="#file-ex-movie" style="text-decoration:underline;font-weight:bold;">>>「File Exchange」設置・使用方法</a>
		</div>

<div class="remodal" data-remodal-id="file-ex-movie">
<iframe width="480" height="360" src="//www.youtube.com/embed/DaXSu0J15Fw" frameborder="0" allowfullscreen></iframe>
</div>

</td>


<td align="center" width="33%">
		<img src="img/conv03_icon.gif" alt="" /><br>

			<?php
			//登録済みのeBayトークンを取得
			$sql = "select * from `user_tbl` where username = '".$db->esc($username)."' ";
			$rc = $db -> Exec($sql);
			$token = '';
			if ($obj = $db -> fetch_object($rc)) {
				$token = $obj -> token;
			}
			?>
			<?php if (isset($token) && $token <> '') { ?>
				<input type="image" name="auth" value=" eBayへ商品登録 " onclick="doUp();" src="img/conv03_btn.gif" />

			<?php }else{ ?>
				<a href="#ebay-set"><img src="img/conv03-0_btn.gif"></a>
				<div class="conv_info">
				本サービスをeBayにつなぎ合わせる作業です。<br>初回出品時のみの作業となり、認証作業完了後、自動出品が可能となります。<br><br>
				<a href="#ninsho" style="text-decoration:underline;font-weight:bold;">>eBayへの認証方法</a>
<div class="remodal" data-remodal-id="ninsho">
<iframe width="560" height="315" src="//www.youtube.com/embed/w-btdq6XH88?rel=0" frameborder="0" allowfullscreen></iframe>
</div>

				</div>

				<div class="remodal" data-remodal-id="ebay-set">
				<iframe width="560" height="315" src="./ebayAuth1.php" frameborder="0" allowfullscreen></iframe>
				</div>
			<?php }
			$db -> close();
			?>

</td>

</tr>

</table>




</form>






</div><!-- /mainCol -->





</div><!-- /content -->


<div id="footer">
<?php include('footer.php'); ?>
</div>



</body>
</html>
