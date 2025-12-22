<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') header("Location: ../auth/login.php");

$id = $_POST['id_jadwal'];
$jenis = $_POST['jenis_kegiatan'];
$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu'];
$keterangan = trim($_POST['keterangan']);

$sql = "UPDATE jadwal_kegiatan SET jenis_kegiatan='$jenis', tanggal='$tanggal', waktu='$waktu', keterangan='$keterangan' 
        WHERE id_jadwal='$id'";

if(mysqli_query($koneksi,$sql)){
    $_SESSION['success']="Jadwal berhasil diupdate!";
    header("Location: index.php");
}else{
    $_SESSION['error']="Gagal update: ".mysqli_error($koneksi);
    header("Location: edit.php?id=$id");
}