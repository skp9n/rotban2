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
mysqli_close($link); ?>

<!DOCTYPE html>
<html style="color: #2b3089;background-color: #2b3089;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>VATSIM Germany - ROTBAN2.0</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<div class="sidenav">
    <a href="#">About</a>
    <a href="#">Services</a>
    <a href="#">Clients</a>
    <a href="#">Contact</a>
</div>
<body style="background-color: #2b3089;color: #b9b8b8">
<div class="container">
    <img src="assets/img/vacc_logo_white.png" class="mx-auto d-block pt-5" style="max-width: 5cm">
    <br>
    <h1 class="text-center">VATSIM Germany RotBan 2.0</h1>
    <p class="text-center">Wähle aus den folgenden vefügbaren Bannern eine beliebige Kombination und lasse dir einen
        Link für dein Rotban generieren.<br>
        Für die Verwendung von Online-Indicators wird deine VATSIM-ID benötigt.</p>
</div>
</body>
