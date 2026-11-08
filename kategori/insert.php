
<?php
if (isset($_POST['simpan'])) {

    // Inisialisasi
    $kategori = $_POST['kategori'];

    // Insert kategori
    $sql = "INSERT INTO t_kategori (f_id, f_kategori)
            VALUES (NULL, '$kategori')";

    $db->runSQL($sql);

    // Redirect
    echo "<script>
        alert('Kategori berhasil ditambahkan!');
        window.location.assign('?f=kategori&m=select');
    </script>";

    exit;
}
?>

<div class="mt-3">
    <div class="container">

        <h3 style="font-family:Georgia, 'Times New Roman', Times, serif;">
            Insert Kategori
        </h3>

        <hr>

        <div class="form-group">

            <form action="" method="post">

                <div class="form-group w-50">
                    <label>Kategori</label>

                    <input
                        type="text"
                        name="kategori"
                        required
                        class="form-control">
                </div>
                <br>
                <div class="w-50 d-flex gap-2">
                <a href="?f=kategori&m=select" class="btn btn-secondary flex-fill">
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
