<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

$id = $_POST['id_kesehatan'];
$id_sapi = $_POST['id_sapi'];
$tanggal = $_POST['tanggal'];
$jenis = $_POST['jenis_pemeriksaan'];
$gejala = trim($_POST['gejala']);
$tindakan = $_POST['tindakan'];
$status = $_POST['status_kesehatan'];
$catatan = trim($_POST['catatan']);

// Ambil data lama
$qData = mysqli_query($koneksi, "SELECT * FROM kesehatan_sapi WHERE id_kesehatan='$id'");
$data = mysqli_fetch_assoc($qData);
if(!$data){
    $_SESSION['error']="Data tidak ditemukan!";
    header("Location: index.php"); exit;
}
if($role==='user' && $data['id_user']!=$id_user_session){
    $_SESSION['error']="Anda tidak berhak update data ini!";
    header("Location: index.php"); exit;
}

// Ambil data sapi
$qSapi = mysqli_query($koneksi, "SELECT * FROM sapi WHERE id_sapi='$id_sapi'");
$sapi = mysqli_fetch_assoc($qSapi);
if(!$sapi){
    $_SESSION['error']="Sapi tidak ditemukan!";
    header("Location: edit.php?id=$id"); exit;
}

if($role==='user' && $sapi['id_user']!=$id_user_session){
    $_SESSION['error']="Anda tidak berhak memilih sapi ini!";
    header("Location: edit.php?id=$id"); exit;
}

if($sapi['status_sapi']!='aktif'){
    $_SESSION['error']="Hanya sapi aktif yang bisa diperiksa!";
    header("Location: edit.php?id=$id"); exit;
}

$id_user = ($role==='admin')?$sapi['id_user']:$id_user_session;

$sql = "UPDATE kesehatan_sapi SET id_sapi='$id_sapi', id_user='$id_user', tanggal='$tanggal', 
        jenis_pemeriksaan='$jenis', gejala='$gejala', tindakan='$tindakan', 
        status_kesehatan='$status', catatan='$catatan' WHERE id_kesehatan='$id'";

if(mysqli_query($koneksi,$sql)){
    $_SESSION['success']="Data berhasil diupdate!";
    header("Location: index.php");
}else{
    $_SESSION['error']="Gagal update: ".mysqli_error($koneksi);
    header("Location: edit.php?id=$id");
}