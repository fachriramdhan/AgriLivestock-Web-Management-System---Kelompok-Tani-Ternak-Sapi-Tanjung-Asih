<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') header("Location: ../auth/login.php");

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];
$status = $_POST['status_akun'];
$id_anggota = $_POST['id_anggota'] ?: NULL;

$sql = "INSERT INTO user (username, password, role, status_akun, id_anggota)
        VALUES ('$username', '$password', '$role', '$status', ".($id_anggota ? $id_anggota : "NULL").")";

if(mysqli_query($koneksi,$sql)){
    $_SESSION['success']="User berhasil ditambahkan!";
}else{
    $_SESSION['error']="Gagal tambah user: ".mysqli_error($koneksi);
}
header("Location: index.php");