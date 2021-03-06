<?php

$cid = $_GET['cid'];
$images = explode("_", substr($_GET['img'], 1));

if ($cid == NULL)
    $cid = "";

$random = mt_rand(0, sizeof($images) - 1);

$log = "Random: ${random}\n";
file_put_contents('./images.log', $log, FILE_APPEND);

require_once('db_conn.php');

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt select query execution
$imageid = mysqli_real_escape_string($link, $images[$random]);
$sql = "SELECT `cid_required`, `uri` FROM image where id = $imageid and active = 1";
$images_result = mysqli_query($link, $sql);

// Close connection
mysqli_close($link);

if (mysqli_num_rows($images_result) > 0) {
    while ($row = mysqli_fetch_array($images_result)) {
        if ($row['cid_required'] != 0 AND $cid == "") {
            $uri = "images/error_cid.png";
        } else {
            $uri = str_replace("\$cid", urlencode($cid), $row['uri']);
        }
        break;
    }
} else {
    $uri = "images/error_code.png";
}

$mime = getimagesize($uri)['mime'];
header("Content-type: " . $mime);
readfile($uri);

mysqli_free_result($images_result);