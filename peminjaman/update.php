<?php
if (!isset($_GET['idpem']) || !isset($_GET['idbuku'])) {
    echo "ID peminjaman tidak ditemukan.";
    exit;
}

$idborrow = (int) $_GET['idpem'];
$idbuku = (int) $_GET['idbuku'];

// Ambil data peminjaman
$itemold = $db->getITEM("
    SELECT
        t_detailpeminjaman.f_iddetailbuku,
        t_peminjaman.f_idanggota,
        t_peminjaman.f_idadmin,
        t_peminjaman.f_tanggalpeminjaman
    FROM t_peminjaman
    INNER JOIN t_detailpeminjaman
        ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
    WHERE t_peminjaman.f_id = $idborrow
");

if (!$itemold || (int) $itemold['f_iddetailbuku'] !== $idbuku) {
    echo "Data peminjaman tidak ditemukan atau tidak sesuai.";
    exit;
}

// Ambil data admin
$itema = $db->getALL("
    SELECT * FROM t_admin ORDER BY f_nama ASC
");

// Ambil data anggota
$itemm = $db->getALL("
    SELECT * FROM t_anggota ORDER BY f_nama ASC
");

// Ambil buku tersedia dan buku yang sedang dipinjam
$itemb = $db->getALL("
    SELECT
        t_detailbuku.f_id AS idbookdetail,
        t_buku.f_judul
    FROM t_detailbuku
    INNER JOIN t_buku
        ON t_detailbuku.f_idbuku = t_buku.f_id
    WHERE t_detailbuku.f_status = 'Tersedia'
       OR t_detailbuku.f_id = $idbuku
    ORDER BY t_buku.f_judul ASC
");
?>
<div class="container">
    <h4 style="font-family:Georgia, 'Times New Roman', Times, serif;">
        EDIT PEMINJAMAN
    </h4>
    <hr>
    <form action="" method="post">
        <div class="form-group w-50">
            <label class="mb-2 mt-2">Anggota</label>
            <select class="form-control" name="member" required>
                <?php foreach ($itemm as $c): ?>
                    <option value="<?= $c['f_id'] ?>" <?= ($itemold['f_idanggota'] == $c['f_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['f_nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="mb-2 mt-2">Judul Buku</label>
            <select class="form-control" name="book" required>
                <?php foreach ($itemb as $c): ?>
                    <option value="<?= $c['idbookdetail'] ?>" <?= ($idbuku == $c['idbookdetail']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['f_judul']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="mb-2 mt-2">Admin</label>
            <select class="form-control" name="admin" required>
                <?php foreach ($itema as $c): ?>
                    <option value="<?= $c['f_id'] ?>" <?= ($itemold['f_idadmin'] == $c['f_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['f_nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="mb-2 mt-2">Tanggal Peminjaman</label>
            <input type="date" class="form-control" name="borrowdate"
                value="<?= htmlspecialchars($itemold['f_tanggalpeminjaman']) ?>" required>
        </div>
        <br>
        <div class="w-50 d-flex gap-2">
            <a href="?f=peminjaman&m=select" class="btn btn-secondary flex-fill">
                Kembali
            </a>
            <button type="submit" name="change" value="change" class="btn btn-warning flex-fill">
                <i class="bi bi-save me-1"></i>
                Update
            </button>
        </div>
    </form>
</div>

<?php

if (isset($_POST['change'])) {

    $member = (int) $_POST['member'];
    $book = (int) $_POST['book'];
    $admin = (int) $_POST['admin'];
    $borrowdate = $_POST['borrowdate'];

    $tanggalValid = DateTime::createFromFormat('Y-m-d', $borrowdate);

    if (
        !$tanggalValid ||
        $tanggalValid->format('Y-m-d') !== $borrowdate
    ) {

        echo "<script>alert('Tanggal tidak valid!');</script>";

    } else {

        // Pastikan buku tersedia atau merupakan buku lama
        $cekBuku = $db->getITEM("
            SELECT f_id
            FROM t_detailbuku
            WHERE f_id=$book
            AND (f_status='Tersedia' OR f_id=$idbuku)
        ");

        $cekAdmin = $db->getITEM("
            SELECT f_id FROM t_admin WHERE f_id=$admin
        ");

        $cekAnggota = $db->getITEM("
            SELECT f_id FROM t_anggota WHERE f_id=$member
        ");

        if (!$cekBuku || !$cekAdmin || !$cekAnggota) {

            echo "<script>
                alert('Data admin, anggota, atau buku tidak valid!');
            </script>";

        } else {

            // Update data peminjaman
            $db->runSQL("
                UPDATE t_peminjaman SET
                    f_idadmin=$admin,
                    f_idanggota=$member,
                    f_tanggalpeminjaman='$borrowdate'
                WHERE f_id=$idborrow
            ");

            $oldidbuku = (int) $itemold['f_iddetailbuku'];

            // Jika buku diganti
            if ($oldidbuku != $book) {

                // Buku lama menjadi tersedia
                $db->runSQL("
                    UPDATE t_detailbuku
                    SET f_status='Tersedia'
                    WHERE f_id=$oldidbuku
                ");

                // Update detail peminjaman
                $db->runSQL("
                    UPDATE t_detailpeminjaman
                    SET f_iddetailbuku=$book
                    WHERE f_idpeminjaman=$idborrow
                ");

                // Buku baru menjadi tidak tersedia
                $db->runSQL("
                    UPDATE t_detailbuku
                    SET f_status='Tidak Tersedia'
                    WHERE f_id=$book
                ");

            }

            echo "<script>
                window.location.assign('?f=peminjaman&m=select&p=1');
            </script>";

        }
    }
}

?>