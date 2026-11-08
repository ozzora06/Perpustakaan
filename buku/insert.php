<?php
$t_kategori = $db->getALL("SELECT * FROM t_kategori");
?>

<div class="mt-3">
    <div class="container">
        <h3 style="font-family:Georgia, 'Times New Roman', Times, serif;">
            Insert Buku
        </h3>
        <hr>

        <div class="form-group">
            <form action="" method="post">

                <div class="form-group w-50 mt-2">
                    <label>Kategori</label>
                    <select class="form-control" name="f_kategori" required>
                        <option value="" disabled selected>Pilih...</option>

                        <?php foreach ($t_kategori as $isi): ?>
                            <option value="<?php echo $isi['f_id']; ?>">
                                <?php echo $isi['f_kategori']; ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group w-50 mt-2">
                    <label>Judul Buku</label>
                    <input type="text" name="f_judul" required class="form-control">
                </div>

                <div class="form-group w-50 mt-2">
                    <label>Pengarang</label>
                    <input type="text" name="f_pengarang" required class="form-control">
                </div>

                <div class="form-group w-50 mt-2">
                    <label>Penerbit</label>
                    <input type="text" name="f_penerbit" required class="form-control">
                </div>

                <div class="form-group w-50 mt-2">
                    <label>Deskripsi</label>
                    <textarea name="f_deskripsi" required class="form-control"></textarea>
                </div>

                <div class="form-group w-50 mt-2">
                    <label>Jumlah Eksemplar</label>
                    <input type="number" name="eksemplar" min="1" required class="form-control">
                </div>

                <br>
                <div class="w-50 d-flex gap-2">
                    <a href="?f=buku&m=select" class="btn btn-secondary flex-fill">
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
</div>

<?php
if (isset($_POST['simpan'])) {

    $kategori = $_POST['f_kategori'];
    $judul = $_POST['f_judul'];
    $pengarang = $_POST['f_pengarang'];
    $penerbit = $_POST['f_penerbit'];
    $deskripsi = $_POST['f_deskripsi'];
    $eksemplar = (int) $_POST['eksemplar'];

    // Insert data buku
    $sql = "INSERT INTO t_buku
            (f_id, f_idkategori, f_judul, f_pengarang, f_penerbit, f_deskripsi)
            VALUES
            (NULL, '$kategori', '$judul', '$pengarang', '$penerbit', '$deskripsi')";

    $db->runSQL($sql);

    // Ambil ID buku terakhir
    $t_bukuterakhir = $db->getITEM(
        "SELECT f_id FROM t_buku ORDER BY f_id DESC LIMIT 1"
    );

    $idbukuterakhir = $t_bukuterakhir['f_id'];

    // Insert detail buku sesuai jumlah eksemplar
    for ($i = 0; $i < $eksemplar; $i++) {

        $sql = "INSERT INTO t_detailbuku
                (f_id, f_idbuku, f_status)
                VALUES
                (NULL, '$idbukuterakhir', 'Tersedia')";

        $db->runSQL($sql);
    }

    echo "<script>
        alert('Data buku berhasil ditambahkan!');
        window.location.assign('?f=buku&m=select');
    </script>";
}
?>