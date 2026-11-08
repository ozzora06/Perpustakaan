
<?php

require_once '../dbcontroller.php';

$db = new dbcontroller();

// FILTER PERIODE
$tgl_awal = $_GET['tgl_awal'] ?? date('Y-m-01');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');

// VALIDASI TANGGAL
function validasiTanggal($tanggal)
{
    $d = DateTime::createFromFormat('!Y-m-d', $tanggal);
    return $d && $d->format('Y-m-d') === $tanggal;
}

if (
    !validasiTanggal($tgl_awal) ||
    !validasiTanggal($tgl_akhir) ||
    $tgl_awal > $tgl_akhir
) {
    $tgl_awal = date('Y-m-01');
    $tgl_akhir = date('Y-m-d');
}

// KONEKSI DATABASE
$koneksi = $db->koneksiDB();

// ESCAPE DATA
$tgl_awal_sql = mysqli_real_escape_string($koneksi, $tgl_awal);
$tgl_akhir_sql = mysqli_real_escape_string($koneksi, $tgl_akhir);

// QUERY LAPORAN PEMINJAMAN
$sql = "SELECT
            t_peminjaman.f_id,
            t_anggota.f_nama AS f_namaanggota,
            t_peminjaman.f_tanggalpeminjaman,
            t_detailpeminjaman.f_tanggalkembali,
            t_kategori.f_kategori,
            t_buku.f_judul,
            t_admin.f_nama AS f_namaadmin,
            t_detailbuku.f_id AS f_iddetb

        FROM t_peminjaman

        INNER JOIN t_admin
            ON t_peminjaman.f_idadmin = t_admin.f_id

        INNER JOIN t_anggota
            ON t_peminjaman.f_idanggota = t_anggota.f_id

        INNER JOIN t_detailpeminjaman
            ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman

        INNER JOIN t_detailbuku
            ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id

        INNER JOIN t_buku
            ON t_detailbuku.f_idbuku = t_buku.f_id

        INNER JOIN t_kategori
            ON t_buku.f_idkategori = t_kategori.f_id

        WHERE t_peminjaman.f_tanggalpeminjaman
            BETWEEN '$tgl_awal_sql' AND '$tgl_akhir_sql'

        ORDER BY t_peminjaman.f_id ASC";

$data = $db->getAll($sql);

// TOTAL DATA
$total_peminjaman = !empty($data) ? count($data) : 0;

// TOTAL STATUS PENGEMBALIAN
$total_kembali = 0;
$total_belum_kembali = 0;

if (!empty($data)) {
    foreach ($data as $r) {

        if (
            empty($r['f_tanggalkembali']) ||
            $r['f_tanggalkembali'] == '0000-00-00'
        ) {
            $total_belum_kembali++;
        } else {
            $total_kembali++;
        }

    }
}

$no = 1;

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Peminjaman Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #eef2f7;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #334155;
            font-size: 14px;
        }

        .container {
            max-width: 1200px;
        }

        /* LAPORAN */
        .laporan {
            background: #ffffff;
            padding: 45px 50px;
            border: none;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
        }

        /* HEADER */
        .judul-laporan {
            text-align: center;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 25px;
            margin-bottom: 30px;
        }

        .judul-laporan h3 {
            color: #1e293b;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .judul-laporan h5 {
            color: #2563eb;
            font-size: 17px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .judul-laporan p {
            color: #64748b;
            font-size: 13px;
        }

        /* INFORMASI */
        .info-laporan {
            background: #f1f5f9;
            border-left: 4px solid #2563eb;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 25px;
        }

        .info-laporan strong {
            color: #1e293b;
        }

        /* TABEL */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            margin-bottom: 20px;
        }

        .table thead th {
            background: #1e3a8a;
            color: #ffffff;
            text-align: center;
            font-size: 12px;
            font-weight: 700;
            padding: 13px 10px;
            border: 1px solid #1e3a8a;
            vertical-align: middle;
        }

        .table tbody td {
            padding: 12px 10px;
            border: 1px solid #e2e8f0;
            color: #475569;
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .table tbody tr:hover {
            background: #eff6ff;
        }

        .table tbody td:first-child {
            text-align: center;
            font-weight: 600;
            color: #1e3a8a;
        }

        .table tbody td:last-child {
            text-align: center;
        }

        /* TOMBOL */
        .btn {
            padding: 10px 20px;
            border-radius: 7px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-primary {
            background: #1e40af;
            border-color: #1e40af;
        }

        .btn-primary:hover {
            background: #1e3a8a;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #64748b;
            border-color: #64748b;
        }

        /* RINGKASAN */
        .ringkasan {
            background: #f1f5f9;
            padding: 15px 20px;
            border-radius: 7px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {

            .laporan {
                padding: 25px 18px;
            }

            .judul-laporan h3 {
                font-size: 19px;
            }

            .judul-laporan h5 {
                font-size: 14px;
            }

            .table {
                font-size: 12px;
            }

            .table th,
            .table td {
                padding: 9px 7px;
            }

            .info-laporan {
                flex-direction: column;
                gap: 8px;
            }

        }

        /* PRINT */
        @media print {

            body {
                background: #ffffff !important;
                font-size: 11px;
            }

            .container {
                max-width: 100%;
                width: 100%;
                margin: 0 !important;
                padding: 0 !important;
            }

            .laporan {
                padding: 0;
                border: none;
                border-radius: 0;
                box-shadow: none;
            }

            .no-print,
            .sidebar,
            .topbar,
            form,
            button,
            .btn {
                display: none !important;
            }

            .content {
                margin: 0 !important;
                padding: 0 !important;
            }

            .table {
                font-size: 10px;
            }

            .table thead th {
                background: #1e3a8a !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table tbody tr:nth-child(even) {
                background: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .info-laporan,
            .ringkasan {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            @page {
                size: A4 landscape;
                margin: 12mm;
            }

        }

    </style>

</head>

<body>

<div class="container my-5">

    <!-- TOMBOL -->
    <div class="d-flex justify-content-between mb-3 no-print">

        <a href="javascript:history.back()"
           class="btn btn-secondary">

            Kembali

        </a>

        <button onclick="window.print()"
                class="btn btn-primary">

            Cetak Laporan

        </button>

    </div>

    <!-- FILTER PERIODE -->
    <div class="card shadow-sm border-0 mb-4 no-print">

        <div class="card-body">

            <h5 class="mb-3">
                Filter Periode Laporan
            </h5>

            <form method="GET" action="index.php">

                <input type="hidden" name="f" value="laporan">
                <input type="hidden" name="m" value="select">

                <div class="row align-items-end">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="tgl_awal"
                            class="form-control"
                            value="<?= htmlspecialchars($tgl_awal); ?>"
                            required>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Tanggal Akhir
                        </label>

                        <input
                            type="date"
                            name="tgl_akhir"
                            class="form-control"
                            value="<?= htmlspecialchars($tgl_akhir); ?>"
                            required>

                    </div>

                    <div class="col-md-4 mb-3">

                        <button type="submit" class="btn btn-primary">
                            Tampilkan
                        </button>

                        <a href="index.php?f=laporan&m=select"
                           class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- LAPORAN -->
    <div class="laporan shadow-sm">

        <!-- HEADER -->
        <div class="judul-laporan">

            <h3 class="fw-bold mb-2">
                LAPORAN PERPUSTAKAAN
            </h3>

            <h5 class="fw-bold mb-2">
                LAPORAN DATA PEMINJAMAN BUKU
            </h5>

            <p class="mb-0">
                Laporan Data Transaksi Peminjaman Perpustakaan
            </p>

        </div>

        <!-- INFORMASI -->
        <div class="d-flex justify-content-between mb-3 info-laporan flex-wrap">

            <div>
                <strong>Jenis Laporan:</strong>
                Data Peminjaman Buku
            </div>

            <div>
                <strong>Periode:</strong>
                <?= date('d-m-Y', strtotime($tgl_awal)); ?>
                sampai
                <?= date('d-m-Y', strtotime($tgl_akhir)); ?>
            </div>

            <div>
                <strong>Tanggal Cetak:</strong>
                <?= date('d-m-Y'); ?>
            </div>

        </div>

        <!-- TABEL -->
        <div class="table-responsive">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>
                        <th width="5%">No</th>
                        <th>Anggota</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Kategori</th>
                        <th>Judul Buku</th>
                        <th>Admin</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody class="text-center">

                    <?php if (!empty($data)): ?>

                        <?php foreach ($data as $r): ?>

                            <tr>

                                <td>
                                    <?= $no++; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($r['f_namaanggota']); ?>
                                </td>

                                <td>
                                    <?= date(
                                        'd-m-Y',
                                        strtotime($r['f_tanggalpeminjaman'])
                                    ); ?>
                                </td>

                                <td>
                                    <?php
                                    if (
                                        empty($r['f_tanggalkembali']) ||
                                        $r['f_tanggalkembali'] == '0000-00-00'
                                    ) {
                                        echo '-';
                                    } else {
                                        echo date(
                                            'd-m-Y',
                                            strtotime($r['f_tanggalkembali'])
                                        );
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($r['f_kategori']); ?>
                                </td>

                                <td class="text-start">
                                    <?= htmlspecialchars($r['f_judul']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($r['f_namaadmin']); ?>
                                </td>

                                <td>
                                    <?php
                                    if (
                                        empty($r['f_tanggalkembali']) ||
                                        $r['f_tanggalkembali'] == '0000-00-00'
                                    ) {
                                        echo '<span class="badge bg-danger">Belum Kembali</span>';
                                    } else {
                                        echo '<span class="badge bg-success">Sudah Kembali</span>';
                                    }
                                    ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="8" class="text-center py-4">
                                Tidak ada data peminjaman pada periode ini.
                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

        <!-- TOTAL -->
        <div class="row mt-3">

            <div class="col-md-7">

                <div class="ringkasan">

                    <div class="mb-2">
                        <strong>
                            Total Peminjaman:
                            <?= $total_peminjaman; ?> buku
                        </strong>
                    </div>

                    <div class="mb-2">
                        <strong>
                            Total Sudah Dikembalikan:
                            <?= $total_kembali; ?> buku
                        </strong>
                    </div>

                    <div>
                        <strong>
                            Total Belum Dikembalikan:
                            <?= $total_belum_kembali; ?> buku
                        </strong>
                    </div>

                </div>

            </div>

            <!-- TANDA TANGAN -->
            <div class="col-md-5 text-center mt-4 mt-md-0">

                <p>
                    <?= date('d F Y'); ?>
                </p>

                <p class="mb-5">
                    Petugas Perpustakaan
                </p>

                <br>

                <p class="fw-bold">
                    (................................)
                </p>

            </div>

        </div>

    </div>

</div>

</body>
</html>
