<?php

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>
        alert('ID kategori tidak valid!');
        window.location='?f=kategori&m=select';
    </script>";
    exit;
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM t_kategori WHERE f_id = $id";
$row = $db->getITEM($sql);

if (!$row) {
    echo "<script>
        alert('Data kategori tidak ditemukan!');
        window.location='?f=kategori&m=select';
    </script>";
    exit;
}

if (isset($_POST['simpan'])) {

    $f_kategori = trim($_POST['f_kategori']);

    if ($f_kategori == '') {
        echo "<script>alert('Kategori tidak boleh kosong!');</script>";
    } else {

        $f_kategori = addslashes($f_kategori);

        $sql = "UPDATE t_kategori
                SET f_kategori = '$f_kategori'
                WHERE f_id = $id";

        $db->runSQL($sql);

        echo "<script>
            alert('Kategori berhasil diperbarui!');
            window.location='?f=kategori&m=select';
        </script>";

        exit;
    }
}

?>

<div class="mt-3">
    <div class="container">

        <h3 style="font-family:Georgia, 'Times New Roman', Times, serif;">
            Update Kategori
        </h3>

        <div class="form-group">

            <form action="" method="post">

                <div class="form-group w-50">

                    <label for="f_kategori">Kategori</label>

                    <input type="text" name="f_kategori" id="f_kategori" required
                        value="<?= htmlspecialchars($row['f_kategori'], ENT_QUOTES, 'UTF-8') ?>" class="form-control">
                </div>
                <br>
                <div class="w-50 d-flex gap-2">
                    <a href="?f=kategori&m=select" class="btn btn-secondary flex-fill">
                        Kembali
                    </a>
                    <button type="submit" name="simpan" value="simpan" class="btn btn-warning flex-fill">
                        <i class="bi bi-save me-1"></i>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>