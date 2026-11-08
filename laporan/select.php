<?php

$bukuseluruh = $db->rowCOUNT("
    SELECT f_judul FROM t_buku
");

$bukupinjam = $db->rowCOUNT("
    SELECT t_detailbuku.f_id
    FROM t_buku
    INNER JOIN t_detailbuku
        ON t_buku.f_id = t_detailbuku.f_idbuku
    WHERE t_detailbuku.f_status = 'Tidak Tersedia'
");

$bukutersedia = $db->rowCOUNT("
    SELECT t_detailbuku.f_id
    FROM t_buku
    INNER JOIN t_detailbuku
        ON t_buku.f_id = t_detailbuku.f_idbuku
    WHERE t_detailbuku.f_status = 'Tersedia'
");

$limabuku = $db->getALL("
    SELECT
        t_buku.f_judul,
        COUNT(*) AS dipinjam,
        MAX(t_peminjaman.f_tanggalpeminjaman) AS f_tanggalpeminjaman
    FROM t_peminjaman
    INNER JOIN t_detailpeminjaman
        ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
    INNER JOIN t_detailbuku
        ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
    INNER JOIN t_buku
        ON t_detailbuku.f_idbuku = t_buku.f_id
    WHERE t_detailpeminjaman.f_tanggalkembali <> '0000-00-00'
    GROUP BY t_buku.f_id, t_buku.f_judul
    ORDER BY dipinjam DESC
    LIMIT 10
");

$bukubelumkembali = $db->getALL("
    SELECT
        t_buku.f_judul,
        COUNT(*) AS jumlah_belum_kembali
    FROM t_buku
    INNER JOIN t_detailbuku
        ON t_buku.f_id = t_detailbuku.f_idbuku
    INNER JOIN t_detailpeminjaman
        ON t_detailbuku.f_id = t_detailpeminjaman.f_iddetailbuku
    WHERE t_detailpeminjaman.f_tanggalkembali = '0000-00-00'
    GROUP BY t_buku.f_id, t_buku.f_judul
    ORDER BY jumlah_belum_kembali DESC
    LIMIT 10
");

$limaanggota = $db->getALL("
    SELECT
        t_anggota.f_nama,
        COUNT(*) AS pinjam
    FROM t_anggota
    INNER JOIN t_peminjaman
        ON t_anggota.f_id = t_peminjaman.f_idanggota
    INNER JOIN t_detailpeminjaman
        ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
    GROUP BY t_anggota.f_id, t_anggota.f_nama
    ORDER BY pinjam DESC
    LIMIT 10
");

$anggota = $db->getALL("
    SELECT
        t_anggota.f_nama,
        COUNT(*) AS kembali
    FROM t_anggota
    INNER JOIN t_peminjaman
        ON t_anggota.f_id = t_peminjaman.f_idanggota
    INNER JOIN t_detailpeminjaman
        ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
    WHERE t_detailpeminjaman.f_tanggalkembali = '0000-00-00'
    GROUP BY t_anggota.f_id, t_anggota.f_nama
    ORDER BY kembali DESC
    LIMIT 10
");

?>

<style>
    .warna {
        background-color: #6096B4;
    }

    .warna1 {
        background-color: #F8EAD8;
    }

    .plan-card {
        background: #fff;
        width: 15rem;
        padding-left: 2rem;
        padding-right: 2rem;
        padding-top: 10px;
        padding-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 6px 30px rgba(207, 212, 222, 0.3);
        font-family: "Poppins", sans-serif;
    }

    .plan-card h2 {
        margin-bottom: 15px;
        font-size: 27px;
        font-weight: 600;
    }

    .etiquet-price {
        position: relative;
        background: #fdbd4a;
        width: 14.46rem;
        margin-left: -0.65rem;
        padding: .2rem 1.2rem;
        border-radius: 5px 0 0 5px;
    }

    .etiquet-price p {
        margin: 0;
        padding-top: .4rem;
        display: flex;
        font-size: 1.9rem;
        font-weight: 500;
    }

    .etiquet-price div {
        position: absolute;
        bottom: -23px;
        right: 0;
        width: 0;
        height: 0;
        border-top: 13px solid #c58102;
        border-bottom: 10px solid transparent;
        border-right: 13px solid transparent;
        z-index: -6;
    }

    .benefits-list {
        margin-top: 16px;
    }

    .benefits-list ul {
        padding: 0;
        font-size: 14px;
    }

    .benefits-list ul li {
        color: #4d4d4d;
        list-style: none;
        margin-bottom: .2rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .button-get-plan {
        display: flex;
        justify-content: center;
        margin-top: 1.2rem;
    }

    .button-get-plan a {
        display: flex;
        justify-content: center;
        align-items: center;
        background: #6096B4;
        color: #fff;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-size: .8rem;
        letter-spacing: .05rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .button-get-plan a:hover {
        transform: translateY(-10%);
        box-shadow: 0 3px 10px rgba(207, 212, 222, 0.9);
    }
</style>

<div class="container-fluid px-3">

    <div class="text-center my-4">
        <h2 style="font-family: Georgia, 'Times New Roman', Times, serif;">
            <strong>LAPORAN PERPUSTAKAAN</strong>
        </h2>
        <hr>
    </div>

    <div class="row g-4">
        <!-- BUKU SERING DIPINJAM -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h4 class="mb-0">Buku Sering Dipinjam</h4>
                        <a href="../laporan/bukuseringpinjam.php" class="btn btn-dark">
                            <i class="fa-solid fa-file-export me-2"></i>Export
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="warna">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Judul Buku</th>
                                    <th class="text-center">Tanggal Peminjaman Terakhir</th>
                                    <th class="text-center">Jumlah Dipinjam</th>
                                </tr>
                            </thead>
                            <tbody class="warna1">
                                <?php if (!empty($limabuku)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($limabuku as $data): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($data['f_judul']); ?></td>
                                            <td class="text-center">
                                                <?= htmlspecialchars($data['f_tanggalpeminjaman']); ?>
                                            </td>
                                            <td class="text-center">
                                                <?= htmlspecialchars($data['dipinjam']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            Belum ada data peminjaman buku.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- BUKU BELUM DIKEMBALIKAN -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h4 class="mb-0">Buku Belum Dikembalikan</h4>
                        <a href="../laporan/exportbukupinjam.php" class="btn btn-dark">
                            <i class="fa-solid fa-file-export me-2"></i>Export
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="warna">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Judul Buku</th>
                                    <th class="text-center">Jumlah Belum Dikembalikan</th>
                                </tr>
                            </thead>
                            <tbody class="warna1">
                                <?php if (!empty($bukubelumkembali)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($bukubelumkembali as $data): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($data['f_judul']); ?></td>
                                            <td class="text-center">
                                                <?= htmlspecialchars($data['jumlah_belum_kembali']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Tidak ada buku yang belum dikembalikan.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- ANGGOTA BELUM MENGEMBALIKAN BUKU -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h4 class="mb-0">Anggota yang Belum Mengembalikan Buku</h4>
                        <a href="../laporan/anggotabelumkembali.php" class="btn btn-dark">
                            <i class="fa-solid fa-file-export me-2"></i>Export
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="warna">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Anggota</th>
                                    <th class="text-center">Jumlah Buku Belum Kembali</th>
                                </tr>
                            </thead>
                            <tbody class="warna1">
                                <?php if (!empty($anggota)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($anggota as $data): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($data['f_nama']); ?></td>
                                            <td class="text-center">
                                                <?= htmlspecialchars($data['kembali']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Tidak ada anggota yang belum mengembalikan buku.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ANGGOTA PALING SERING MEMINJAM -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h4 class="mb-0">List Anggota Paling Sering Meminjam</h4>
                        <a href="../laporan/anggotaseringpinjam.php" class="btn btn-dark">
                            <i class="fa-solid fa-file-export me-2"></i>Export
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="warna">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Anggota</th>
                                    <th class="text-center">Jumlah Peminjaman</th>
                                </tr>
                            </thead>
                            <tbody class="warna1">
                                <?php if (!empty($limaanggota)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($limaanggota as $data): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($data['f_nama']); ?></td>
                                            <td class="text-center">
                                                <?= htmlspecialchars($data['pinjam']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Belum ada data peminjaman anggota.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>