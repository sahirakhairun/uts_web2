<?php
include "../koneksi.php";
session_start();

$id = $_GET['id'];
$data = $koneksi->query("SELECT * FROM jurusan WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $koneksi->query("UPDATE jurusan SET nama='$nama', updated_at=NOW() WHERE id=$id");
    $_SESSION['pesan'] = "✅ Data jurusan diperbarui!";
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Jurusan</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
  <div class="card fade-in">
    <h2>✏️ Edit Jurusan</h2>
    <form method="POST">
      <input type="text" name="nama" value="<?= $data['nama']; ?>" required>
      <button type="submit">Update</button>
    </form>

    <!-- Tombol kembali -->
    <a href="index.php" class="btn-back">← Kembali</a>
  </div>
</div>

<script>
  // Efek fade-in halaman
  document.addEventListener("DOMContentLoaded", () => {
    document.body.style.opacity = "0";
    document.body.style.transition = "opacity 0.6s ease";
    setTimeout(() => { document.body.style.opacity = "1"; }, 50);
  });
</script>
</body>
</html>
