<?php
include "../koneksi.php";
session_start();
$id = $_GET['id'];
$koneksi->query("UPDATE jurusan SET deleted_at=NOW() WHERE id=$id");
$_SESSION['pesan'] = "❌ Jurusan dihapus!";
header("Location: index.php");
exit;
?>
