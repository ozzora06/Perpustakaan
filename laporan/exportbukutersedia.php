<?php

require_once '../dbcontroller.php';
$db = new dbcontroller;

//header("Content-type: application/vnd-ms-excel");
//header("Content-Disposition: attachment; filename=Buku Tersedia.xls");

$sql = "SELECT t_detailbuku.f_id AS iddetailbuku, t_buku.f_id as idbuku , f_judul, f_kategori, f_pengarang, f_penerbit, f_deskripsi FROM t_buku 
INNER JOIN t_kategori ON t_buku.f_idkategori=t_kategori.f_id
LEFT JOIN t_detailbuku ON t_buku.f_id = t_detailbuku.f_idbuku WHERE f_status='Tersedia'
GROUP BY t_buku.f_id ORDER BY t_detailbuku.f_id ASC";
$row = $db->getAll($sql);
$no = 1;
?>

<style>
    .w {
        border: solid black;
        padding: 1px;
    }
</style>

<script>
    window.print();
</script>

<table class='w table w-100'>
    <thead class='w table-primary'>
        <tr>
            <th class="w">No</th>
            <th class="w">Judul</th>
            <th class="w">Pengarang</th>
            <th class="w">Penerbit</th>
            <th class="w">Deskripsi</th>
            <th class="w">Kategori</th>
            <th class="w">Stok</th>
        </tr>
    </thead>
    <tbody>

            <?php foreach ($row as $r) : ?>
                <tr>
                    <td class="w"> <?php echo $no++ ?> </td>
                    <td class="w"> <?php echo $r['f_judul'] ?> </td>
                    <td class="w"> <?php echo $r['f_pengarang'] ?> </td>
                    <td class="w"> <?php echo $r['f_penerbit'] ?> </td>
                    <td class="w"> <?php echo $r['f_deskripsi'] ?> </td>
                    <td class="w"> <?php echo $r['f_kategori'] ?> </td>
                    <td class="w"><?php
                                    $eksemplar = $db->rowCount("SELECT * FROM `t_detailbuku` WHERE f_status='Tersedia' AND `f_idbuku` = " . $r['idbuku'] . "");
                                    echo $eksemplar;
                                    ?>
                    </td>
                </tr>
            <?php endforeach ?>
    </tbody>
</table>