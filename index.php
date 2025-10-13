<?php
include "koneksi.php";

// Hitung total keseluruhan mahasiswa
$total_mhs = $koneksi->query("SELECT COUNT(*) AS total FROM mahasiswa WHERE deleted_at IS NULL")->fetch_assoc()['total'] ?? 0;
$jumlah_mhs = $total_mhs;
$jumlah_jur = $koneksi->query("SELECT COUNT(*) AS total FROM jurusan WHERE deleted_at IS NULL")->fetch_assoc()['total'] ?? 0;

// Ambil data mahasiswa per jurusan
$query = "
  SELECT j.nama AS jurusan, COUNT(m.id) AS total
  FROM jurusan j
  LEFT JOIN mahasiswa m ON m.jurusan_id = j.id AND m.deleted_at IS NULL
  WHERE j.deleted_at IS NULL
  GROUP BY j.id
  ORDER BY j.nama ASC
";
$result = $koneksi->query($query);

$labels = [];
$data = [];
while ($row = $result->fetch_assoc()) {
  $labels[] = $row['jurusan'];
  $data[] = (int)$row['total'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link rel="stylesheet" href="assets/style.css">

<!-- Chart.js dan plugin DataLabels -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
</head>
<body>
<div class="dashboard-container">

  <!-- === FORM 1: Informasi Umum === -->
  <div class="dashboard-card fade-in">
    <h1>🎓 Dashboard Akademik</h1>
    <p class="subtitle">Selamat datang di Sistem Data Mahasiswa & Jurusan</p>

    <div class="stats">
      <div class="stat-box">
        <h3>👩‍🎓 Total Mahasiswa</h3>
        <p class="count"><?= $jumlah_mhs ?></p>
      </div>
      <div class="stat-box">
        <h3>🏫 Total Jurusan</h3>
        <p class="count"><?= $jumlah_jur ?></p>
      </div>
    </div>

    <div class="action-buttons">
      <a href="mahasiswa/index.php" class="btn-dashboard">Kelola Mahasiswa</a>
      <a href="jurusan/index.php" class="btn-dashboard">Kelola Jurusan</a>
    </div>
  </div>

  <!-- === FORM 2: Grafik Data Mahasiswa per Jurusan === -->
  <div class="card fade-in" style="margin-top: 30px;">
    <h2>📊 Statistik Mahasiswa Berdasarkan Jurusan</h2>
    <canvas id="chartJurusan" height="120"></canvas>
  </div>

</div>

<script>
// Efek fade-in
document.addEventListener("DOMContentLoaded", () => {
  document.body.style.opacity = "0";
  document.body.style.transition = "opacity 0.6s ease";
  setTimeout(() => { document.body.style.opacity = "1"; }, 50);
});

// === Inisialisasi Grafik Chart.js ===
const ctx = document.getElementById('chartJurusan');
const dataValues = <?= json_encode($data) ?>;
const totalMahasiswa = <?= $total_mhs ?>;

const chartJurusan = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [{
      label: 'Jumlah Mahasiswa',
      data: dataValues,
      backgroundColor: [
        '#74b9ff', '#a29bfe', '#81ecec', '#fab1a0', '#ffeaa7', '#ff7675', '#55efc4'
      ],
      borderRadius: 10,
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: {
        callbacks: {
          label: function(context) {
            const value = context.parsed.y;
            const percent = totalMahasiswa > 0 ? ((value / totalMahasiswa) * 100).toFixed(1) + '%' : '0%';
            return `${value} mahasiswa (${percent})`;
          }
        }
      },
      datalabels: {
        color: '#2d3436',
        anchor: 'end',
        align: 'top',
        font: {
          weight: 'bold'
        },
        formatter: (value) => {
          if (totalMahasiswa === 0) return '0%';
          const percent = ((value / totalMahasiswa) * 100).toFixed(1);
          return `${value} (${percent}%)`;
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { stepSize: 1 }
      },
      x: {
        grid: { display: false }
      }
    }
  },
  plugins: [ChartDataLabels]
});
</script>
</body>
</html>
