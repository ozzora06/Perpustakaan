<?php

// PROSES TAMBAH DAN KURANG STOK
if (isset($_GET['updatestock']) && isset($_GET['idbuku'])) {

    $idbuku = (int) $_GET['idbuku'];
    $updatestock = $_GET['updatestock'];

    if ($updatestock == 'tambah') {

        // Menambah satu eksemplar
        $sql = "INSERT INTO t_detailbuku
                (f_id, f_idbuku, f_status)
                VALUES (NULL, '$idbuku', 'Tersedia')";

        $db->runSQL($sql);

    } elseif ($updatestock == 'kurang') {

        // Menghapus satu eksemplar yang tersedia
        $sql = "SELECT f_id FROM t_detailbuku
                WHERE f_idbuku='$idbuku'
                AND f_status='Tersedia'
                ORDER BY f_id DESC LIMIT 1";

        $idDihapus = $db->getITEM($sql);

        if ($idDihapus) {
            $sql = "DELETE FROM t_detailbuku
                    WHERE f_id=" . (int) $idDihapus['f_id'];

            $db->runSQL($sql);
        }
    }

    // Kembali ke halaman select
    echo "<script>
        window.location.assign('?f=buku&m=select');
    </script>";
    exit;
}


// PAGINATION
$jumlahdata = $db->rowCOUNT("SELECT f_id FROM t_buku");

$banyak = 5;
$halaman = ceil($jumlahdata / $banyak);

if (isset($_GET['p'])) {
    $p = (int) $_GET['p'];

    if ($p < 1) {
        $p = 1;
    }

    $mulai = ($p * $banyak) - $banyak;

} else {
    $p = 1;
    $mulai = 0;
}


// MENAMPILKAN DATA BUKU
$sql = "SELECT DISTINCT
        t_buku.f_id AS f_id,
        f_judul,
        f_kategori,
        f_pengarang,
        f_penerbit,
        f_deskripsi
        FROM t_buku
        INNER JOIN t_kategori
        ON t_buku.f_idkategori = t_kategori.f_id
        ORDER BY t_buku.f_id ASC
        LIMIT $mulai, $banyak";

$row = $db->getALL($sql);

$no = 1 + $mulai;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <style>
        .warna {
            background-color: #6096B4;
        }

        .warna1 {
            background-color: #F8EAD8;
        }
    </style>

</head>

<body>

    <strong>
        <center>
            <h2 style="font-family:Georgia, 'Times New Roman', Times, serif;">
                BUKU
            </h2>
            <hr>
        </center>
    </strong>

    <div class="mt-5">
        <div class="container">
            <div class="float-left mr-4">
                <a class="btn btn-dark" href="?f=buku&m=insert">
                    Add Buku
                </a>
            </div>
            <br>
            <table class="table table-bordered w-80" style="border-color: black">
                <thead class="text-center">
                    <tr class="warna">
                        <th>No</th>
                        <th>CATEGORY</th>
                        <th>JUDUL</th>
                        <th>PENGARANG</th>
                        <th>PENERBIT</th>
                        <th>DESKRIPSI</th>
                        <th>STOK</th>
                        <th>UPDATE</th>
                        <th>DELETE</th>
                    </tr>
                </thead>

                <tbody class="warna1" align="center">

                    <?php if (!empty($row)) { ?>

                        <?php foreach ($row as $r): ?>

                            <?php

                            // MENGHITUNG EKSEMPLAR TERSEDIA
                            $eksemplar = $db->rowCOUNT(
                                "SELECT f_id FROM t_detailbuku
                                WHERE f_status='Tersedia'
                                AND f_idbuku=" . (int) $r['f_id']
                            );

                            ?>

                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $r['f_kategori']; ?></td>
                                <td><?php echo $r['f_judul']; ?></td>
                                <td><?php echo $r['f_pengarang']; ?></td>
                                <td><?php echo $r['f_penerbit']; ?></td>
                                <td><?php echo $r['f_deskripsi']; ?></td>
                                <td>
                                    <nav aria-label="stock">
                                        <ul class="pagination justify-content-center mb-0">
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="?f=buku&m=select&idbuku=<?php echo $r['f_id']; ?>&updatestock=kurang">
                                                    -
                                                </a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">
                                                    <?php echo $eksemplar; ?>
                                                </a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="?f=buku&m=select&idbuku=<?php echo $r['f_id']; ?>&updatestock=tambah">
                                                    +
                                                </a>
                                            </li>

                                        </ul>
                                    </nav>
                                </td>
                                <td width="5%">
                                    <a class="btn btn-outline-warning" href="?f=buku&m=update&id=<?php echo $r['f_id']; ?>">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </td>
                                <td width="5%">
                                    <a class="btn btn-outline-danger" href="?f=buku&m=delete&id=<?php echo $r['f_id']; ?>">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>


<!-- PAGINATION -->

<nav aria-label="Pagination">
    <hr class="my-0" />

    <ul class="pagination my-4">

        <?php for ($i = 1; $i <= $halaman; $i++): ?>

            <li class="page-item">
                <a class="page-link" style="color:black;" href="?f=buku&m=select&p=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            </li>

        <?php endfor; ?>

    </ul>
</nav>