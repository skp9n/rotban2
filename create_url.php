<?php

$url="https://rotban2.vatsim-germany.org/gen.php";

$cid = $_POST['cid'];

if($cid != null){
  $url=$url . "&cid=" . $cid;
}

$url = $url . "&img=";

foreach ($_POST as $key => $value) {
    // $arr[3] wird mit jedem Wert von $arr aktualisiert...

    if( $key != "cid"){
        $url=$url . "_" . $key;
    }
}

echo $url;
