<?php
// index.php – Halaman Formulir Tamu
require_once 'koneksi.php';

$pesan   = '';
$tipe    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $instansi = trim(mysqli_real_escape_string($koneksi, $_POST['instansi']));
    $tujuan   = trim(mysqli_real_escape_string($koneksi, $_POST['tujuan']));
    $tanggal  = date('Y-m-d');
    $waktu    = date('H:i:s');

    if ($nama !== '' && $instansi !== '' && $tujuan !== '') {
        $sql = "INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu)
                VALUES ('$nama', '$instansi', '$tujuan', '$tanggal', '$waktu')";

        if (mysqli_query($koneksi, $sql)) {
            $pesan = 'Data tamu berhasil disimpan. Selamat datang, <strong>' . htmlspecialchars($nama) . '</strong>!';
            $tipe  = 'success';
        } else {
            $pesan = 'Terjadi kesalahan saat menyimpan data: ' . mysqli_error($koneksi);
            $tipe  = 'danger';
        }
    } else {
        $pesan = 'Semua field wajib diisi!';
        $tipe  = 'warning';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Digital – Form Kedatangan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:   #1e40af;
            --secondary: #3b82f6;
            --accent:    #dbeafe;
            --success:   #16a34a;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #bfdbfe 100%);
            min-height: 100vh;
        }

        /* ---- NAVBAR ---- */
        .navbar-custom {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            box-shadow: 0 4px 12px rgba(30,64,175,.35);
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #fff !important;
            font-weight: 500;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #bfdbfe !important;
        }

        /* ---- HEADER CARD ---- */
        .header-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 1.25rem;
            color: #fff;
            padding: 2.5rem 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        .header-card::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: rgba(255,255,255,.08);
            border-radius: 50%;
        }
        .header-card::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -40px;
            width: 250px; height: 250px;
            background: rgba(255,255,255,.06);
            border-radius: 50%;
        }

        /* ---- FORM CARD ---- */
        .form-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px rgba(30,64,175,.12);
            padding: 2rem 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #1e3a5f;
            font-size: .875rem;
        }
        .form-control, .form-select {
            border: 1.5px solid #bfdbfe;
            border-radius: .6rem;
            padding: .6rem 1rem;
            font-size: .925rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 .2rem rgba(59,130,246,.2);
        }

        .input-group-text {
            background: var(--accent);
            border: 1.5px solid #bfdbfe;
            border-radius: .6rem 0 0 .6rem;
            color: var(--primary);
        }

        /* ---- DATETIME BOX ---- */
        .datetime-box {
            background: var(--accent);
            border: 1.5px solid #93c5fd;
            border-radius: .75rem;
            padding: 1rem 1.25rem;
        }
        .datetime-box .value {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary);
        }
        .datetime-box .label {
            font-size: .78rem;
            color: #64748b;
        }

        /* ---- SUBMIT BUTTON ---- */
        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            border: none;
            border-radius: .75rem;
            padding: .75rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30,64,175,.4);
            color: #fff;
        }

        /* ---- DAFTAR TAMU BUTTON ---- */
        .btn-outline-daftar {
            border: 2px solid var(--secondary);
            color: var(--primary);
            border-radius: .75rem;
            padding: .65rem 1.5rem;
            font-weight: 600;
            transition: all .15s;
        }
        .btn-outline-daftar:hover {
            background: var(--secondary);
            color: #fff;
        }

        /* ---- FOOTER ---- */
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
          <a class="nav-link active" href="index.php"><i class="bi bi-pencil-square me-1"></i>Form Tamu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="daftar_tamu.php"><i class="bi bi-people-fill me-1"></i>Daftar Tamu</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">

    <div class="header-card shadow">
        <div class="position-relative z-1">
            <h2 class="fw-bold mb-1"><i class="bi bi-building me-2"></i>Selamat Datang</h2>
            <p class="mb-0 opacity-75">Silakan isi formulir kedatangan Anda dengan lengkap dan benar.</p>
        </div>
    </div>
    <?php if ($pesan): ?>
    <div class="alert alert-<?= $tipe ?> alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
        <i class="bi bi-<?= $tipe === 'success' ? 'check-circle-fill' : ($tipe === 'warning' ? 'exclamation-triangle-fill' : 'x-circle-fill') ?> me-2"></i>
        <?= $pesan ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card shadow">

                <h5 class="fw-bold mb-1" style="color:var(--primary)">
                    <i class="bi bi-clipboard-plus me-2"></i>Formulir Kedatangan Tamu
                </h5>
                <p class="text-muted small mb-4">Kolom bertanda <span class="text-danger">*</span> wajib diisi.</p>

                <form method="POST" action="index.php" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="nama" class="form-control"
                                   placeholder="Masukkan nama lengkap Anda"
                                   value="<?= isset($_POST['nama']) && $tipe !== 'success' ? htmlspecialchars($_POST['nama']) : '' ?>"
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Instansi / Asal Lembaga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building-fill"></i></span>
                            <input type="text" name="instansi" class="form-control"
                                   placeholder="Nama sekolah, perusahaan, atau instansi Anda"
                                   value="<?= isset($_POST['instansi']) && $tipe !== 'success' ? htmlspecialchars($_POST['instansi']) : '' ?>"
                                   required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tujuan Kedatangan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-chat-left-text-fill"></i></span>
                            <textarea name="tujuan" class="form-control" rows="3"
                                      placeholder="Jelaskan keperluan / tujuan kunjungan Anda..."
                                      required><?= isset($_POST['tujuan']) && $tipe !== 'success' ? htmlspecialchars($_POST['tujuan']) : '' ?></textarea>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label"><i class="bi bi-clock me-1"></i>Tanggal & Waktu Kedatangan</label>
                        <div class="datetime-box">
                            <div class="row g-3 align-items-center">
                                <div class="col-sm-6 d-flex align-items-center gap-3">
                                    <i class="bi bi-calendar3 fs-4" style="color:var(--primary)"></i>
                                    <div>
                                        <div class="label">Tanggal</div>
                                        <div class="value" id="tanggalSekarang">–</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center gap-3">
                                    <i class="bi bi-clock-history fs-4" style="color:var(--primary)"></i>
                                    <div>
                                        <div class="label">Waktu</div>
                                        <div class="value" id="waktuSekarang">–</div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted small mt-2 mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                Tanggal &amp; waktu diisi otomatis saat Anda menekan tombol Submit.
                            </p>
                        </div>
                    </div>

                   
                    <div class="d-flex gap-3 flex-wrap">
                        <button type="submit" class="btn btn-submit flex-grow-1">
                            <i class="bi bi-send-fill me-2"></i>Submit Kedatangan
                        </button>
                        <a href="daftar_tamu.php" class="btn btn-outline-daftar">
                            <i class="bi bi-list-ul me-2"></i>Lihat Daftar Tamu
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<footer>
    <i class="bi bi-shield-check me-1"></i>
    &copy; <?= date('Y') ?> Buku Tamu Digital
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function updateDatetime() {
        const now  = new Date();
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const mons = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        const tgl = `${days[now.getDay()]}, ${now.getDate()} ${mons[now.getMonth()]} ${now.getFullYear()}`;
        const jam = now.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit', second:'2-digit'});

        document.getElementById('tanggalSekarang').textContent = tgl;
        document.getElementById('waktuSekarang').textContent   = jam;
    }
    updateDatetime();
    setInterval(updateDatetime, 1000);
</script>

</body>
</html>
