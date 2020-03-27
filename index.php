<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "rotban", "KYNfRWbKbTiMHEJW", "rotban");

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt select query execution
$sql = "SELECT * FROM image where active <> 0";
$images_result = mysqli_query($link, $sql);

// Close connection
mysqli_close($link); ?>

<!DOCTYPE html>
<html style="color: #2b3089;background-color: #2b3089;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>ROTBAN2.0</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="background-color: #2b3089;color: #b9b8b8;">
    <h1 class="text-center" style="font-family: 'PT Sans', sans-serif;background-color: #2b3089;color: #b9b8b8;padding: 30px;">VATSIM Germany Rotban 2.0</h1>
    <p class="text-center" style="font-family: 'PT Sans', sans-serif;color: #b9b8b8;padding: 0px;padding-right: 50px;padding-left: 50px;">Wähle aus den folgenden vefügbaren Bannern eine beliebige Kombination und lasse dir einen Link für dein Rotban generieren. Für die Verwendung von Online-Indicators wird deine VATSIM-ID benötigt.</p>
    <div class="text-center"><input type="text" name="id" placeholder="VATSIM-ID" inputmode="numeric" style="font-family: 'PT Sans', sans-serif;" minlength="6" maxlength="7"></div>
    <div class="table-responsive table-borderless" style="align-items: center;margin: auto;">
        <table class="table-responsive table-borderless" style="align-items: center;margin: auto;width: 100%;">
            <thead>
                <tr>
                    <th style="font-family: 'PT Sans', sans-serif;color: #b9b8b8;">Auswahl</th>
                </tr>
            </thead>
            <tbody>

<?php
  if(mysqli_num_rows($images_result) > 0){
    while($row = mysqli_fetch_array($images_result)){
      echo "<tr>";
        echo '<td style="color: #b9b8b8;padding:1cm; width: 10%;"><div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" data-toggle="tooltip" data-bs-tooltip="" data-placement="right" for="formCheck-1">' . $row['description'] . '</label></div></td>';
        echo '<td><img max-height="80px" max-width="400px" src="' . $row['uri'] . '"/></td>';
      echo "</tr>";
     }
     echo "</table>";
    // Free result set
    mysqli_free_result($images_result);
    }

?>
        </tbody>
        </table>
    </div>
    <div class="text-break text-center"><button class="btn btn-primary" type="submit" style="font-family: 'PT Sans', sans-serif;">Rotbanlink generieren</button></div>
    <footer class="text-center" style="padding: 40px;"><img class="img-fluid" src="assets/img/vacc_logo_white.png" style="width: 400px;" /></footer>
    <div class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-success">Generierung erfolgreich</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p class="text-dark">Dies ist dein generierter Rotban Link. Er wurde bereits in die Zwischenablage kopiert</p><input type="url" style="width: 100%;font-family: 'PT Sans', sans-serif;" name="rotban_url"></div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">OK</button></div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>
