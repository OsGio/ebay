<?php
ini_set('display_errors', 1);

require('common/SKU.php');

if(isset($_GET) && $_GET["exec"]==4)
{
    $files = $_FILES;
    $posts = $_POST;
    $path = $files['sku']['tmp_name'];
    $file = file_get_contents($path, 'r');
    $file = mb_convert_encoding($file, 'utf-8', 'sjis');

    //行単位に分割
    $rows = explode("\n", $file);

    // SKU専用クラスを生成
    $sku = new SKU;
    //改行補正＆抽出
    $val = $sku->releaseN($rows);
    $result = $sku->castVal($val);
    //マスターレコードの生成
    $master = $sku->createMaster($result);
    //DBへ保存
    $sku->importSku($result);






    $contents = array_walk_recursive($rows, function($rows){
        $contents[] = explode(',', $rows);
        return $contents;
    });
    var_dump($contents);exit;
    array_pop($contents);

var_dump($result);exit;
}
else
{
	header("Location: http://".$_SERVER["HTTP_HOST"]."/ebay/directory.php");
    print 0;
    exit;

}


?>
