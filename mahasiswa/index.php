<?php
include "../koneksi.php";
session_start();

// Ambil data mahasiswa beserta jurusannya
$sql = "SELECT m.*, j.nama AS jurusan 
        FROM mahasiswa m 
        LEFT JOIN jurusan j ON m.jurusan_id = j.id 
        WHERE m.deleted_at IS NULL 
        ORDER BY m.id ASC";
$data = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Mahasiswa</title>
<link rel="stylesheet" href="../assets/style.css">
<style>
/* Efek animasi hilang (fade-out) */
.fade-out {
  opacity: 0;
  transform: scale(0.98);
  transition: all 0.6s ease;
}

/* Toolbar sejajar (flex container) */
.toolbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 20px;
}

/* Grup tombol kiri */
.action-bar {
  display: flex;
  gap: 10px;
}

/* Search box kanan */
.search-box {
  position: relative;
}
.search-box input {
  padding: 10px 14px;
  border: 2px solid #e3e3e3;
  border-radius: 10px;
  font-size: 15px;
  width: 260px;
  transition: all 0.3s ease;
}
.search-box input:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(78, 84, 200, 0.2);
  outline: none;
}

/* Responsif */
@media (max-width: 768px) {
  .toolbar {
    flex-direction: column;
    align-items: stretch;
  }
  .search-box {
    width: 100%;
    margin-top: 10px;
    text-align: left;
  }
  .search-box input {
    width: 100%;
  }
}
</style>
</head>
<body>
<div class="container">
  <div class="card fade-in">
    <h2>👩‍🎓 Data Mahasiswa</h2>

    <!-- Pesan notifikasi -->
    <?php if (isset($_SESSION['pesan'])): ?>
      <div id="alertBox" class="alert"><?= $_SESSION['pesan']; ?></div>
      <?php unset($_SESSION['pesan']); ?>
    <?php endif; ?>

    <!-- Toolbar gabungan -->
    <div class="toolbar">
      <div class="action-bar">
        <a href="tambah.php" class="btn">+ Tambah Mahasiswa</a> 
        <a href="../index.php" class="btn">🏠 Dashboard</a>
      </div>
      <div class="search-box">
        <input type="text" id="searchInput" placeholder="🔍 Cari berdasarkan nama...">
      </div>
    </div>

    <!-- Tabel Data Mahasiswa -->
    <table id="dataTable">
      <thead>
        <tr>
          <th>No</th>
          <th>NIM</th>
          <th>Nama</th>
          <th>Jurusan</th>
          <th>Umur</th>
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
                  <td>{$row['nim']}</td>
                  <td class='nama-cell'>{$row['nama']}</td>
                  <td>{$row['jurusan']}</td>
                  <td>{$row['umur']}</td>
                  <td>{$row['created_at']}</td>
                  <td class='aksi-btns'>
                      <a href='edit.php?id={$row['id']}' class='btn-action edit'>Edit</a>
                      <a href='#' class='btn-action delete' data-id='{$row['id']}'>Hapus</a>
                  </td>
              </tr>";
              $no++;
          }
      } else {
          echo "<tr><td colspan='7'>Belum ada data mahasiswa</td></tr>";
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

  // === Hilangkan alert otomatis setelah 5 detik ===
  const alertBox = document.getElementById("alertBox");
  if (alertBox) {
    setTimeout(() => {
      alertBox.classList.add("fade-out");
      setTimeout(() => alertBox.remove(), 600);
    }, 5000);
  }

  // === Tombol hapus mahasiswa dengan animasi tanpa reload ===
  document.querySelectorAll(".btn-action.delete").forEach(btn => {
    btn.addEventListener("click", e => {
      e.preventDefault();
      const id = btn.dataset.id;
      if (confirm("Yakin mau hapus data ini?")) {
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

  // === Fitur pencarian nama mahasiswa ===
  const searchInput = document.getElementById("searchInput");
  const rows = document.querySelectorAll("#dataTable tbody tr");

  searchInput.addEventListener("keyup", () => {
    const keyword = searchInput.value.toLowerCase();
    rows.forEach(row => {
      const nama = row.querySelector(".nama-cell")?.textContent.toLowerCase();
      if (nama && nama.includes(keyword)) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
});
</script>
</body>
</html>
