<?php
include "../koneksi.php";
session_start();
$id = $_GET['id'];
$koneksi->query("UPDATE mahasiswa SET deleted_at=NOW() WHERE id=$id");
$_SESSION['pesan'] = "❌ Data mahasiswa dihapus!";
header("Location: index.php");
exit;
?>
