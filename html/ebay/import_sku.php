<?php
ini_set('display_errors', 1);

if(isset($_GET) && $_GET["exec"]==4)
{
    $files = $_FILES;
    $posts = $_POST;
    $path = $files['sku']['tmp_name'];
    $file = file_get_contents($path, 'r');
    $file = mb_convert_encoding($file, 'utf-8', 'sjis');
    $rows = explode("\n", $file);
    foreach($rows as $r)
    {
        $contents[] = explode(',', $r);
    }

    // $contents = explode(',', $file);
var_dump($contents);exit;
}
else
{
	header("Location: http://".$_SERVER["HTTP_HOST"]."/ebay/directory.php");
    print 0;
    exit;

}


?>
