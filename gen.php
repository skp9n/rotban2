<?php

$cid=$_GET['cid'];
$images=explode("_",substr($_GET['img'], 1) );

echo "CID , ${cid}\n" ;
var_dump($images);

$random = mt_rand(0,sizeof($images - 1);

echo "\n Zuffalszahl, ${random}";
