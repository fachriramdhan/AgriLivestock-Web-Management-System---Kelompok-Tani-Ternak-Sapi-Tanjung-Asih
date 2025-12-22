<?php
$host = "localhost";
$user = "root";
$pass = "root"; // default MAMP
$db   = "db_kelompok_tani";
$port = 3306;   // MySQL port MAMP

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}