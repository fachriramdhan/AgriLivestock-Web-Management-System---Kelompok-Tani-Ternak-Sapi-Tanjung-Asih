<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

$id = $_GET['id'];

// Ambil data
$qData = mysqli_query($koneksi, "SELECT * FROM kesehatan_sapi WHERE id_kesehatan='$id'");
$data = mysqli_fetch_assoc($qData);
if(!$data){
    $_SESSION['error']="Data tidak ditemukan!";
    header("Location: index.php"); exit;
}
if($role==='user' && $data['id_user']!=$id_user_session){
    $_SESSION['error']="Anda tidak berhak menghapus data ini!";
    header("Location: index.php"); exit;
}

if(mysqli_query($koneksi, "DELETE FROM kesehatan_sapi WHERE id_kesehatan='$id'")){
    $_SESSION['success']="Data berhasil dihapus!";
}else{
    $_SESSION['error']="Gagal hapus: ".mysqli_error($koneksi);
}
header("Location: index.php");