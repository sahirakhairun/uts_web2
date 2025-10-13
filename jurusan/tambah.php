<?php
include "../koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    if (!empty($nama)) {
        $koneksi->query("INSERT INTO jurusan (nama) VALUES ('$nama')");
        $_SESSION['pesan'] = "✅ Jurusan berhasil ditambahkan!";
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Jurusan</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
<div class="card">
    <h2>Tambah Jurusan</h2>
    <form method="POST">
        <input type="text" name="nama" placeholder="Nama Jurusan" required>
        <button type="submit">Simpan</button>
    </form>
    <a href="index.php" class="btn-back">← Kembali</a>
</div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    document.body.style.opacity = "0";
    document.body.style.transition = "opacity 0.6s ease";
    setTimeout(() => { document.body.style.opacity = "1"; }, 50);
  });
</script>

</body>
</html>
