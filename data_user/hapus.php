<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') header("Location: ../auth/login.php");

$id = $_GET['id'];
if(mysqli_query($koneksi,"DELETE FROM user WHERE id_user='$id'")){
    $_SESSION['success']="User berhasil dihapus!";
}else{
    $_SESSION['error']="Gagal hapus: ".mysqli_error($koneksi);
}
header("Location: index.php");