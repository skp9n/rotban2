<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */


// Check connection
require_once('db_conn.php');

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Select images
$sql = "SELECT * FROM image where active <> 0 ORDER BY sort ASC";
$images_result = mysqli_query($link, $sql);

// Select groups
$sql = "SELECT * FROM `group` where exists ( select * from `image` where `id_group` = `group`.`id` )";
$groups_result = mysqli_query($link, $sql);

// Close connection
mysqli_close($link);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>VATSIM Germany - ROTBAN2.0</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<div class="container ">
    <div class="row">
        <div class="col">
            <img src="assets/img/vacc_logo_white.png" class="mx-auto d-block pt-5" style="max-width: 5cm">
            <br>
            <h1 class="text-center">VATSIM Germany RotBan 2.0</h1>
            <p class="text-center">Wähle aus den folgenden vefügbaren Bannern eine beliebige Kombination und lasse dir
                einen
                Link für dein Rotban generieren.<br>
                Für die Verwendung von Online-Indicators wird deine VATSIM-ID benötigt.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <div class="container pt-5 sticky">
                <nav class="nav flex-column flex-fill border-3 rounded">

                    <a class="nav-link active font-weight-bold text-secondary" href="#">TOP</a>

                    <?php
                    while ($row = mysqli_fetch_array($groups_result)) {
                        echo '<a class="nav-link active font-weight-bold text-secondary" href="#">' . $row['description'] . '</a>';
                    }
                    ?>

                </nav>
            </div>
        </div>
        <div class="col">
            <?php
            while ($group = mysqli_fetch_array($groups_result)) {
                echo '<div class="container mt-5 justify-content-center" style="min-height: 10cm">';
                echo '<h3>' . $group['description'] . '</h3>';
                echo '<div class="table-responsive"><table class="table table-borderless w-auto"><tbody>';
                while ($image = mysqli_fetch_array($images_result)) {
                    echo '<tr>';
                    echo '<td><div class="form-check text-center">';
                    echo '<input class="form-check-input" type="checkbox" name=' . $image['id'] . ' id="img' . $image['id'] . '" value="0"><label class="form-check-label" for="formCheck-1">' . $image['description'] . '</label>';
                    echo '</div></td>';

                    if ($image['uri_preview'] == NULL or $image['uri_preview'] == "") {
                        $uri = $image['uri'];
                    } else {
                        $uri = $image['uri_preview'];
                    }

                    if ($image['cid_required'] != 0) {
                        echo '<td><img max-height="80px" max-width="400px" src="' . str_replace("\$cid", "", $uri) . '"/></td>';
                    } else {
                        echo '<td><img max-height="80px" max-width="400px" src="' . $uri . '"/></td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody> </table></div></div>';
            }
            ?>
        </div>
    </div>
</body>
