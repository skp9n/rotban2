<?php

$url="https://rotban2.vatsim-germany.org/gen.php?";

foreach ($_POST as $key => $value) {
    // $arr[3] wird mit jedem Wert von $arr aktualisiert...

    if( $key == "cid" and $vale != ""){
      $url=$url . "cid=" . $value;
    }
    else {
      $url=$url . "_" . $key;
    }
}

echo $url;
