<?php

$cid=$_GET['cid'];
$images=explode("_",substr($_GET['img'], 1) );

echo "CID , ${cid}";
var_dump($images);
