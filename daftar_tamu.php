<?php

require_once 'koneksi.php';
$keyword = '';
if (isset($_GET['cari']) && trim($_GET['cari']) !== '') {
    $keyword = trim(mysqli_real_escape_string($koneksi, $_GET['cari']));
    $sql     = "SELECT * FROM buku_tamu
                WHERE nama LIKE '%$keyword%' OR instansi LIKE '%$keyword%'
                ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM buku_tamu ORDER BY id DESC";
}

$result   = mysqli_query($koneksi, $sql);
$jumlah   = mysqli_num_rows($result);
$total_res   = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku_tamu");
$total_row   = mysqli_fetch_assoc($total_res);
$total_tamu  = $total_row['total'];

$today_res  = mysqli_query($koneksi, "SELECT COUNT(*) AS hari FROM buku_tamu WHERE tanggal = CURDATE()");
$today_row  = mysqli_fetch_assoc($today_res);
$tamu_hari  = $today_row['hari'];

$inst_res   = mysqli_query($koneksi, "SELECT COUNT(DISTINCT instansi) AS inst FROM buku_tamu");
$inst_row   = mysqli_fetch_assoc($inst_res);
$jml_inst   = $inst_row['inst'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tamu – Buku Tamu Digital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:   #1e40af;
            --secondary: #3b82f6;
            --accent:    #dbeafe;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #bfdbfe 100%);
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar-custom {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            box-shadow: 0 4px 12px rgba(30,64,175,.35);
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link { color: #fff !important; font-weight: 500; }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active { color: #bfdbfe !important; }

        /* HEADER CARD */
        .header-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 1.25rem;
            color: #fff;
            padding: 2.25rem 2rem;
            position: relative;
            overflow: hidden;
        }
        .header-card::before {
            content:''; position:absolute; top:-60px; right:-60px;
            width:200px; height:200px; background:rgba(255,255,255,.08); border-radius:50%;
        }

        /* STAT CARDS */
        .stat-card {
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 16px rgba(30,64,175,.1);
            background: #fff;
            border-left: 5px solid transparent;
        }
        .stat-card.blue   { border-left-color: var(--secondary); }
        .stat-card.green  { border-left-color: #16a34a; }
        .stat-card.purple { border-left-color: #7c3aed; }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: .75rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }
        .stat-icon.blue   { background:#dbeafe; color:var(--secondary); }
        .stat-icon.green  { background:#dcfce7; color:#16a34a; }
        .stat-icon.purple { background:#ede9fe; color:#7c3aed; }
        .stat-number { font-size: 1.6rem; font-weight: 700; color: #1e3a5f; line-height:1; }
        .stat-label  { font-size: .78rem; color: #64748b; margin-top: .2rem; }

        /* SEARCH BOX */
        .search-box {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 16px rgba(30,64,175,.1);
            padding: 1.25rem 1.5rem;
        }
        .search-box .form-control {
            border: 1.5px solid #bfdbfe;
            border-radius: .6rem;
        }
        .search-box .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 .2rem rgba(59,130,246,.2);
        }

        /* TABLE */
        .table-wrapper {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px rgba(30,64,175,.12);
            overflow: hidden;
        }
        .table-wrapper .table {
            margin-bottom: 0;
            font-size: .9rem;
        }
        .table-wrapper .table thead th {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            font-weight: 600;
            border: none;
            padding: .875rem 1rem;
            white-space: nowrap;
        }
        .table-wrapper .table tbody tr:hover {
            background: var(--accent);
        }
        .table-wrapper .table td {
            vertical-align: middle;
            padding: .8rem 1rem;
            border-color: #e2e8f0;
        }

        /* NO BADGE */
        .no-badge {
            background: var(--primary);
            color: #fff;
            border-radius: .4rem;
            padding: .25rem .6rem;
            font-size: .78rem;
            font-weight: 600;
        }

        /* TUJUAN TRUNCATE */
        .tujuan-text {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        /* BUTTONS */
        .btn-tambah {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            border: none;
            border-radius: .75rem;
            padding: .55rem 1.25rem;
            font-weight: 600;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-tambah:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(30,64,175,.35);
            color: #fff;
        }
        .btn-reset {
            border: 1.5px solid #cbd5e1;
            color: #475569;
            border-radius: .75rem;
        }

        /* EMPTY STATE */
        .empty-state { padding: 4rem 1rem; text-align: center; color: #94a3b8; }
        .empty-state i { font-size: 4rem; display: block; margin-bottom: 1rem; }

        footer {
            background: var(--primary);
            color: rgba(255,255,255,.7);
            font-size: .82rem;
            padding: 1.25rem;
            text-align: center;
            margin-top: 3rem;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
      <i class="bi bi-journal-bookmark-fill me-2"></i>Buku Tamu Digital
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="bi bi-pencil-square me-1"></i>Form Tamu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="daftar_tamu.php"><i class="bi bi-people-fill me-1"></i>Daftar Tamu</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">

    <div class="header-card shadow mb-4">
        <div class="position-relative z-1">
            <h2 class="fw-bold mb-1"><i class="bi bi-people-fill me-2"></i>Daftar Tamu</h2>
            <p class="mb-0 opacity-75">Rekap seluruh kunjungan tamu yang telah terdaftar.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="stat-number"><?= $total_tamu ?></div>
                    <div class="stat-label">Total Tamu</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card green">
                <div class="stat-icon green"><i class="bi bi-calendar-check-fill"></i></div>
                <div>
                    <div class="stat-number"><?= $tamu_hari ?></div>
                    <div class="stat-label">Tamu Hari Ini</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card purple">
                <div class="stat-icon purple"><i class="bi bi-building-fill"></i></div>
                <div>
                    <div class="stat-number"><?= $jml_inst ?></div>
                    <div class="stat-label">Instansi Berbeda</div>
                </div>
            </div>
        </div>
    </div>

    <div class="search-box mb-4">
        <form method="GET" action="daftar_tamu.php" class="row g-2 align-items-center">
            <div class="col-md-8 col-lg-9">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border:1.5px solid #bfdbfe;border-right:0;border-radius:.6rem 0 0 .6rem;">
                        <i class="bi bi-search text-secondary"></i>
                    </span>
                    <input type="text" name="cari" class="form-control border-start-0"
                           style="border-radius:0 .6rem .6rem 0;"
                           placeholder="Cari berdasarkan nama atau instansi..."
                           value="<?= htmlspecialchars($keyword) ?>">
                </div>
            </div>
            <div class="col-md-4 col-lg-3 d-flex gap-2">
                <button type="submit" class="btn btn-tambah flex-grow-1">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
                <?php if ($keyword): ?>
                <a href="daftar_tamu.php" class="btn btn-reset">
                    <i class="bi bi-x-lg"></i>
                </a>
                <?php endif; ?>
            </div>
        </form>
        <?php if ($keyword): ?>
        <p class="text-muted small mt-2 mb-0">
            <i class="bi bi-funnel me-1"></i>
            Menampilkan <strong><?= $jumlah ?></strong> hasil untuk kata kunci "<strong><?= htmlspecialchars($keyword) ?></strong>"
        </p>
        <?php endif; ?>
    </div>

    <div class="table-wrapper">
        <?php if ($jumlah > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th width="55"><i class="bi bi-hash"></i> No</th>
                        <th><i class="bi bi-person-fill me-1"></i>Nama Lengkap</th>
                        <th><i class="bi bi-building-fill me-1"></i>Instansi</th>
                        <th><i class="bi bi-chat-left-text-fill me-1"></i>Tujuan</th>
                        <th width="120"><i class="bi bi-calendar3 me-1"></i>Tanggal</th>
                        <th width="100"><i class="bi bi-clock me-1"></i>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)):
                    $isToday = ($row['tanggal'] === date('Y-m-d'));
                ?>
                    <tr>
                        <td class="text-center"><span class="no-badge"><?= $no++ ?></span></td>
                        <td>
                            <div class="fw-semibold"><?= htmlspecialchars($row['nama']) ?></div>
                        </td>
                        <td>
                            <span class="badge rounded-pill text-bg-light border" style="font-size:.8rem;font-weight:500;color:#1e3a5f;">
                                <i class="bi bi-building me-1"></i><?= htmlspecialchars($row['instansi']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="tujuan-text" title="<?= htmlspecialchars($row['tujuan']) ?>">
                                <?= htmlspecialchars($row['tujuan']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($isToday): ?>
                            <span class="badge bg-success"><i class="bi bi-calendar-check me-1"></i>
                                <?= date('d/m/Y', strtotime($row['tanggal'])) ?>
                            </span>
                            <?php else: ?>
                            <?= date('d/m/Y', strtotime($row['tanggal'])) ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="text-secondary">
                                <i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($row['waktu'])) ?>
                            </span>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="px-3 py-2 bg-light d-flex justify-content-between align-items-center border-top" style="font-size:.82rem;color:#64748b;">
            <span><i class="bi bi-info-circle me-1"></i>Menampilkan <?= $jumlah ?> dari <?= $total_tamu ?> data tamu</span>
            <span class="text-muted">Diperbarui: <?= date('d M Y, H:i') ?></span>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h5 class="fw-semibold">Tidak Ada Data</h5>
            <p class="text-muted">
                <?= $keyword ? "Tidak ditemukan tamu dengan kata kunci \"" . htmlspecialchars($keyword) . "\"." : "Belum ada tamu yang terdaftar." ?>
            </p>
            <a href="index.php" class="btn btn-tambah mt-2">
                <i class="bi bi-plus-circle me-2"></i>Daftarkan Tamu Baru
            </a>
        </div>
        <?php endif; ?>
    </div>

    <div class="mt-4 text-center">
        <a href="index.php" class="btn btn-tambah">
            <i class="bi bi-plus-circle-fill me-2"></i>Tambah Tamu Baru
        </a>
    </div>

</div>

<footer>
    <i class="bi bi-shield-check me-1"></i>
    &copy; <?= date('Y') ?> Buku Tamu Digital &mdash; Dibuat dengan Bootstrap 5 &amp; PHP
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.querySelectorAll('.tujuan-text').forEach(el => {
        el.addEventListener('click', () => {
            alert(el.getAttribute('title'));
        });
    });
</script>

</body>
</html>
