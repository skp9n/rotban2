<?php

//$cid=$_GET['cid'];
//$images=explode("_",substr($_GET['img'], 1) );

$cid = "1331358";
$images = explode("_", substr("_1_2_3_4_5_6", 1));

$random = mt_rand(0, sizeof($images) - 1);

require_once('db_conn.php');

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt select query execution
$imageid = mysqli_real_escape_string($link, $images[$random]);
$sql = "SELECT `cid_required`, `uri` FROM image where id = $imageid";
$images_result = mysqli_query($link, $sql);

// Close connection
mysqli_close($link);

if (mysqli_num_rows($images_result) > 0) {
    while ($row = mysqli_fetch_array($images_result)) {
        //echo $row['uri'];
        $uri = str_replace("\$cid", urlencode($cid), $row['uri']);

        $imginfo = getimagesize($uri);
        header("Content-type: " . $imginfo['mime']);
        readfile($uri);
    }  // Free result se
} else {
    // code...
}
mysqli_free_result($images_result);
