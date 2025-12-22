<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

$id = $_POST['id_olahan'];
$id_user = ($role==='admin') ? $_POST['id_user'] : $id_user_session;
$tanggal = $_POST['tanggal'];
$jenis = $_POST['jenis_olahan'];
$bahan = $_POST['bahan_baku_liter'];
$hasil = $_POST['jumlah_hasil'];
$status = $_POST['status_produksi'];
$keterangan = trim($_POST['keterangan']);

// Cek data lama
$qData = mysqli_query($koneksi,"SELECT * FROM produksi_olahan WHERE id_olahan='$id'");
$data = mysqli_fetch_assoc($qData);
if(!$data){
    $_SESSION['error']="Data tidak ditemukan!";
    header("Location: index.php"); exit;
}
if($role==='user' && $data['id_user']!=$id_user_session){
    $_SESSION['error']="Anda tidak berhak update data ini!";
    header("Location: index.php"); exit;
}

$sql = "UPDATE produksi_olahan SET id_user='$id_user', tanggal='$tanggal', jenis_olahan='$jenis',
        bahan_baku_liter='$bahan', jumlah_hasil='$hasil', status_produksi='$status', keterangan='$keterangan'
        WHERE id_olahan='$id'";

if(mysqli_query($koneksi,$sql)){
    $_SESSION['success']="Data berhasil diupdate!";
    header("Location: index.php");
}else{
    $_SESSION['error']="Gagal update: ".mysqli_error($koneksi);
    header("Location: edit.php?id=$id");
}