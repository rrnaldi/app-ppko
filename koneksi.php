<?php
//membuat koneksi ke database
$server = "localhost";
$user = "root";
$password = "";
$database = "ppko_V1";

//buat koneksi
$koneksi = mysqli_connect($server, $user, $password, $database) or die(mysqli_error($koneksi));
?>