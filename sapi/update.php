<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil POST
$id_sapi        = $_POST['id_sapi'];
$kode_sapi      = trim($_POST['kode_sapi']);
$nama_sapi      = trim($_POST['nama_sapi']);
$jenis_kelamin  = $_POST['jenis_kelamin'];
$kategori_sapi  = $_POST['kategori_sapi'];
$umur_bulan     = (int) $_POST['umur_bulan'];
$status_sapi    = $_POST['status_sapi'];

// Ambil data lama
$qOld = mysqli_query($koneksi, "SELECT * FROM sapi WHERE id_sapi='$id_sapi'");
$old = mysqli_fetch_assoc($qOld);

if (!$old) {
    $_SESSION['error'] = "Data sapi tidak ditemukan!";
    header("Location: index.php");
    exit;
}

// Validasi role user: hanya bisa edit sapi miliknya
if ($role === 'user' && $old['id_user'] != $id_user_session) {
    $_SESSION['error'] = "Anda tidak memiliki akses untuk mengedit sapi ini!";
    header("Location: index.php");
    exit;
}

// Tentukan id_user
$id_user = ($role === 'admin') ? $_POST['id_user'] : $old['id_user'];

// Validasi kode unik (kecuali kode lama)
$qCek = mysqli_query($koneksi, "SELECT * FROM sapi WHERE kode_sapi='$kode_sapi' AND id_sapi != '$id_sapi'");
if (mysqli_num_rows($qCek) > 0) {
    $_SESSION['error'] = "Kode sapi sudah digunakan!";
    header("Location: edit.php?id=$id_sapi");
    exit;
}

// Update database
$sql = "UPDATE sapi SET
        id_user='$id_user',
        kode_sapi='$kode_sapi',
        nama_sapi='$nama_sapi',
        jenis_kelamin='$jenis_kelamin',
        kategori_sapi='$kategori_sapi',
        umur_bulan='$umur_bulan',
        status_sapi='$status_sapi'
        WHERE id_sapi='$id_sapi'";

if (mysqli_query($koneksi, $sql)) {
    $_SESSION['success'] = "Data sapi berhasil diupdate!";
    header("Location: index.php");
    exit;
} else {
    $_SESSION['error'] = "Gagal update: ".mysqli_error($koneksi);
    header("Location: edit.php?id=$id_sapi");
    exit;
}