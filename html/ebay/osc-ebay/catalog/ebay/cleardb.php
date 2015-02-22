<?php
require_once('class/configure.php');
 $connection=mysql_connect (DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD) or die ('cannot connect:  ' .mysql_error());
  if($connection ==true)
  echo "connected to database host: " . DB_SERVER."<br>";
  else
  echo "could not connect to database host"."<br>";
  mysql_select_db (DB_DATABASE);
  echo "selected database:" . DB_DATABASE."<br>";
  echo "<br>";
$sql = "TRUNCATE TABLE `products`";
echo "empty products: ";
$query=mysql_query($sql) or die ('cannot empty table: ' .mysql_error());
if($query==true)
echo "success<br>";
else
echo "fail<br>";

$sql = "TRUNCATE TABLE `products_description`";
echo "empty product descriptions: ";
$query=mysql_query($sql) or die ('cannot empty table: ' .mysql_error());
if($query==true)
echo "success<br>";
else
echo "fail<br>";

$sql = "TRUNCATE TABLE `products_to_categories`";
echo "empty product 2 catagories: ";
$query=mysql_query($sql) or die ('cannot empty table: ' .mysql_error());
if($query==true)
echo "success<br>";
else
echo "fail<br>";
mysql_close($connection);
echo "<br>disconnected from database host: " . DB_SERVER."<br>";
?>
