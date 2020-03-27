<?php

$cid=$_GET['cid'];
$images=explode(substr($_GET['img'], 1), "_");
echo "CID , ${cid}";
var_dump($images);
