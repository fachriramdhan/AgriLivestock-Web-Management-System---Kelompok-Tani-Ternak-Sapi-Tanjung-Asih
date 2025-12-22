<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

$id_user = ($role==='admin') ? $_POST['id_user'] : $id_user_session;
$tanggal = $_POST['tanggal'];
$jenis = $_POST['jenis_olahan'];
$bahan = $_POST['bahan_baku_liter'];
$hasil = $_POST['jumlah_hasil'];
$status = $_POST['status_produksi'];
$keterangan = trim($_POST['keterangan']);

$sql = "INSERT INTO produksi_olahan (id_user,tanggal,jenis_olahan,bahan_baku_liter,jumlah_hasil,status_produksi,keterangan)
        VALUES ('$id_user','$tanggal','$jenis','$bahan','$hasil','$status','$keterangan')";

if(mysqli_query($koneksi,$sql)){
    $_SESSION['success']="Data berhasil disimpan!";
    header("Location: index.php");
}else{
    $_SESSION['error']="Gagal simpan: ".mysqli_error($koneksi);
    header("Location: tambah.php");
}