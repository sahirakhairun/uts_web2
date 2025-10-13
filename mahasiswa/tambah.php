<?php
include "../koneksi.php";
session_start();

// Ambil daftar jurusan untuk dropdown
$jurusan = $koneksi->query("SELECT * FROM jurusan WHERE deleted_at IS NULL");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = trim($_POST['nim']);
    $nama = trim($_POST['nama']);
    $umur = intval($_POST['umur']);
    $jurusan_id = intval($_POST['jurusan_id']);

    if (!empty($nim) && !empty($nama) && $umur > 0 && $jurusan_id > 0) {
        // Simpan data mahasiswa baru
        $sql = "INSERT INTO mahasiswa (nim, nama, umur, jurusan_id, created_at)
                VALUES ('$nim', '$nama', '$umur', '$jurusan_id', NOW())";

        if ($koneksi->query($sql)) {
            $_SESSION['pesan'] = "✅ Mahasiswa berhasil ditambahkan!";
        } else {
            $_SESSION['pesan'] = "❌ Gagal menambahkan mahasiswa!";
        }

        header("Location: index.php");
        exit;
    } else {
        $_SESSION['pesan'] = "⚠️ Lengkapi semua data dengan benar!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Mahasiswa</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
  <div class="card fade-in">
    <h2>➕ Tambah Mahasiswa</h2>

    <?php if (isset($_SESSION['pesan'])): ?>
      <div class="alert"><?= $_SESSION['pesan']; ?></div>
      <?php unset($_SESSION['pesan']); ?>
    <?php endif; ?>

    <form method="POST">
      <label for="nim">NIM:</label>
      <input type="text" id="nim" name="nim" placeholder="Masukkan NIM" required>

      <label for="nama">Nama:</label>
      <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" required>

      <label for="umur">Umur:</label>
      <input type="number" id="umur" name="umur" placeholder="Masukkan Umur" required>

      <label for="jurusan">Jurusan:</label>
      <select id="jurusan" name="jurusan_id" required>
        <option value="">-- Pilih Jurusan --</option>
        <?php while($j = $jurusan->fetch_assoc()): ?>
          <option value="<?= $j['id'] ?>"><?= htmlspecialchars($j['nama']) ?></option>
        <?php endwhile; ?>
      </select>

      <button type="submit">💾 Simpan Mahasiswa</button>
    </form>

    <a href="index.php" class="btn-back">← Kembali</a>
  </div>
</div>

<script>
// Efek fade-in halus untuk tampilan form
document.addEventListener("DOMContentLoaded", () => {
  document.body.style.opacity = "0";
  document.body.style.transition = "opacity 0.6s ease";
  setTimeout(() => { document.body.style.opacity = "1"; }, 50);
});
</script>
</body>
</html>
