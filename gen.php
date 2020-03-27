<?php

$cid=$_GET['cid'];
$images=explode("_",substr($_GET['img'], 1) );

echo "CID , ${cid}\n" ;


$random = mt_rand(0,sizeof($images) - 1 );

echo "\n Zuffalszahl, ${random}";

require_once('db_conn.php');

if($link === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt select query execution
$imageid = mysqli_real_escape_string($link, $images[$random]);
$sql = "SELECT * FROM image where id = $imageid";

$images_result = mysqli_query($link, $sql);

var_dump($images_result);
