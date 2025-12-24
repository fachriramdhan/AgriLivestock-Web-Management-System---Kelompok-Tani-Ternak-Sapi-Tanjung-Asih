<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$id = $_GET['id'];
if(mysqli_query($koneksi,"DELETE FROM anggota WHERE id_anggota='$id'")){
    $_SESSION['success']="Anggota berhasil dihapus!";
}else{
    $_SESSION['error']="Gagal hapus: ".mysqli_error($koneksi);
}
header("Location: index.php");