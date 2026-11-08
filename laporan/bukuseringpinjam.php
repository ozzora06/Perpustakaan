<?php

require_once '../dbcontroller.php';

$db = new dbcontroller();

$sql = "SELECT 
            f_judul,
            COUNT(*) AS dipinjam,
            MAX(t_peminjaman.f_tanggalpeminjaman) AS tanggalpeminjaman
        FROM t_peminjaman
        INNER JOIN t_detailpeminjaman 
            ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
        INNER JOIN t_detailbuku 
            ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
        INNER JOIN t_buku 
            ON t_detailbuku.f_idbuku = t_buku.f_id
        WHERE t_detailpeminjaman.f_tanggalkembali != '0000-00-00'
        GROUP BY f_judul
        ORDER BY dipinjam DESC
        LIMIT 5";

$row = $db->getAll($sql);

$no = 1;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Buku Sering Dipinjam</title>
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
            max-width: 1100px;
        }

        .laporan {
            background: #ffffff;
            padding: 45px 50px;
            border: none;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
        }

        /* Header Laporan */
        .judul-laporan {
            position: relative;
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

        /* Informasi Laporan */
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

        /* Tabel */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .table thead th {
            background: #1e3a8a;
            color: #ffffff;
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            padding: 15px 12px;
            border: 1px solid #1e3a8a;
            vertical-align: middle;
        }

        .table tbody td {
            padding: 14px 12px;
            border: 1px solid #e2e8f0;
            color: #475569;
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .table tbody tr:hover {
            background: #eff6ff;
            transition: 0.2s;
        }

        .table tbody td:first-child {
            text-align: center;
            font-weight: 600;
            color: #1e3a8a;
        }

        .table tbody td:last-child {
            text-align: center;
            font-weight: 700;
            color: #2563eb;
        }

        /* Tombol */
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

        .btn-secondary:hover {
            background: #475569;
        }

        /* Responsive */
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
        }

        /* Print */
        @media print {
            body {
                background: #ffffff;
                font-size: 12px;
            }

            .container {
                max-width: 100%;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .laporan {
                padding: 0;
                border: none;
                border-radius: 0;
                box-shadow: none;
            }

            .no-print {
                display: none !important;
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
            .total-data {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            @page {
                size: A4 portrait;
                margin: 18mm;
            }
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between mb-3 no-print">
            <a href="javascript:history.back()" class="btn btn-secondary">
                Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                Cetak Laporan
            </button>
        </div>

        <div class="laporan shadow-sm">
            <div class="judul-laporan text-center">
                <h3 class="fw-bold mb-2">LAPORAN PERPUSTAKAAN</h3>
                <h5 class="fw-bold mb-2">JUMLAH BUKU YANG SERING DIPINJAM</h5>
                <p class="mb-0">Laporan Data Peminjaman Buku Perpustakaan</p>
            </div>

            <div class="d-flex justify-content-between mb-3 info-laporan">
                <div>
                    <strong>Jenis Laporan:</strong>
                    Buku Sering Dipinjam
                </div>
                <div>
                    <strong>Tanggal Cetak:</strong>
                    <?= date('d-m-Y'); ?>
                </div>
            </div>


            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th width="8%">No</th>
                        <th>Judul Buku</th>
                        <th width="25%">Tanggal Peminjaman Terakhir</th>
                        <th width="20%">Jumlah Peminjaman</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (!empty($row)): ?>
                        <?php foreach ($row as $r): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($r['f_judul']); ?></td>
                                <td><?= date('d-m-Y', strtotime($r['tanggalpeminjaman'])); ?></td>
                                <td><?= $r['dipinjam']; ?> kali</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                Belum ada data peminjaman buku.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-7">
                    <div>
                        <strong>Total Judul Buku:</strong>
                        <?= count($row); ?> buku
                    </div>
                </div>
                <div class="col-5 text-center">
                    <p><?= date('d F Y'); ?></p>
                    <p class="mb-5">
                        Petugas Perpustakaan
                    </p><br>
                    <p class="fw-bold">(................................)</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>