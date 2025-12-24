<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$id = $_POST['id_anggota'];
$nama = $_POST['nama_anggota'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$tanggal_gabung = $_POST['tanggal_gabung'];
$status = $_POST['status_anggota'];

$sql = "UPDATE anggota SET 
            nama_anggota='$nama',
            alamat='$alamat',
            no_hp='$no_hp',
            tanggal_gabung='$tanggal_gabung',
            status_anggota='$status'
        WHERE id_anggota='$id'";

if(mysqli_query($koneksi, $sql)){
    $_SESSION['success']="Data anggota berhasil diupdate!";
}else{
    $_SESSION['error']="Gagal update: ".mysqli_error($koneksi);
}
header("Location: index.php");