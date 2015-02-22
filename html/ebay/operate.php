<?php include('header.php'); ?>
<!-- /header -->
<div id="bread">
	<ul>
		<li><img src="img/icon_home.gif" width="26" height="25" alt="" /></li>
		<li><a href="menu.php"><?php echo_h(STORE_NAME);?></a> > <span>操作方法</span></li>
	</ul>
</div>
<!-- /bread -->

<div id="content">

    <div class="mainCol" id="dataImport">

<h2>操作方法</h2>

<div align="right"><a href="faq.php">＞＞ＦＡＱ</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="overview.php">＞＞概要説明</a></div>
<style type="text/css">
  div.div_info {
    display : block;
    width : 600px;
    white-space : normal;
  }
  span.description {
    display : block;
    width : 700px;
    white-space : normal;
  }
  div.div_info span {
    display : block;
    width : 635px;
    white-space : normal;
  }
</style>
<table>
	<tr>
		<th><div class="help_title">お使いいただく前に　　＞＞楽天・ヤフーでの手続き＞＞</div></th>
	</tr>
	<tr>
		<td>
		<span class="description">ストアコンバーターをお使いいただくにあたっては、楽天・ヤフーにおいて以下の手続きが必要です。まだの方は手続きを行ってください。</span>
			<div class="div_info">
			<ul>
				<li>楽天のRMS画面から「商品一括登録サービス（有料）」をお申し込みください。
					<span>楽天から商品CSVをダウンロードする必要がありますので上記サービスをお申し込みください。基本料金は月額10,000円です。申込も解約もRMS画面から簡単に行えます。詳しくは楽天にお問合せ下さい。</span>
				<li>有償機能をご利用いただく場合は、ヤフーにFTPの申込を行ってください。
					<span>画像や商品CSVの自動転送を行うためにFTPの申請が必要です。申請から利用できるようになるまでに数週間かかる場合があるようですので、こちらは早めにお申し込みください。詳しくはヤフーにお問合せ下さい。</span>
			</ul>
			</div>
		</td>
	</tr>
	<tr>
		<th><div class="help_title">１．環境設定　　＞＞環境設定を行います＞＞</div></th>
	</tr>
	<tr>
		<td>
		<span class="description">ストアコンバーターでは、まず最初に「環境設定」を行います。</span>
			<div class="div_info">
			<ul>
				<li>ヤフーの商品コードにする楽天カラム
					<span> [商品番号]カラムか[商品管理番号（商品URL)]を選べます。</span>
				<li>ログイン時の情報
					<span>各処理が完了するとアカウントIDであるメールアドレスに完了メールが送信されます。</span>
				<li>ヤフーFTPサーバの情報
					<span>FTP自動転送(※有償機能)を行う場合は、FTPのログイン情報を登録しておきます。</span>
			</ul>
			</div>
		</td>
	</tr>

	<tr>
		<th><div class="help_title">２．楽天データ取込　　＞＞楽天の商品CSVを取り込みます＞＞</div></th>
	</tr>
	<tr>
		<td>
		<span class="description">楽天からダウンロードした商品CSVを選択し「データ取込」をクリックして取り込みます。</span>
			<div class="div_info">
			<ul>
				<li>商品CSV（item.csv）
					<span>楽天からCSVをダウンロードする際は「固定フォーマットでダウンロード（詳細タイプ）」を選択してください。</span>
				<li>項目選択肢CSV（select.csv）
					<span>項目選択肢を使用していない場合は不要です。</span>
				<li>カテゴリCSV（item-cat.csv）
					<span>楽天からCSVをダウンロードする際は「カテゴリ更新フォーマットでダウンロード（全商品）」を選択してください。</span>
			</ul>
			</div>
			<p class="info">※データ取り込みに時間がかかる場合がありますが、画面を閉じずにお待ちください。</p>
			<p class="info">※取り込み処理を実行すると、前回取りこんだデータおよび変換後のデータは破棄されます。</p>
			<p class="info">※取り込み可能なCSVファイルの最大行数は10万件です。10万件を超える商品数の場合は、予めファイルを分割してください。</p>
			<p class="info">※1回に取り込めるCSVファイルはそれぞれ1つずつです。2ファイル以上ある場合は予めファイルを結合してください。</p>
		</td>
	</tr>
	

	<tr>
	<tr>
		<th><div class="memobox"><br>▼ここがコツ！▼  取込を行う前に確認してください！<br><br>
			楽天の在庫タイプ＝2（項目選択肢別在庫設定）の商品は、楽天では項目選択肢番号の登録を省略できますが、ヤフーでは入力必須なのでそのままだとエラーになってしまいます。<br>
			もし項目選択肢番号を登録していない場合は、あらかじめ登録してからストアコンバーターに取り込むことをお勧めします。<br><br>
			例）<br>
			商品管理番号＝12345、商品名＝シャツ、項目選択肢項目名＝色、項目選択肢＝白、項目選択肢番号＝WH、の場合の「WH」が、ヤフーでは必須となります。<br>&nbsp;</div></th>
	</tr>


	<tr>
		<th><div class="help_title">【有償機能】　３．ディレクトリ紐付け設定　　＞＞紐付け結果を確認します＞＞</div></th>
	</tr>
	<tr>
		<td>
			<span class="description">取り込んだデータの、楽天全商品ディレクトリIDとヤフープロダクトカテゴリとの紐付けを確認します。<br>
			自動的に紐付けは行われていますが、紐付けを変更することもできます。<br>
			また楽天に現在存在しないディレクトリIDが登録されていた場合、ヤフーのプロダクトカテゴリに自動で紐付けることができませんのでここで修正します。<br></span>
			<p class="info">※この機能は有償機能となっております。無償版ではプロダクトカテゴリIDは空欄となります。</p><br>
			<p><a href="/entry"><font color="#D23460" size=3>＞＞有償機能はこちらからお申し込みください</font></a><br></p>

		</td>
	</tr>
	<tr>
		<th><div class="help_title">４．データ変換　　＞＞楽天形式からヤフー形式に変換します＞＞</div></th>
	</tr>
	<tr>
		<td>
			<span class="description">「データ変換」をクリックして変換処理を行います。変換中は他の操作ができません。<br>
			データ変換が完了するとアカウントIDであるメールアドレスに完了通知メールが送信されます。<br>
			完了までの所要時間は、数秒から数十分が目安となります。もし数時間たっても完了通知メールが届かない場合は弊社までお問合せ下さい。</span>
		</td>
	</tr>

	<tr>
		<td>
			<h3>商品データ変換仕様</h3>
			<table class="detail">
				<tr class="detail"><th class="detail">楽天</th><th class="detail">ヤフー</th></tr>
				<tr><td class="detail">表示先カテゴリ  <font color="#d38311">item-cat.csv　カテゴリ名半角60文字</font></td><td class="detail">パス(path)  <font color="#d38311">カテゴリ名半角40文字</font></td></tr>
				<tr><td class="detail">商品名  <font color="#d38311">半角255文字</font></td><td>商品名(name)  <font color="#d38311">半角150文字　html不可</font></td></tr>
				<tr><td class="detail">商品番号または商品管理番号（商品URL）<font color="#d38311">※1</font></td><td class="detail">商品コード(code)</td></tr>
				<tr><td class="detail">項目選択肢情報  <font color="#d38311">selest.csv</font></td><td>個別商品コード(sub-code)</td></tr>
				<tr><td class="detail">表示価格</td><td class="detail">定価(original-price)</td></tr>
				<tr><td class="detail">販売価格</td><td class="detail">通常販売価格(price)</td></tr>
				<tr><td class="detail">項目選択肢情報  <font color="#d38311">selest.csv</font></td><td class="detail">オプション(options)</td></tr>
				<tr><td class="detail">PC用キャッチコピー  <font color="#d38311">半角174文字</font></td><td class="detail">キャッチコピー(headline)  <font color="#d38311">半角60文字　html不可</font></td></tr>
				<tr><td class="detail">PC用商品説明文  <font color="#d38311">半角10240文字</font></td><td class="detail">商品説明(caption)  <font color="#d38311">半角10000文字</font></td></tr>
				<tr><td class="detail">PC用販売説明文  <font color="#d38311">半角10240文字</font></td><td class="detail">フリースペース1(additional1)  <font color="#d38311">半角10000文字</font></td></tr>
				<tr><td class="detail">予約商品発売日</td><td class="detail">発売日(release-date)</td></tr>
				<tr><td class="detail">ポイント変倍率</td><td class="detail">ポイント倍率(point-code)</td></tr>
				<tr><td class="detail">販売期間指定</td><td class="detail">販売期間(sale-period-start,sale-period-end)</td></tr>
				<tr><td class="detail">カタログID</td><td class="detail">JANコード/ISBNコード(jan)</td></tr>
				<tr><td class="detail">送料</td><td class="detail">送料無料(delivery)</td></tr>
				<tr><td class="detail">全商品ディレクトリID</td><td class="detail">プロダクトカテゴリ(product-category)<font color="#d38311">※2</font></td></tr>
				<tr><td class="detail">倉庫指定</td><td class="detail">ページ公開(display)</td></tr>
				<tr><td class="detail">あす楽配送管理番号</td><td class="detail">翌日配達「あすつく」(astk-code)</td></tr>
				<tr><td class="detail">スマートフォン用商品説明文  <font color="#d38311">半角5120文字</font></td><td class="detail">スマートフォン用フリースペース(sp-additional)  <font color="#d38311">半角10000文字</font></td></tr>
			</table>
			<h3>在庫データ変換仕様</h3>
			<table class="detail">
				<tr><th class="detail">楽天</th><th class="detail">ヤフー</th></tr>
				<tr><td class="detail">商品番号または商品管理番号（商品URL）<font color="#d38311">※1</font></td><td class="detail">商品コード</td></tr>
				<tr><td class="detail">項目選択肢情報  <font color="#d38311">selest.csv</font></td><td class="detail">個別商品コード</td></tr>
				<tr><td class="detail">在庫数</td><td class="detail">在庫数</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<p class="info">※1 「商品番号」と「商品管理番号（商品URL）」のどちらをヤフーの「商品コード」にセットするかは「１．環境設定」で変更できます。既定は「商品番号」です。</p>
			<p class="info">※2 この変換は有償機能となっております。無償版では空欄となります。</p>
		</td>

	</tr>

	<tr>
		<th><div class="help_title">５．変換ログ参照　６．変換データ一括編集　　＞＞変換結果を編集します＞＞</div></th>
	</tr>
	<tr>
		<td>
			<span class="description">データ変換が完了したら「変換ログ参照」で、ヤフーの仕様に合わない箇所をチェックします。（文字数オーバー、禁止タグなど）<br>
			警告が表示されている箇所については「変換データ一括編集」で一括編集することができます。<br>
			一括編集が可能なのは以下の項目です。文字列の追加・削除・置換を全商品データに対して一括で行うことができます。</span>

			<table class="detail">
				<tr><th class="detail">一括編集可能な項目</th><th class="detail">編集のヒント</th></tr>
				<tr><td class="detail">商品名（name）</td><td class="detail">HTMLタグ削除／あす楽をあすつくに置換／文字数が長ければ部分的に削除</td></tr>
				<tr><td class="detail">パス（path）</td><td class="detail">文字数が長ければカテゴリ名を短くするとか階層を減らすとか</td></tr>
				<tr><td class="detail">オプション（options）</td><td class="detail">HTMLタグ削除／禁止文字（|;:&=#"\）及び半角空白文字は全角に変換されています</td></tr>
				<tr><td class="detail">キャッチコピー（headline）</td><td class="detail">HTMLタグ削除／文字数が長ければ部分的に削除</td></tr>
				<tr><td class="detail">商品説明（caption）</td><td class="detail">画像URLがあれば置換／文字数が長ければ部分的に削除</td></tr>
				<tr><td class="detail">ひと言コメント（abstract）</td><td class="detail">変換では何もセットしていません</td></tr>
				<tr><td class="detail">フリースペース１（additional1）</td><td class="detail">画像URLを置換<br>
				例）<br>
				＜IMG src="http://image.rakuten.co.jp/店舗URL/cabinet/aaaaa/<br>
				↓↓↓<br>
				＜IMG SRC="/lib/ストアアカウント/</td></tr>
				<tr><td class="detail">スマートフォン用フリースペース（sp-additional）</td><td class="detail">画像URLがあれば置換／文字数が長ければ部分的に削除</td></tr>
			</table>

		</td>
	</tr>
	<tr>
		<th><div class="help_title">７．ダウンロード　　＞＞編集したデータをダウンロードします＞＞</div></th>
	</tr>
	<tr>
		<td>
		<span class="description">一括編集が終わったら「変換データをダウンロード」をクリックしてCSVをダウンロードします。<br>
		ダウンロードしたCSVは「変換ログ参照」画面を参考にして必要に応じさらに個別に編集を行い、ヤフーのストアマネージャーからアップロードしてください。<br>
		</td>
	</tr>
	<tr>
		<th><div class="help_title">【有償機能】　８．FTP自動転送　　＞＞画像と商品CSVを自動転送します＞＞</div></th>
	</tr>
	<tr>
		<td>
		<div><span class="description">「変換データを転送開始」をクリックすると、商品CSVがヤフーへFTP自動転送されます。<br>
		転送が完了すると完了メールが送信されます。</div>
		</td>
	</tr>
	<tr>
		<td>
		<div><span class="description">「楽天画像を転送開始」をクリックすると、楽天に掲載している画像がヤフーへFTP自動転送されます。<br>
		商品画像（カゴ画像）はヤフーの商品コードに基づくファイル名に自動変更して転送されます。<br>
		転送が完了すると完了メールが送信されます。<br>
		画像は、楽天の商品CSVの以下項目に記述されている画像URLをもとに自動取得します。<br>
		
		</span></div>
			<table class="detail">
				<tr><th class="detail">画像取得元の項目</th><th class="detail">説明</th></tr>
				<tr><td class="detail">商品画像URL</td><td class="detail">6画像まで、商品画像としてリネームして転送されます</td></tr>
				<tr><td class="detail">PC用商品説明文</td><td class="detail">追加画像として転送されます</td></tr>
				<tr><td class="detail">PC用販売説明文</td><td class="detail">追加画像として転送されます</td></tr>
				<tr><td class="detail">スマートフォン用商品説明文</td><td class="detail">追加画像として転送されます</td></tr>
			</table>
			<p class="info">※商品数によっては、完了までに数日に渡る時間を要する場合がございます。</p>
			<p class="info">※同名のファイル名が存在する場合は最後に転送された画像で上書きされます。画像転送の順序は制御できません。</p>
			<p class="info">※トップページやカテゴリページなどの画像は取得できません。商品CSVに記述されている画像のみが対象となります。</p>
			<p class="info">※転送機能は有償機能となっており、無償版では実行できません。</p>
			<p><a href="applicate.php"><font color="#D23460" size=3>＞＞有償機能はこちらからお申し込みください</font></a><br></p>
		</td>
	</tr>
</table>

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
