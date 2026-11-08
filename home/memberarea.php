<?php
$ida = $_SESSION['id'];

$sql = "SELECT t_peminjaman.f_id AS idp, t_buku.f_judul, t_kategori.f_kategori, t_admin.f_nama  AS admin,t_detailpeminjaman.f_tanggalkembali, t_anggota.f_nama AS anggota,t_peminjaman.f_tanggalpeminjaman,t_detailpeminjaman.f_tanggalkembali 
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

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .warna {
            background-color:#6096B4 ;
        }
        p{
          color: black;
        }
        .warna1 {
            background-color:#F8EAD8 ;
        }

        .button-get-plan {
      display: flex;
      justify-content: center;
      margin-top: 1.2rem;
    }

    .button-get-plan a {
      display: flex;
      justify-content: center;
      align-items: center;
      background: #6096B4;
      color: #fff;
      padding: 10px 15px;
      border-radius: 5px;
      text-decoration: none;
      font-size: .8rem;
      letter-spacing: .05rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .button-get-plan a:hover {
      transform: translateY(-3%);
      box-shadow: 0 3px 10px rgba(207, 212, 222, 0.9);
    }

    .button-get-plan .svg-rocket {
      margin-right: 10px;
      width: .9rem;
      fill: currentColor;
    }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERPUSTAKAAN</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
</head>

<body>
    <form id="compose" name="compose" method="post" action="" enctype="multipart/form-data">
        <strong>
            <center>
                <h2 style="font-family:Georgia, 'Times New Roman', Times, serif; color: white;">PEMINJAMAN</h2>
                <hr>
            </center>
        </strong>
        <div class="mt-5">
            <div class="container">
                <table class="table table-bordered w-80">
                    <tr class="warna">
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
                <div class="button-get-plan">
                <a class="nav-link active" href="home/export.php">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-rocket">
                        <path d="M156.6 384.9L125.7 353.1C117.2 345.5 114.2 333.1 117.1 321.8C120.1 312.9 124.1 301.3 129.8 288H24C15.38 288 7.414 283.4 3.146 275.9C-1.123 268.4-1.042 259.2 3.357 251.8L55.83 163.3C68.79 141.4 92.33 127.1 117.8 127.1H200C202.4 124 204.8 120.3 207.2 116.7C289.1-4.07 411.1-8.142 483.9 5.275C495.6 7.414 504.6 16.43 506.7 28.06C520.1 100.9 516.1 222.9 395.3 304.8C391.8 307.2 387.1 309.6 384 311.1V394.2C384 419.7 370.6 443.2 348.7 456.2L260.2 508.6C252.8 513 243.6 513.1 236.1 508.9C228.6 504.6 224 496.6 224 488V380.8C209.9 385.6 197.6 389.7 188.3 392.7C177.1 396.3 164.9 393.2 156.6 384.9V384.9zM384 167.1C406.1 167.1 424 150.1 424 127.1C424 105.9 406.1 87.1 384 87.1C361.9 87.1 344 105.9 344 127.1C344 150.1 361.9 167.1 384 167.1z"></path>
                    </svg>
                    <span>EXPORT</span>
                </a>
        </div>
    </form>
</body>

</html>