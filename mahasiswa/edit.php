<?php
include "../koneksi.php";
session_start();

// Pastikan ada parameter id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['pesan'] = "⚠️ Data tidak ditemukan!";
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$data = $koneksi->query("SELECT * FROM mahasiswa WHERE id=$id")->fetch_assoc();

// Jika data tidak ditemukan
if (!$data) {
    $_SESSION['pesan'] = "❌ Data mahasiswa tidak ditemukan!";
    header("Location: index.php");
    exit;
}

// Ambil daftar jurusan
$jurusan = $koneksi->query("SELECT * FROM jurusan WHERE deleted_at IS NULL");

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = trim($_POST['nim']);
    $nama = trim($_POST['nama']);
    $umur = intval($_POST['umur']);
    $jurusan_id = intval($_POST['jurusan_id']);

    if (!empty($nim) && !empty($nama) && $umur > 0 && $jurusan_id > 0) {
        $sql = "UPDATE mahasiswa 
                SET nim='$nim', nama='$nama', umur='$umur', jurusan_id='$jurusan_id', updated_at=NOW() 
                WHERE id=$id";
        if ($koneksi->query($sql)) {
            $_SESSION['pesan'] = "✅ Data mahasiswa berhasil diperbarui!";
        } else {
            $_SESSION['pesan'] = "❌ Gagal memperbarui data!";
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
<title>Edit Mahasiswa</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
  <div class="card fade-in">
    <h2>✏️ Edit Data Mahasiswa</h2>

    <?php if (isset($_SESSION['pesan'])): ?>
      <div class="alert"><?= $_SESSION['pesan']; ?></div>
      <?php unset($_SESSION['pesan']); ?>
    <?php endif; ?>

    <form method="POST">
      <label for="nim">NIM:</label>
      <input type="text" id="nim" name="nim" value="<?= htmlspecialchars($data['nim']); ?>" required>

      <label for="nama">Nama:</label>
      <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required>

      <label for="umur">Umur:</label>
      <input type="number" id="umur" name="umur" value="<?= htmlspecialchars($data['umur']); ?>" required>

      <label for="jurusan">Jurusan:</label>
      <select id="jurusan" name="jurusan_id" required>
        <option value="">-- Pilih Jurusan --</option>
        <?php while($j = $jurusan->fetch_assoc()): ?>
          <option value="<?= $j['id'] ?>" <?= $data['jurusan_id'] == $j['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($j['nama']) ?>
          </option>
        <?php endwhile; ?>
      </select>

      <button type="submit">💾 Update Data</button>
    </form>

    <!-- Tombol kembali -->
    <a href="index.php" class="btn-back">← Kembali</a>
  </div>
</div>

<script>
// Efek fade-in halus saat halaman dimuat
document.addEventListener("DOMContentLoaded", () => {
  document.body.style.opacity = "0";
  document.body.style.transition = "opacity 0.6s ease";
  setTimeout(() => { document.body.style.opacity = "1"; }, 50);
});
</script>
</body>
</html>
