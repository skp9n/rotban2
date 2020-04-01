<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */


// Check connection
require_once('db_conn.php');

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Select images
$sql = "SELECT * FROM image where active <> 0 ORDER BY id_group ASC, sort ASC";
$images_result = mysqli_query($link, $sql);
$images = mysqli_fetch_all($images_result, MYSQLI_ASSOC);


// Select groups
$sql = "SELECT * FROM `group` where exists ( select * from `image` where `id_group` = `group`.`id` ) ORDER BY sort ASC";
$groups_result = mysqli_query($link, $sql);
$groups = mysqli_fetch_all($groups_result, MYSQLI_ASSOC);


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
<form id="rotban_form">
    <div class="container">
        <div class="row">
            <div class="col" name="top">
                <img src="assets/img/vacc_logo_white.png" class="mx-auto d-block pt-5" style="max-width: 5cm">
                <br>
                <h1 class="text-center">VATSIM Germany RotBan 2.0</h1>
                <p class="text-center">Wähle aus den folgenden vefügbaren Bannern eine beliebige Kombination und lasse
                    dir einen Link für dein Rotban generieren.<br>
                    Für die Verwendung von Online-Indicators wird deine VATSIM-ID benötigt.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <div class="container pt-5 sticky">
                    <nav class="nav flex-column flex-fill border-3 rounded">

                        <a class="nav-link active font-weight-bold text-vatger-secondary" href="#top">TOP</a>

                        <?php
                        foreach ($groups as $group) {
                            echo '<a class="nav-link active font-weight-bold text-vatger-secondary" href="#' . $group['id'] . '">' . $group['description'] . '</a>';
                        }
                        ?>
                        <a class="nav-link active font-weight-bold text-success" href="#gen">Generieren</a>
                    </nav>
                </div>
            </div>
            <div class="col">
                <?php
                foreach ($groups as $group) {
                    echo '<div class="container mt-5 justify-content-center" name="' . $group['id'] . '">';
                    echo '<h3>' . $group['description'] . '</h3>';
                    echo '<div class="container ml-5">';
                    foreach ($images as $image) {
                        if ($image['id_group'] == $group['id']) {
                            echo '<div class="row mt-2">';
                            echo '<div class="col-2"><div class="form-check">';
                            echo '<input class="form-check-input" type="checkbox" name=' . $image['id'] . ' id="img' . $image['id'] . '" value="0"><label class="form-check-label font-weight-bold text-vatger-secondary" for="formCheck-1">' . $image['description'] . '</label>';
                            echo '</div></div>';

                            if ($image['uri_preview'] == NULL or $image['uri_preview'] == "") {
                                $uri = $image['uri'];
                            } else {
                                $uri = $image['uri_preview'];
                            }

                            if ($image['cid_required'] != 0) {
                                echo '<div class="col"><img max-height="80px" max-width="400px" src="' . str_replace("\$cid", "", $uri) . '"/></div>';
                            } else {
                                echo '<div class="col"><img max-height="80px" max-width="400px" src="' . $uri . '"/></div>';
                            }
                            echo '</div>';
                        }
                    }
                    echo '</div></div>';
                }
                ?>
            </div>
        </div>
        <div class="row align-items-center justify-content-center" name="gen">
            <div class="col-3 justify-content-center align-items-center text-center">
                <input class="form-control mt-3 text-center" type="text" id="cid" name="cid" value=""
                       placeholder="VATSIM-ID"
                       inputmode="numeric" minlength="6" maxlength="7">
                <button class="btn btn-success btn-lg mt-3" type="submit">Rotbanlink generieren</button>
            </div>
        </div>
</form>
<div class="modal fade" role="dialog" tabindex="-1" id="LinkModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-success">Generierung erfolgreich</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body text-center">
                <p class="text-dark">Dies ist dein generierter Rotban Link.</p>
                <input class="w-100" name="rotban_url" id="rotban_url" readonly></div>
            <div class="modal-footer">
                <button onclick="copyToClipboard('#rotban_url')" class="btn btn-primary" type="button">In Zwischenablage
                    kopieren
                </button>
                <button class="btn btn-light" type="button" data-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>
</body>
<footer>
    <div class="container pt-10">
        <p class="text-sm-center">
            Service provided by VATSIM-Germany<br>
            Mail: events (at) vatsim-germany.org<br>
            Developed by Paul Hollmann, Sebastian Kramer, Sebastian Klietz.
        </p>
    </div>
</footer>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script type="text/javascript">$(document).ready(function () {
        $('#rotban_form').submit(function (event) {
            event.preventDefault();
            $.post("./create_url.php", $("#rotban_form").serializeArray()).done(function (data) {
                $("#rotban_url").attr("value", data);
                $('#LinkModal').modal('show');
            });
            ;
        });
    });

    function copyToClipboard(element) {
        var copyText = document.getElementById("rotban_url");
        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/
        /* Copy the text inside the text field */
        document.execCommand("copy");
        /* Alert the copied text */
        //alert("Copied the text: " + copyText.value);
    }


</script>
</html>

