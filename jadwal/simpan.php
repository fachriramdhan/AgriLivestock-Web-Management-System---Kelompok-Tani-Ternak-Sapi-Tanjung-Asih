<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') header("Location: ../auth/login.php");

$jenis = $_POST['jenis_kegiatan'];
$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu'];
$keterangan = trim($_POST['keterangan']);
$id_user = $_SESSION['id_user'];

$sql = "INSERT INTO jadwal_kegiatan (dibuat_oleh, jenis_kegiatan, tanggal, waktu, keterangan)
        VALUES ('$id_user','$jenis','$tanggal','$waktu','$keterangan')";

if(mysqli_query($koneksi,$sql)){
    $_SESSION['success']="Jadwal berhasil ditambahkan!";
    header("Location: index.php");
}else{
    $_SESSION['error']="Gagal simpan: ".mysqli_error($koneksi);
    header("Location: tambah.php");
}
?>