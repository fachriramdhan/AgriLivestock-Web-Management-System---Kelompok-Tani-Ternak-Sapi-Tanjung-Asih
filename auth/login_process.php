<?php
session_start();
require_once '../config/database.php';

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password'];

// Ambil data user
$query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: login.php?error=Username tidak ditemukan");
    exit;
}

$user = mysqli_fetch_assoc($result);

// Cek status akun
if ($user['status_akun'] != 'aktif') {
    header("Location: login.php?error=Akun tidak aktif");
    exit;
}

// Cek password
if (!password_verify($password, $user['password'])) {
    header("Location: login.php?error=Password salah");
    exit;
}

// SET SESSION
$_SESSION['login']  = true;
$_SESSION['id_user'] = $user['id_user'];
$_SESSION['role']   = $user['role'];
$_SESSION['username'] = $user['username'];

// Redirect sesuai role
if ($user['role'] == 'admin') {
    header("Location: ../admin/dashboard.php");
} else {
    header("Location: ../user/dashboard.php");
}
exit;