
<?php

$jumlahdata = $db->rowCOUNT("SELECT f_id FROM t_anggota");
$banyak = 5;

$halaman = ceil($jumlahdata / $banyak);

if (isset($_GET['p'])) {
    $p = $_GET['p'];
    $mulai = ($p * $banyak) - $banyak;
} else {
    $mulai = 0;
}

$sql = "SELECT * FROM t_anggota ORDER BY f_id ASC LIMIT $mulai,$banyak";
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

        th, td {
            border: 1px solid black;
        }
    </style>
</head>

<body>

    <div class="mt-5">
        <div class="container">

            <center>
                <h2 style="font-family:Georgia, 'Times New Roman', Times, serif;">
                    ANGGOTA
                </h2>
                <hr>
            </center>

            <div class="mb-3">
                <a class="btn btn-dark" href="?f=anggota&m=insert">
                    Add Anggota
                </a>
            </div>

            <table class="table table-bordered w-100" style="border-color:black">

                <thead class="warna" align="center">
                    <tr>
                        <th>NO</th>
                        <th>NAMA</th>
                        <th>USERNAME</th>
                        <th>PASSWORD</th>
                        <th>TEMPAT LAHIR</th>
                        <th>TANGGAL LAHIR</th>
                        <th>UPDATE</th>
                        <th>DELETE</th>
                    </tr>
                </thead>

                <tbody class="warna1" align="center">

                    <?php if (!empty($row)) { ?>

                        <?php foreach ($row as $r) : ?>

                            <tr>
                                <td><?php echo $no++; ?></td>

                                <td><?php echo htmlspecialchars($r['f_nama']); ?></td>

                                <td><?php echo htmlspecialchars($r['f_username']); ?></td>

                                <td>************************</td>

                                <td><?php echo htmlspecialchars($r['f_tempatlahir']); ?></td>

                                <td><?php echo htmlspecialchars($r['f_tangallahir']); ?></td>

                                <td>
                                    <a href="?f=anggota&m=update&id=<?php echo $r['f_id']; ?>"
                                       class="btn btn-outline-warning">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </td>

                                <td>
                                    <a href="?f=anggota&m=delete&id=<?php echo $r['f_id']; ?>"
                                       class="btn btn-danger">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php } else { ?>

                        <tr>
                            <td colspan="8">Data anggota belum tersedia.</td>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>

        </div>
    </div>

    <nav aria-label="Pagination">
        <hr>
        <ul class="pagination my-4">

            <?php
            for ($i = 1; $i <= $halaman; $i++) {
                echo '<li class="page-item">
                <a class="page-link" style="color:black;"
                href="?f=anggota&m=select&p=' . $i . '">' . $i . '</a>
                </li>';
            }
            ?>

        </ul>
    </nav>

</body>
</html>
