<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$nama = $_POST['nama_anggota'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$tanggal_gabung = $_POST['tanggal_gabung'];
$status = $_POST['status_anggota'];

$sql = "INSERT INTO anggota (nama_anggota, alamat, no_hp, tanggal_gabung, status_anggota) 
        VALUES ('$nama', '$alamat', '$no_hp', '$tanggal_gabung', '$status')";

if(mysqli_query($koneksi, $sql)){
    $_SESSION['success'] = "Anggota berhasil ditambahkan!";
} else {
    $_SESSION['error'] = "Gagal: ".mysqli_error($koneksi);
}
header("Location: index.php");