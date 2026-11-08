<?php

$jumlahdata = $db->rowCOUNT("
    SELECT t_detailpeminjaman.f_id
    FROM t_peminjaman
    INNER JOIN t_detailpeminjaman
        ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
    INNER JOIN t_detailbuku
        ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
    INNER JOIN t_buku
        ON t_detailbuku.f_idbuku = t_buku.f_id
    INNER JOIN t_kategori
        ON t_buku.f_idkategori = t_kategori.f_id
");

$banyak = 5;
$halaman = ceil($jumlahdata / $banyak);

$p = isset($_GET['p']) ? max(1, (int) $_GET['p']) : 1;
$p = min($p, max(1, $halaman));

$mulai = ($p - 1) * $banyak;

$sql = "SELECT
    t_anggota.f_nama AS f_namaanggota,
    t_kategori.f_kategori,
    t_peminjaman.f_id,
    t_peminjaman.f_tanggalpeminjaman,
    t_detailpeminjaman.f_tanggalkembali,
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

    ORDER BY t_peminjaman.f_id ASC
    LIMIT $mulai, $banyak";

$row = $db->getALL($sql);

$no = 1 + $mulai;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PERPUSTAKAAN</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <style>
        .warna {
            background-color: #6096B4;
        }

        .warna1 {
            background-color: #F8EAD8;
        }

        th,
        td {
            border: 1px solid black;
        }

        .pagination .page-link {
            color: black;
            background-color: white;
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.active .page-link {
            color: black;
            background-color: white;
            border-color: #dee2e6;
        }

        .pagination .page-link:hover {
            color: black;
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="mt-5">
        <div class="container">
            <center>
                <h2 style="font-family:Georgia, 'Times New Roman', Times, serif;">
                    PEMINJAMAN
                </h2>
                <hr>
            </center>
            <div class="mb-3">
                <a class="btn btn-dark" href="?f=peminjaman&m=insert">
                    Add Peminjaman
                </a>
            </div>
            <table class="table table-bordered w-100" style="border-color:black">
                <thead class="warna" align="center">
                    <tr>
                        <th>NO</th>
                        <th>ANGGOTA</th>
                        <th>TANGGAL PEMINJAMAN</th>
                        <th>TANGGAL PENGEMBALIAN</th>
                        <th>KATEGORI</th>
                        <th>JUDUL BUKU</th>
                        <th>ADMIN</th>
                        <th>UPDATE</th>
                    </tr>
                </thead>
                <tbody class="warna1" align="center">
                    <?php if (!empty($row)): ?>
                        <?php foreach ($row as $r): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($r['f_namaanggota']) ?></td>
                                <td><?= htmlspecialchars($r['f_tanggalpeminjaman']) ?></td>
                                <td>
                                    <?php
                                    if (
                                        empty($r['f_tanggalkembali']) ||
                                        $r['f_tanggalkembali'] == '0000-00-00'
                                    ) {
                                        echo '<span class="badge bg-danger">Belum Kembali</span>';
                                    } else {
                                        echo htmlspecialchars($r['f_tanggalkembali']);
                                    }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($r['f_kategori']) ?></td>
                                <td><?= htmlspecialchars($r['f_judul']) ?></td>
                                <td><?= htmlspecialchars($r['f_namaadmin']) ?></td>
                                <td>
                                    <a class="btn btn-outline-warning"
                                        href="?f=peminjaman&m=update&idpem=<?= (int) $r['f_id'] ?>&idbuku=<?= (int) $r['f_iddetb'] ?>">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">Data peminjaman belum tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <nav aria-label="Pagination">
                <hr>
                <ul class="pagination my-4">
                    <?php for ($i = 1; $i <= $halaman; $i++): ?>

                        <li class="page-item <?= ($i == $p) ? 'active' : '' ?>">
                            <a class="page-link" href="?f=peminjaman&m=select&p=<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>

                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>

</body>

</html>