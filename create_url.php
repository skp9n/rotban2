<?php

$url="https://rotban2.vatsim-germany.org/gen.php";

$cid = $_POST['cid'];

$url = $url . "?img=";

foreach ($_POST as $key => $value) {
    // $arr[3] wird mit jedem Wert von $arr aktualisiert...

    if (strpos($key, "img")) {
        $url = $url . "_" . $key;
    }
}

if($cid != null){
  $url=$url . "&cid=" . $cid;
}

echo $url;
