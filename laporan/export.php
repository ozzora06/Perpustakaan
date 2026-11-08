<?php

require_once '../dbcontroller.php';
$db = new dbController;

$sql = "SELECT t_peminjaman.f_id AS idp, t_buku.f_judul, t_kategori.f_kategori, t_admin.f_nama,t_detailpeminjaman.f_tanggalkembali AS admin, t_anggota.f_nama AS anggota,t_peminjaman.f_tanggalpeminjaman,t_detailpeminjaman.f_tanggalkembali 
    FROM t_peminjaman
    INNER JOIN t_admin ON t_peminjaman.f_idadmin=t_admin.f_id
    INNER JOIN t_anggota ON t_peminjaman.f_idanggota=t_anggota.f_id
    INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id=t_detailpeminjaman.f_idpeminjaman
    INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku=t_detailbuku.f_id
    INNER JOIN t_buku ON t_detailbuku.f_idbuku=t_buku.f_id
    INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id               
     WHERE t_anggota.f_id =$ida;";
$row = $db->getALL($sql);
$no = 1;
?>

<style>
    .w {
        border: solid black;
        padding: 1px;
    }
</style>

<table class='w table w-100'>
    <thead class='w table-primary'>
        <tr>
            <th>No</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Admin</th>
                        <th>Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <!-- <th>Update</th> -->
                        <!-- <th>Delete</th> -->
                    </tr>

                    <tbody >
                        <?php if (!empty($row)) { ?>
                            <?php foreach ($row as $r) : ?>
                                <tr class="warna1">
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $r['f_judul'] ?></td>
                                    <td><?php echo $r['f_kategori'] ?></td>
                                    <td><?php echo $r['admin'] ?></td>
                                    <td><?php echo $r['anggota'] ?></td>
                                    <td><?php echo $r['f_tanggalpeminjaman'] ?></td>                        
                                <td> <?php
                            if ($r['f_tanggalkembali'] == '0000-00-00') {
                                echo "Belum Kembali";
                            } else {
                                echo $r['f_tanggalkembali'];
                            } ?>    <td>
                        <?php
                        if ($r['f_tanggalkembali'] == '0000-00-00') {
  
                            echo "<p type='text' >Belum Kembali</p></a>";
                        } else {
                            echo "<p type='text'>Sudah Kembali</p>";
                        } ?></td>
                                    <!-- <td><a style="color:white;" type="button" class="btn btn-warning" class="nav-link" href="?f=peminjaman&m=update&id=<?php echo $r['idp'] ?>">Update</a></button></td> -->
                                    <!-- <td><a style="color:white;" type="button" class="btn btn-danger" class="nav-link" href="?f=peminjaman&m=delete&id=<?php echo $r['idp'] ?>">Delete</a></button></td> -->
                                </tr>
                            <?php endforeach ?>
                        <?php } ?>
    </tbody>
</table>