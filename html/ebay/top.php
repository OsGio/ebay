<?php include('header.php'); ?>
<!-- /header -->



<div id="top_img">

<h2>サービス全機能、完全無料！</h2>
<p>eBayカテゴリ変換も、ワンクリック出品も、すべて０円！</p>

</div>





<div id="content">

<div class="mainCol" style="overflow:visible;">






<p align="center"><img src="img/news.png" alt="お知らせ" /></p>

<dl class="news">


<dt>12月20日</dt>
<dd>定期メンテナンスを行いました。</dd>

<dt>12月2日</dt>
<dd>ソースコードプレビュー機能を追加しました。キーワード変換、英語辞書ページの画面左上にございます。</dd>

<dt>11月25日</dt>
<dd><a href="http://wasab.net/howto/converter/category/flow" target="_blank">コンバート出品までの流れを、「ヘルプ」にまとめました！</a></dd>

<dt>10月15日</dt>
<dd>ユーザー様ページリニューアルいたしました！「キーワード変換」に新機能もありますので、ぜひご活用くださいませ。</dd>

<dt>10月9日</dt>
<dd>キーワード変換がより柔軟になりました。</dd>

<dt>9月20日</dt>
<dd>楽天ディレクトリID→eBayカテゴリの変換を全ディレクトリに対応いたしました。</dd>

<dt>8月15日</dt>
<dd>CSV取り込み時エラー発生のため、メンテナンスを行いました。</dd>

<dt>7月25日</dt>
<dd>ファッションカテゴリー必須項目に対応し、よりスムーズに出品できるようになりました。</dd>

<dt>7月20日</dt>
<dd>楽天市場・中古タグに対応いたしました。</dd>

</dl>









<p align="center" style="margin-top:40px;"><img src="img/flow.gif" alt="流れ" /></p>


<section id="top_flow">

<div class="inner inner01">

<div class="box">
<h4><span>01</span>楽天CSVデータの取り込み</h4>
<dl>
<dt><img src="img/icon_flow_01.png"></dt>
<dd>
まずは、楽天CSVデータを楽天市場よりダウンロードし、当サイトにアップロードします。
<a href="import_data.php">ページへ移動</a>
</dd>
</dl>
</div>

<div class="box">
<h4><span>02</span>eBay出品時の項目設定</h4>
<dl>
<dt><img src="img/icon_flow_02.png"></dt>
<dd>
ドル換算、返品設定など、eBay出品の際の重要な共通項目を設定していきます。
<a href="exhibit_setting.php">ページへ移動</a>
</dd>
</dl>
</div>

<div class="box">
<h4><span>03</span>商品データ詳細設定</h4>
<dl>
<dt><img src="img/icon_flow_03.png"></dt>
<dd>
商品説明文の配置設定、楽天タグID（中古）の変換設定を行います。
<a href="sale_setting.php">ページへ移動</a>
</dd>
</dl>
</div>

</div>



<p align="center"><img src="img/arrow_under.gif" alt="↓へ" /></p>



<div class="inner inner02">

<div class="box">
<h4><span>+α</span>eBayカテゴリ変換 個別設定</h4>
<dl>
<dt><img src="img/icon_flow_0a.png"></dt>
<dd>
楽天ディレクトリID → eBayカテゴリの変換の際の個別設定を保存しておけます。
<a href="directory.php">ページへ移動</a>
</dd>
</dl>
</div>

<div class="box">
<h4><span>+α</span>キーワード変換（追加・削除・置換）</h4>
<dl>
<dt><img src="img/icon_flow_0b.png"></dt>
<dd>
タイトル・説明文に使用されている文言を削除、置き換え、および追加が行えます。
<a href="edit_keyword.php">ページへ移動</a>
</dd>
</dl>
</div>

<div class="box">
<h4><span>+α</span>英訳辞書登録</h4>
<dl>
<dt><img src="img/icon_flow_0c.png"></dt>
<dd>
eBayコンバート時の英語自動翻訳の個別辞書登録をしておけます。ネイティブな方向け。
<a href="edit_dictionary.php">ページへ移動</a>
</dd>
</dl>
</div>

</div>





<p align="center"><img src="img/arrow_under.gif" alt="↓へ" /></p>







<div class="inner inner03">

<div class="box2">
<h4><span>04</span>eBayデータへコンバート・出品</h4>
<dl>
<dt><img src="img/icon_flow_04.png"></dt>
<dd>
設定された内容を元に、コンバート（eBay用変換）します。<br>
コンバートされたeBay用商品データをそのままワンクリックで出品することもできます。<br>
もちろん、データをCSV形式でダウンロードすることも可能です。
<a href="convert.php">ページへ移動</a>
</dd>
</dl>
</div>

</div>






</section>



</div><!-- /mainCol -->

</div><!-- /content -->


<div id="footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
