<?php
session_start();
require_once '../config/database.php';
require '../vendor/autoload.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];

$jenis = $_GET['jenis'];
$tgl_awal = $_GET['tgl_awal'];
$tgl_akhir = $_GET['tgl_akhir'];

require('../vendor/setasign/fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,"Laporan: $jenis",0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,"Periode: $tgl_awal s/d $tgl_akhir",0,1,'C');
$pdf->Ln(5);

// Query data (sama seperti tampil_laporan.php)
switch($jenis){
    case 'produksi_susu':
        $sql = ($role==='admin') ?
            "SELECT p.*, s.nama_sapi, u.username FROM produksi_susu p 
             JOIN sapi s ON p.id_sapi=s.id_sapi 
             JOIN user u ON p.id_user=u.id_user
             WHERE p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.tanggal" :
            "SELECT p.*, s.nama_sapi FROM produksi_susu p 
             JOIN sapi s ON p.id_sapi=s.id_sapi
             WHERE p.id_user='$id_user' AND p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
             ORDER BY p.tanggal";
        $header = ['Tanggal','Peternak','Nama Sapi','Jumlah','Waktu','Status'];
        break;
    // Tambahkan case lain jika ingin export PDF untuk semua jenis laporan
    default:
        die("Jenis laporan tidak valid untuk PDF");
}

$qData = mysqli_query($koneksi,$sql);

// Header tabel
$pdf->SetFont('Arial','B',10);
foreach($header as $col){
    $pdf->Cell(30,7,$col,1);
}
$pdf->Ln();

// Data
$pdf->SetFont('Arial','',10);
while($row=mysqli_fetch_assoc($qData)){
    $pdf->Cell(30,6,$row['tanggal'],1);
    $pdf->Cell(30,6,$row['username'] ?? '',1);
    $pdf->Cell(30,6,$row['nama_sapi'],1);
    $pdf->Cell(30,6,$row['jumlah_liter'],1);
    $pdf->Cell(30,6,$row['waktu_pemerahan'],1);
    $pdf->Cell(30,6,$row['status_data'],1);
    $pdf->Ln();
}

$pdf->Output('D',"Laporan_$jenis.pdf");