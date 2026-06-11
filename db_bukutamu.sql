CREATE DATABASE IF NOT EXISTS db_bukutamu
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_bukutamu;
CREATE TABLE IF NOT EXISTS buku_tamu (
    id        INT          NOT NULL AUTO_INCREMENT,
    nama      VARCHAR(150) NOT NULL,
    instansi  VARCHAR(150) NOT NULL,
    tujuan    TEXT         NOT NULL,
    tanggal   DATE         NOT NULL,
    waktu     TIME         NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) VALUES
('Budi Santoso',   'Dinas Pendidikan Kota',    'Kunjungan Monitoring Sekolah',          '2025-06-01', '09:15:00'),
('Siti Rahayu',    'Universitas Siber Asia',   'Studi Banding Program Akademik',        '2025-06-02', '10:30:00'),
('Ahmad Fauzan',   'PT. Maju Bersama',         'Presentasi Kerjasama Ekstrakurikuler',  '2025-06-03', '13:00:00');
