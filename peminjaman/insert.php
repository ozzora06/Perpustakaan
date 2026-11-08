<script src="../chosen/docsupport/jquery-1.12.4.min.js"></script>
<script src="../chosen/chosen.jquery.js"></script>
<link rel="stylesheet" href="../chosen/chosen.css">

<script>
     $(function () {
          $(".chzn-select").chosen();
     });
</script>

<?php
$admin = $db->getALL("SELECT * FROM t_admin ORDER BY f_nama ASC");
$anggota = $db->getALL("SELECT * FROM t_anggota ORDER BY f_nama ASC");

$buku = $db->getALL("
    SELECT
        t_detailbuku.f_id AS f_iddetailbuku,
        t_buku.f_judul
    FROM t_buku
    INNER JOIN t_detailbuku
        ON t_buku.f_id = t_detailbuku.f_idbuku
    WHERE t_detailbuku.f_status = 'Tersedia'
    ORDER BY t_buku.f_judul ASC
");
?>

<div class="mt-3">
     <div class="container">

          <h3 style="font-family:Georgia, 'Times New Roman', Times, serif;">
               INSERT PEMINJAMAN
          </h3>
          <hr>

          <form action="" method="post">

               <div class="form-group w-50 mt-3">
                    <label>Admin</label>
                    <select name="f_idadmin" class="form-control" required>
                         <?php foreach ($admin as $r): ?>
                              <option value="<?= $r['f_id'] ?>">
                                   <?= htmlspecialchars($r['f_nama']) ?>
                              </option>
                         <?php endforeach; ?>
                    </select>
               </div>

               <div class="form-group w-50 mt-3">
                    <label>Anggota</label>
                    <select name="f_idanggota" class="form-control" required>
                         <?php foreach ($anggota as $r): ?>
                              <option value="<?= $r['f_id'] ?>">
                                   <?= htmlspecialchars($r['f_nama']) ?>
                              </option>
                         <?php endforeach; ?>
                    </select>
               </div>

               <div class="form-group w-50 mt-3">
                    <label>Judul Buku</label>
                    <select name="judulbuku" class="chzn-select form-control" required>
                         <?php foreach ($buku as $r): ?>
                              <option value="<?= $r['f_iddetailbuku'] ?>">
                                   <?= htmlspecialchars($r['f_judul']) ?>
                              </option>
                         <?php endforeach; ?>
                    </select>
               </div>

               <div class="form-group w-50 mt-3">
                    <label>Tanggal Peminjaman</label>
                    <input type="date" name="f_tanggalpeminjaman" class="form-control" value="<?= date('Y-m-d') ?>"
                         required>
               </div>
               <br>
               <div class="w-50 d-flex gap-2">
                <a href="?f=peminjaman&m=select" class="btn btn-secondary flex-fill">
                    Kembali
                </a>
                <button type="submit" name="simpan" value="simpan" class="btn btn-success flex-fill">
                    <i class="bi bi-save me-1"></i>
                    Simpan
                </button>
            </div>
          </form>
     </div>
</div>

<?php
if (isset($_POST['simpan'])) {

     $admin = (int) $_POST['f_idadmin'];
     $anggota = (int) $_POST['f_idanggota'];
     $judulbuku = (int) $_POST['judulbuku'];
     $tgl = $_POST['f_tanggalpeminjaman'];

     $tanggalValid = DateTime::createFromFormat('Y-m-d', $tgl);

     if (
          !$tanggalValid ||
          $tanggalValid->format('Y-m-d') !== $tgl
     ) {
          echo "<script>alert('Tanggal peminjaman tidak valid!');</script>";
     } else {

          // Periksa admin dan anggota
          $cekAdmin = $db->getITEM(
               "SELECT f_id FROM t_admin WHERE f_id=$admin"
          );

          $cekAnggota = $db->getITEM(
               "SELECT f_id FROM t_anggota WHERE f_id=$anggota"
          );

          // Periksa ketersediaan buku
          $cekBuku = $db->getITEM("
            SELECT f_id FROM t_detailbuku
            WHERE f_id=$judulbuku
            AND f_status='Tersedia'
        ");

          if (!$cekAdmin || !$cekAnggota || !$cekBuku) {

               echo "<script>
                alert('Admin, anggota, atau buku tidak valid!');
            </script>";

          } else {

               // Simpan peminjaman
               $sql = "INSERT INTO t_peminjaman
                (f_idadmin, f_idanggota, f_tanggalpeminjaman)
                VALUES
                ($admin, $anggota, '$tgl')";

               $db->runSQL($sql);

               // Ambil ID peminjaman yang baru dibuat
               $idpeminjamanterakhir = $db->getITEM(
                    "SELECT LAST_INSERT_ID() AS idterakhir"
               );

               $idterakhir = (int) $idpeminjamanterakhir['idterakhir'];

               if ($idterakhir > 0) {

                    // Simpan detail peminjaman
                    $sql = "INSERT INTO t_detailpeminjaman
                    (f_idpeminjaman, f_iddetailbuku, f_tanggalkembali)
                    VALUES
                    ($idterakhir, $judulbuku, '')";

                    $db->runSQL($sql);

                    // Ubah status buku
                    $sql = "UPDATE t_detailbuku
                    SET f_status='Tidak Tersedia'
                    WHERE f_id=$judulbuku";

                    $db->runSQL($sql);

                    echo "<script>
                    window.location.assign('?f=peminjaman&m=select');
                </script>";

               } else {
                    echo "<script>
                    alert('Gagal mendapatkan ID peminjaman!');
                </script>";
               }
          }
     }
}
?>