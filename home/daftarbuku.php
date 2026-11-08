<?php

$sql = "SELECT DISTINCT t_buku.f_id as f_id, f_judul, f_kategori, f_pengarang, f_penerbit, f_deskripsi FROM t_buku
INNER JOIN t_kategori ON t_buku.f_idkategori=t_kategori.f_id
LEFT JOIN t_detailbuku ON t_buku.f_id=t_detailbuku.f_idbuku WHERE f_status='Tersedia'";
$row = $db->getALL($sql);
$no = 1;

?>

<strong>
    <center>
        <h2 style="font-family:Georgia, 'Times New Roman', Times, serif;">BUKU<i class="bi bi-journal-bookmark-fill mx-2"></i></h2>
        <hr>
        <hr>
    </center>
</strong>
<div class="mt-5">
    <div class="container">
        <table class="table table-bordered w-80">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
                </tr>

            </thead>

            <tbody class="warna1">
                <?php if (!empty($row)) { ?>
                    <?php foreach ($row as $r) : ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $r['f_kategori'] ?></td>
                            <td><?php echo $r['f_judul'] ?></td>
                            <td><?php echo $r['f_pengarang'] ?></td>
                            <td><?php echo $r['f_penerbit'] ?></td>
                            <td><?php echo $r['f_deskripsi'] ?></td>
                            <td><?php
                                $eksemplar = $db->rowCOUNT("SELECT * FROM t_detailbuku WHERE f_status='tersedia' AND
                    f_idbuku = " . $r['f_id'] . "");
                                echo $eksemplar;
                                ?></td>

                        </tr>
                    <?php endforeach ?>

                <?php } ?>
            </tbody>
        </table>
    </div>
</div>