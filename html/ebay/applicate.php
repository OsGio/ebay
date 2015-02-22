<?php include('header.php'); 

$loginname = $_SESSION["CONVERTER_USERID"];
$db = new dbclass();
if (isset($_POST["applicate"])) {
					$sql = "select username from  `payed_user_tbl` where username = '".$db->esc($loginname)."'";
					
					$rc = $db -> Exec($sql);
					
  					$company = $_POST["company"];
  					$postcode = $_POST["postcode"];
  					$username = $_POST["username"];
  					$address = $_POST["address"];
  					$tel = $_POST["tel"];
  					$email = $_POST["email"];
  					$rakutenname = $_POST["rakutenname"];
  					$entry = implode(",", $_POST["entry"]);
  					
					if($db -> NumRows($rc) > 0) {
						$sql = "update `payed_user_tbl` set 
						company_name = '".$db->esc($company)."',
						zip_code = '".$db->esc($postcode)."',
						address = '".$db->esc($address)."',
						charge_name = '".$db->esc($username)."',
						tel = '".$db->esc($tel)."',
						email = '".$db->esc($email)."',
						rakuten_url = '".$db->esc($rakutenname)."',
						resource = '".$db->esc($entry)."' 
						where username = '".$db->esc($loginname)."'";
						$db -> Exec($sql);
						
						
					}else{
				
						$sql = "insert into `payed_user_tbl`(
							`username` ,
							`company_name` ,
							`zip_code` ,
							`address` ,
							`charge_name` ,
							`tel` ,
							`email` ,
							`rakuten_url` ,
							`resource`
						) values(  '".$db->esc($loginname)."',
						'".$db->esc($company)."',
						'".$db->esc($postcode)."',
						'".$db->esc($address)."',
						'".$db->esc($username)."',
						'".$db->esc($tel)."',
						'".$db->esc($email)."',
						'".$db->esc($rakutenname)."',
						'".$db->esc($entry)."') ";
						$db -> Exec($sql);
					}
					$sql = "update  `user_tbl` set payed = 2 where username = '".$db->esc($loginname)."'";
						
					$db -> Exec($sql);
		        	$db -> sendpayed($loginname,true,$loginname);
		        	$db -> sendpayed($loginname,false,ADMIN_EMAIL);

		echo "有償機能のお申込み有難う御座います。";

}
?>
<!-- /header -->


<div id="content">

    <div>


	<h2><img src="img/title_app.gif" alt="有償機能のお申し込み" /></h2>


<script type="text/javascript">
      /**
      *  * @license
      *   *! H5F
      *    * https://github.com/ryanseddon/H5F/
      *     * Copyright (c) Ryan Seddon | Licensed MIT
      *      */

(function(e,t){"function"==typeof define&&define.amd?define(t):e.H5F=t()})(this,function(){var e,t,a,i,n,r,s,l,u,o,c,d,v,f,p,m,h,g,b,y,w,C,N,A,E,$,k=document,x=k.createElement("input"),q=/^[a-zA-Z0-9.!#$%&'*+-\/=?\^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,M=/[a-z][\-\.+a-z]*:\/\//i,L=/^(input|select|textarea)$/i;return r=function(e,t){var a=!e.nodeType||!1,i={validClass:"valid",invalidClass:"error",requiredClass:"required",placeholderClass:"placeholder"};if("object"==typeof t)for(var r in i)t[r]===void 0&&(t[r]=i[r]);if(n=t||i,a)for(var l=0,u=e.length;u>l;l++)s(e[l]);else s(e)},s=function(a){var i,n=a.elements,r=n.length,s=!!a.attributes.novalidate;if(b(a,"invalid",u,!0),b(a,"blur",u,!0),b(a,"input",u,!0),b(a,"keyup",u,!0),b(a,"focus",u,!0),b(a,"change",u,!0),b(a,"click",o,!0),b(a,"submit",function(i){e=!0,t||s||a.checkValidity()||w(i)},!1),!v())for(a.checkValidity=function(){return c(a)};r--;)i=!!n[r].attributes.required,"fieldset"!==n[r].nodeName.toLowerCase()&&l(n[r])},l=function(e){var t=e,a=g(t),n={type:t.getAttribute("type"),pattern:t.getAttribute("pattern"),placeholder:t.getAttribute("placeholder")},r=/^(email|url)$/i,s=/^(input|keyup)$/i,l=r.test(n.type)?n.type:n.pattern?n.pattern:!1,u=f(t,l),o=m(t,"step"),v=m(t,"min"),h=m(t,"max"),b=!(""===t.validationMessage||void 0===t.validationMessage);t.checkValidity=function(){return c.call(this,t)},t.setCustomValidity=function(e){d.call(t,e)},t.validity={valueMissing:a,patternMismatch:u,rangeUnderflow:v,rangeOverflow:h,stepMismatch:o,customError:b,valid:!(a||u||o||v||h||b)},n.placeholder&&!s.test(i)&&p(t)},u=function(e){var t=C(e)||e,a=/^(input|keyup|focusin|focus|change)$/i,r=/^(submit|image|button|reset)$/i,s=/^(checkbox|radio)$/i,o=!0;!L.test(t.nodeName)||r.test(t.type)||r.test(t.nodeName)||(i=e.type,v()||l(t),t.validity.valid&&(""!==t.value||s.test(t.type))||t.value!==t.getAttribute("placeholder")&&t.validity.valid?(A(t,[n.invalidClass,n.requiredClass]),N(t,n.validClass)):a.test(i)?t.validity.valueMissing&&A(t,[n.requiredClass,n.invalidClass,n.validClass]):t.validity.valueMissing?(A(t,[n.invalidClass,n.validClass]),N(t,n.requiredClass)):t.validity.valid||(A(t,[n.validClass,n.requiredClass]),N(t,n.invalidClass)),"input"===i&&o&&(y(t.form,"keyup",u,!0),o=!1))},c=function(t){var a,i,n,r,s=!1;if("form"===t.nodeName.toLowerCase()){a=t.elements;for(var l=0,o=a.length;o>l;l++)i=a[l],n=!!i.attributes.required,r=!!i.attributes.pattern,"fieldset"!==i.nodeName.toLowerCase()&&(n||r&&n)&&(u(i),i.validity.valid||s||(e&&i.focus(),s=!0));return!s}return u(t),t.validity.valid},d=function(e){var t=this;t.validationMessage=e},o=function(e){var a=C(e);a.attributes.formnovalidate&&"submit"===a.type&&(t=!0)},v=function(){return E(x,"validity")&&E(x,"checkValidity")},f=function(e,t){if("email"===t)return!q.test(e.value);if("url"===t)return!M.test(e.value);if(t){var i=e.getAttribute("placeholder"),n=e.value;return a=RegExp("^(?:"+t+")$"),n===i?!1:""===n?!1:!a.test(e.value)}return!1},p=function(e){var t={placeholder:e.getAttribute("placeholder")},a=/^(focus|focusin|submit)$/i,r=/^(input|textarea)$/i,s=/^password$/i,l=!!("placeholder"in x);l||!r.test(e.nodeName)||s.test(e.type)||(""!==e.value||a.test(i)?e.value===t.placeholder&&a.test(i)&&(e.value="",A(e,n.placeholderClass)):(e.value=t.placeholder,b(e.form,"submit",function(){i="submit",p(e)},!0),N(e,n.placeholderClass)))},m=function(e,t){var a=parseInt(e.getAttribute("min"),10)||0,i=parseInt(e.getAttribute("max"),10)||!1,n=parseInt(e.getAttribute("step"),10)||1,r=parseInt(e.value,10),s=(r-a)%n;return g(e)||isNaN(r)?"number"===e.getAttribute("type")?!0:!1:"step"===t?e.getAttribute("step")?0!==s:!1:"min"===t?e.getAttribute("min")?a>r:!1:"max"===t?e.getAttribute("max")?r>i:!1:void 0},h=function(e){var t=!!e.attributes.required;return t?g(e):!1},g=function(e){var t=e.getAttribute("placeholder"),a=/^(checkbox|radio)$/i,i=!!e.attributes.required;return!(!i||""!==e.value&&e.value!==t&&(!a.test(e.type)||$(e)))},b=function(e,t,a,i){E(window,"addEventListener")?e.addEventListener(t,a,i):E(window,"attachEvent")&&window.event!==void 0&&("blur"===t?t="focusout":"focus"===t&&(t="focusin"),e.attachEvent("on"+t,a))},y=function(e,t,a,i){E(window,"removeEventListener")?e.removeEventListener(t,a,i):E(window,"detachEvent")&&window.event!==void 0&&e.detachEvent("on"+t,a)},w=function(e){e=e||window.event,e.stopPropagation&&e.preventDefault?(e.stopPropagation(),e.preventDefault()):(e.cancelBubble=!0,e.returnValue=!1)},C=function(e){return e=e||window.event,e.target||e.srcElement},N=function(e,t){var a;e.className?(a=RegExp("(^|\\s)"+t+"(\\s|$)"),a.test(e.className)||(e.className+=" "+t)):e.className=t},A=function(e,t){var a,i,n="object"==typeof t?t.length:1,r=n;if(e.className)if(e.className===t)e.className="";else for(;n--;)a=RegExp("(^|\\s)"+(r>1?t[n]:t)+"(\\s|$)"),i=e.className.match(a),i&&3===i.length&&(e.className=e.className.replace(a,i[1]&&i[2]?" ":""))},E=function(e,t){var a=typeof e[t],i=RegExp("^function|object$","i");return!!(i.test(a)&&e[t]||"unknown"===a)},$=function(e){for(var t=document.getElementsByName(e.name),a=0;t.length>a;a++)if(t[a].checked)return!0;return!1},{setup:r}});
function sendPay(){
	document.ss-form.action = "applicate.php?exec=1";
  	document.ss-form.submit();
}
function doPay(){
	location.href="";
}


    </script>





<p class="midashi">

お申込みいただきますと下記の有償機能がご利用いただけるようになります。<br><br>

　　１．楽天ディレクトリIDをeBayカテゴリへ自動変換（紐付け設定）<br>
　　２．ebayへのワンクリック自動出品機能

</p>

<table class="datatable">
	<tr>
		<th style="width:100px;">ご利用料金</th>
		<td>楽天１店舗１年間　<strike>120,000円</strike>　→　<strong style="color:#ff0000;">100,000円</strong>（税別）※１年ごと更新</td>
	</tr>
	<tr>
		<th>お支払方法</th>
		<td>PayPal、銀行振り込みによる前払い</td>
	</tr>
</table>






<div style="color:#cc0000;margin:20px;">

※有償機能は、このアカウントで取り込んだ楽天店舗に対して有効となります。<br>
別の楽天店舗に有償機能を付けたい場合は、別のアカウントをご登録いただきそちらで有償機能のお申し込みを行ってください。

</div>







<?php

					//$sql = "select username from  `payed_user_tbl` where username = '$loginname'";
					
					//$rc = $db -> Exec($sql);
					$sql = "select * from  `user_tbl` where username = '".$db->esc($loginname)."'";
					
					$rc = $db -> Exec($sql);
					if($db -> NumRows($rc) > 0) {
					$obj = $db -> fetch_object($rc);
					$payed = $obj -> payed;

  					
					if($payed == 0) {

?>

<div class="ss-form">


<div style="font-weight:bold;">

▼以下の項目に入力してください。

</div>



<form action="applicate.php" name="ss-form" method="POST" id="ss-form" target="_self">




<h2 style="background-color:#ccc;font-size:14px;padding:10px 25px;font-weight:bold;margin-bottom:15px;">お客様情報</h2>



<table class="datatable">


<tr>
<th width="30%">
<label aria-hidden="true" class="ss-q-item-label" for="entry_company">会社名
<label for="itemView.getDomIdToLabel()" aria-label="（必須）"></label>
<span>*</span>
</label>
</th>
<td>
<input type="text" name="company" value="" style="width:95%;" id="entry_company" dir="auto" aria-label="会社名  " aria-required="true" required="" title="">
<div class="error-message"></div>
</td>
</tr>



<tr>
<th>
<label aria-hidden="true" class="ss-q-item-label" for="entry_postcode">郵便番号
<label for="itemView.getDomIdToLabel()" aria-label="（必須）"></label>
<span>*</span>
</label>
</th>
<td>
<input type="text" name="postcode" value="" id="entry_postcode" dir="auto" aria-label="郵便番号  " aria-required="true" required="" title="">
<div class="error-message"></div>
</td>
</tr>



<tr>
<th>
<label aria-hidden="true" class="ss-q-item-label" for="entry_address"><div class="ss-q-title">所在地
<label for="itemView.getDomIdToLabel()" aria-label="（必須）"></label>
<span>*</span>
</label>
</th>
<td>
<textarea name="address" rows="3" cols="0" style="width:95%;margin:3px 5px;padding:5px;border: solid 1px #ccc;border-radius: 3px;" id="entry_address" dir="auto" aria-label="所在地  " aria-required="true" required=""></textarea>
<div class="error-message"></div>
</td>
</tr>



<tr>
<th>
<label aria-hidden="true" class="ss-q-item-label" for="entry_username">ご担当者名
<label for="itemView.getDomIdToLabel()" aria-label="（必須）"></label>
<span>*</span>
</label>
</th>
<td>
<input type="text" name="username" value="" class="ss-q-short" id="entry_username" dir="auto" aria-label="ご担当者名  " aria-required="true" required="" title="">
<div class="error-message"></div>
</td>
</tr>



<tr>
<th>
<label aria-hidden="true" class="ss-q-item-label" for="entry_postcode"><div class="ss-q-title">電話番号
<label for="itemView.getDomIdToLabel()" aria-label="（必須）"></label>
<span>*</span>
</label>
</th>
<td>
<input type="text" name="tel" value="" class="ss-q-short" id="entry_postcode" dir="auto" aria-label="電話番号  " aria-required="true" required="" title="">
<div class="error-message"></div>
</td>
</tr>



<tr>
<th>
<label aria-hidden="true" class="ss-q-item-label" for="entry_email"><div class="ss-q-title">ご連絡先メールアドレス
<label for="itemView.getDomIdToLabel()" aria-label="（必須）"></label>
<span>*</span>
</label>
</th>
<td>
<input type="text" name="email" value="" style="width:95%;" id="entry_email" dir="auto" aria-label="ご連絡先メールアドレス  " aria-required="true" required="" title="">
<div class="error-message"></div>
</td>
</tr>



<tr>
<th>
<label aria-hidden="true" class="ss-q-item-label" for="entry_rakuten_shop">ご利用される楽天店舗URL
<label for="itemView.getDomIdToLabel()" aria-label="（必須）"></label>
<span>*</span>
(RMSに表示されている店舗URL)</label>
</th>
<td>
<input type="text" name="rakutenname" value="" style="width:95%;" id="entry_rakuten_shop" dir="auto" aria-label="ご利用される楽天店舗URL" aria-required="true" required="" title="">
<div class="error-message"></div>
</td>
</tr>






<!--不要

<div class="errorbox-good">
<div dir="ltr" class="ss-item  ss-section-header"><div class="ss-form-entry"><h2 class="ss-section-title" style="background-color:#ccc;line-height:50px;">ヤフーストア情報</h2>
<div class="ss-section-description ss-no-ignore-whitespace"></div>

</div></div></div> <div class="ss-form-question errorbox-good">
<div dir="ltr" class="ss-item ss-item-required ss-text"><div class="ss-form-entry"><label aria-hidden="true" class="ss-q-item-label" for="entry_storeaccount"><div class="ss-q-title">ヤフーストアアカウント
<label for="itemView.getDomIdToLabel()" aria-label="（必須）"></label>
<span class="ss-required-asterisk">*</span></div>
<div class="ss-q-help ss-secondary-text" dir="ltr"></div></label>
<input type="text" name="storeaccount" value="" class="ss-q-short" id="entry_storeaccount" dir="auto" aria-label="ヤフーストアアカウント  " aria-required="true" required="" title="">
<div class="error-message"></div>
<div class="required-message">この質問は必須です</div>

</div></div></div> <div class="ss-form-question errorbox-good">
<div dir="ltr" class="ss-item  ss-text"><div class="ss-form-entry"><label aria-hidden="true" class="ss-q-item-label" for="entry_storename"><div class="ss-q-title">ヤフーストア名
</div>
<div class="ss-q-help ss-secondary-text" dir="ltr"></div></label>
<input type="text" name="storename" value="" class="ss-q-short" id="entry_storename" dir="auto" aria-label="ヤフーストア名  " title="">
<div class="error-message"></div>
<div class="required-message">この質問は必須です</div>

</div></div></div> 

-->




<tr>
<th>
<label aria-hidden="true" class="ss-q-item-label" for="entry_1105965730">アイテムコンバーターをどちらでお知りになりましたか？<br>
複数選択可
</label>
</th>
<td>
<ul class="ss-choices" role="group" aria-label="アイテムコンバーターをどちらでお知りになりましたか？ 複数選択可 ">
<li class="ss-choice-item"><label><span class="ss-choice-item-control goog-inline-block"><input type="checkbox" name="entry[]" value="&#12452;&#12531;&#12479;&#12540;&#12493;&#12483;&#12488;&#26908;&#32034;" id="group_1736572596_1" role="checkbox" class="ss-q-checkbox">&nbsp;インターネット検索</span>
</label></li> <li class="ss-choice-item"><label><span class="ss-choice-item-control goog-inline-block"><input type="checkbox" name="entry[]" value="facebook" id="group_1736572596_2" role="checkbox" class="ss-q-checkbox">&nbsp;facebook</span>
</label></li> <li class="ss-choice-item"><label><span class="ss-choice-item-control goog-inline-block"><input type="checkbox" name="entry[]" value="&#30693;&#20154;&#12363;&#12425;" id="group_1736572596_3" role="checkbox" class="ss-q-checkbox">&nbsp;知人から</span>
</label></li> <li class="ss-choice-item"><label><span class="ss-choice-item-control goog-inline-block"><input type="checkbox" name="entry[]" value="&#24330;&#31038;&#12363;&#12425;&#12398;&#12372;&#26696;&#20869;" id="group_1736572596_4" role="checkbox" class="ss-q-checkbox">&nbsp;弊社からのご案内</span>
</label></li> <li class="ss-choice-item"><label><span class="ss-choice-item-control goog-inline-block"><input type="checkbox" name="entry[]" value="&#12381;&#12398;&#20182;" id="group_1736572596_5" role="checkbox" class="ss-q-checkbox">&nbsp;その他</span>
</label></li></ul>

<div class="error-message"></div>

</td>
</tr>

</table>





<div style="margin:15px 20px;">

<p>
入力が終わりましたら、下の「送信」を押してください。<br>
銀行振り込みの場合、お振込先などを記載した案内メールを元にご入金手続きをお願いいたします。
</p>
<p>
Paypal決済の場合は、フォーム送信画面後にそのままご入金手続きができます。
</p>
<p style="color:#cc0000;">
※ご入力いただいた内容が事実と確認できない場合、ご利用をお断りする場合がございます。
</p>

</div>






<div style="text-align:center;margin:10px 0 30px 0;">

<input type="submit" name="applicate" value="  &#36865;&#20449;  " class="btn_sousin" id="ss-submit">
<!-- INFO: The post URL "checkout.php" is invoked when clicked on "Pay with PayPal" button.-->

</div>

</form>
</div>



<?php
}else if($payed == 2){
?>
<div class="attention">このアカウントでは既に有償機能をお申し込みいただいております。下記にてお支払い手続きができます。</div>
<div align="center" style="margin:20px 0;">
<img src="img/arrow_under.gif" />
</div>
<div align="center">
	

<form action='checkout.php' METHOD='POST'>
	<input type='image' name='paypal_submit' id='paypal_submit'  src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif' border='0' align='top' alt='Pay with PayPal'/>
</form>


</div>

<?php
}else if($payed == 1){
?>
<div class="attention">このアカウントでは既にお手続きが完了しております。</div>
<?php
}else if($payed == 3){
?>
<div class="attention">このアカウントでの有償機能のご利用は既に期限切れとなっております。下記にて追加でお支払できます。</div>
<div align="center" style="margin:20px 0;">
<img src="img/arrow_under.gif" />
</div>
<div align="center">
<form action='checkout.php' METHOD='POST'>
	<input type='image' name='paypal_submit' id='paypal_submit'  src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif' border='0' align='top' alt='Pay with PayPal'/>
</form>
</div>

<?php
}
}
		$db -> close();

?>



</div>

<div id="docs-aria-speakable" class="docs-a11y-ariascreenreader-speakable docs-offscreen" aria-live="assertive" role="region" aria-atomic></div></div>

<script type='text/javascript' src='/static/forms/client/js/3589211663-formviewer_prd__ja.js'></script>
<script type="text/javascript">H5F.setup(document.getElementById('ss-form'));_initFormViewer(
        "[100,\x22#ccc\x22,[]\n]\n");
            </script>
</div>

	<!-- /mainCol -->

</div>


<!-- Add Digital goods in-context experience. Ensure that this script is added before the closing of html body tag -->

<script src='https://www.paypalobjects.com/js/external/dg.js' type='text/javascript'></script>
<script>

	var dg = new PAYPAL.apps.DGFlow(
	{
		trigger: 'paypal_submit',
		expType: 'instant'
		 //PayPal will decide the experience type for the buyer based on his/her 'Remember me on your computer' option.
	});

</script>

<!-- /content -->


<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
