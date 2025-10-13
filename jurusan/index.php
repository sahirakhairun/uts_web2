<?php
include "../koneksi.php";
session_start();

$data = $koneksi->query("SELECT * FROM jurusan WHERE deleted_at IS NULL ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Jurusan</title>
<link rel="stylesheet" href="../assets/style.css">
<style>
/* Tambahan efek animasi hilang */
.fade-out {
  opacity: 0;
  transform: scale(0.98);
  transition: all 0.6s ease;
}
</style>
</head>
<body>
<div class="container">
  <div class="card fade-in">
    <h2>📘 Data Jurusan</h2>

    <?php if (isset($_SESSION['pesan'])): ?>
      <div id="alertBox" class="alert"><?= $_SESSION['pesan']; ?></div>
      <?php unset($_SESSION['pesan']); ?>
    <?php endif; ?>

    <!-- Tombol di bagian atas -->
    <div class="action-bar">
      <a href="tambah.php" class="btn">+ Tambah Jurusan</a>
      <a href="../index.php" class="btn">🏠 Dashboard</a>
    </div>

    <!-- Tabel Data Jurusan -->
    <table id="dataTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Jurusan</th>
          <th>Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        if ($data->num_rows > 0) {
          while ($row = $data->fetch_assoc()) {
            echo "<tr class='row-animate' data-id='{$row['id']}'>
                    <td>$no</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['created_at']}</td>
                    <td class='aksi-btns'>
                      <a href='edit.php?id={$row['id']}' class='btn-action edit'>Edit</a>
                      <a href='#' class='btn-action delete' data-id='{$row['id']}'>Hapus</a>
                    </td>
                  </tr>";
            $no++;
          }
        } else {
          echo "<tr><td colspan='4'>Belum ada data</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  // === Efek fade-in untuk seluruh halaman ===
  document.body.style.opacity = "0";
  document.body.style.transition = "opacity 0.6s ease";
  setTimeout(() => { document.body.style.opacity = "1"; }, 50);

  // === Auto-hide alert setelah 5 detik ===
  const alertBox = document.getElementById("alertBox");
  if (alertBox) {
    setTimeout(() => {
      alertBox.classList.add("fade-out");
      setTimeout(() => alertBox.remove(), 600);
    }, 5000);
  }

  // === Hapus data jurusan tanpa reload (animatif) ===
  document.querySelectorAll(".btn-action.delete").forEach(btn => {
    btn.addEventListener("click", e => {
      e.preventDefault();
      const id = btn.dataset.id;
      if (confirm("Yakin mau hapus jurusan ini?")) {
        fetch(`delete.php?id=${id}`)
          .then(res => res.ok && document.querySelector(`tr[data-id='${id}']`))
          .then(row => {
            if (row) {
              row.classList.add("fade-out");
              setTimeout(() => row.remove(), 600);
            }
          });
      }
    });
  });
});
</script>
</body>
</html>
