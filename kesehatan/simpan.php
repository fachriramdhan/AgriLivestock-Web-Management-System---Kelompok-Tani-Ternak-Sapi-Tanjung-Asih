<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

$id_sapi = $_POST['id_sapi'];
$tanggal = $_POST['tanggal'];
$jenis = $_POST['jenis_pemeriksaan'];
$gejala = trim($_POST['gejala']);
$tindakan = $_POST['tindakan'];
$status = $_POST['status_kesehatan'];
$catatan = trim($_POST['catatan']);

// Cek data sapi
$qSapi = mysqli_query($koneksi, "SELECT * FROM sapi WHERE id_sapi='$id_sapi'");
$sapi = mysqli_fetch_assoc($qSapi);

if(!$sapi){
    $_SESSION['error']="Sapi tidak ditemukan!";
    header("Location: tambah.php"); exit;
}

if($role==='user' && $sapi['id_user']!=$id_user_session){
    $_SESSION['error']="Anda tidak berhak input data ini!";
    header("Location: tambah.php"); exit;
}

if($sapi['status_sapi']!='aktif'){
    $_SESSION['error']="Hanya sapi aktif yang bisa diperiksa!";
    header("Location: tambah.php"); exit;
}

$id_user = ($role==='admin') ? $sapi['id_user'] : $id_user_session;

$sql = "INSERT INTO kesehatan_sapi (id_sapi,id_user,tanggal,jenis_pemeriksaan,gejala,tindakan,status_kesehatan,catatan)
        VALUES ('$id_sapi','$id_user','$tanggal','$jenis','$gejala','$tindakan','$status','$catatan')";

if(mysqli_query($koneksi,$sql)){
    $_SESSION['success']="Data kesehatan berhasil disimpan!";
    header("Location: index.php");
}else{
    $_SESSION['error']="Gagal simpan: ".mysqli_error($koneksi);
    header("Location: tambah.php");
}