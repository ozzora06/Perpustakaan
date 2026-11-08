<?php
session_start();
require_once "dbcontroller.php";
$db = new dbcontroller;

if (isset($_GET['log'])) {
    unset($_SESSION['id']);
    header("location:index.php");
    exit;
}

// Ambil data buku langsung dari database
$sql = "SELECT DISTINCT
            t_buku.f_id AS f_id,
            f_judul,
            f_kategori,
            f_pengarang,
            f_penerbit,
            f_deskripsi
        FROM t_buku
        INNER JOIN t_kategori
            ON t_buku.f_idkategori = t_kategori.f_id
        LEFT JOIN t_detailbuku
            ON t_buku.f_id = t_detailbuku.f_idbuku
        WHERE f_status = 'Tersedia'
        ORDER BY t_buku.f_id DESC";

$buku = $db->getALL($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PERPUSNAS - Perpustakaan Digital</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fb;
            color: #243447;
        }

        /* NAVBAR */
        .navbar {
            background: #244c70;
            padding: 15px 5%;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-size: 23px;
            font-weight: 800;
            letter-spacing: 1px;
            color: white !important;
        }

        .navbar-brand i {
            color: #f5d58b;
        }

        .nav-link {
            color: white !important;
            font-size: 14px;
            font-weight: 500;
            margin-left: 15px;
            transition: .3s;
        }

        .nav-link:hover {
            color: #f5d58b !important;
        }

        /* HERO */
        .hero {
            min-height: 420px;
            display: flex;
            align-items: center;
            background:
                linear-gradient(90deg,
                    rgba(20, 48, 73, .95),
                    rgba(20, 48, 73, .65)),
                url('bg1.jpg');

            background-position: center;
            background-size: cover;
            padding: 70px 8%;
            color: white;
        }

        .hero-content {
            max-width: 650px;
        }

        .hero-label {
            display: inline-block;
            background: rgba(245, 213, 139, .2);
            color: #f5d58b;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-size: clamp(32px, 5vw, 55px);
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .hero h1 span {
            color: #f5d58b;
        }

        .hero p {
            font-size: 15px;
            color: #e2eaf1;
            line-height: 1.8;
            max-width: 550px;
        }

        .hero-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 13px 28px;
            background: #f5d58b;
            color: #244c70;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            transition: .3s;
        }

        .hero-btn:hover {
            background: white;
            color: #244c70;
            transform: translateY(-3px);
        }

        /* SECTION BUKU */
        .book-section {
            padding: 65px 7%;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-header small {
            color: #d29b43;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .section-header h2 {
            font-size: 32px;
            font-weight: 800;
            color: #244c70;
            margin-top: 10px;
        }

        .section-header p {
            color: #8492a2;
            font-size: 14px;
        }

        /* CARD BUKU */
        .book-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            height: 100%;
            border: 1px solid #e8edf3;
            box-shadow: 0 5px 20px rgba(30, 60, 90, .06);
            transition: .3s;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(30, 60, 90, .13);
        }

        .book-cover {
            height: 155px;
            background: linear-gradient(135deg, #244c70, #6096B4);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .book-cover i {
            font-size: 65px;
            color: #f5d58b;
        }

        .book-number {
            position: absolute;
            top: 13px;
            left: 15px;
            background: rgba(255, 255, 255, .2);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
        }

        .book-content {
            padding: 22px;
        }

        .book-category {
            display: inline-block;
            background: #eaf3f9;
            color: #39779f;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 20px;
            margin-bottom: 13px;
        }

        .book-content h5 {
            color: #244c70;
            font-size: 17px;
            font-weight: 700;
            line-height: 1.5;
            margin-bottom: 13px;
            min-height: 50px;
        }

        .book-info {
            font-size: 12px;
            color: #7c8997;
            margin-bottom: 8px;
        }

        .book-info i {
            color: #6096B4;
            width: 20px;
        }

        .book-description {
            font-size: 12px;
            color: #8995a1;
            line-height: 1.7;
            margin-top: 15px;
            min-height: 60px;
        }

        .book-footer {
            border-top: 1px solid #edf0f4;
            padding-top: 15px;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stock-label {
            font-size: 11px;
            color: #7c8997;
        }

        .stock-number {
            color: #24966c;
            font-size: 14px;
            font-weight: 700;
        }

        .stock-number.empty {
            color: #dc5555;
        }

        /* EMPTY STATE */
        .empty-book {
            background: white;
            padding: 55px 20px;
            border-radius: 15px;
            text-align: center;
            color: #8995a1;
        }

        .empty-book i {
            font-size: 55px;
            color: #6096B4;
        }

        /* FOOTER */
        footer {
            background: #244c70;
            color: white;
            text-align: center;
            padding: 25px 10px;
            font-size: 12px;
        }

        footer span {
            color: #f5d58b;
        }

        @media(max-width: 768px) {
            .hero {
                min-height: 350px;
                padding: 55px 7%;
            }

            .hero h1 {
                font-size: 34px;
            }

            .book-section {
                padding: 45px 5%;
            }

            .section-header h2 {
                font-size: 25px;
            }

            .navbar {
                padding: 12px 4%;
            }

            .nav-link {
                margin-left: 0;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">

            <a href="index.php" class="navbar-brand">
                <i class="bi bi-book-half me-2"></i> PERPUSNAS
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <?php if (isset($_SESSION['id'])):

                        $ida = (int) $_SESSION['id'];

                        $sqlUser = "SELECT f_username FROM t_anggota WHERE f_id=$ida";
                        $user = $db->getITEM($sqlUser);
                        ?>

                        <li class="nav-item">
                            <a class="nav-link" href="?f=home&m=memberarea">
                                <i class="bi bi-person-circle me-1"></i>
                                Anggota: <?= htmlspecialchars($user['f_username'] ?? 'User') ?>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="?log=logout">
                                <i class="bi bi-box-arrow-left me-1"></i>
                                Logout
                            </a>
                        </li>

                    <?php else: ?>

                        <li class="nav-item">
                            <a class="nav-link" href="loginadmin/login.php">
                                <i class="bi bi-shield-lock me-1"></i> Admin
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="home/login.php">
                                <i class="bi bi-person me-1"></i> Anggota
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="loginadmin/loginpus.php">
                                <i class="bi bi-book me-1"></i> Pustakawan
                            </a>
                        </li>

                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>


    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-label">
                <i class="bi bi-stars me-2"></i>
                DIGITAL LIBRARY
            </div>

            <h1>Welcome To <span>PERPUSNAS</span></h1>

            <p>
                Selamat datang di perpustakaan kami.
                Temukan berbagai koleksi buku menarik dan
                perluas wawasanmu melalui dunia literasi.
            </p>

            <a href="#koleksi" class="hero-btn">Jelajahi Koleksi<i class="bi bi-arrow-right ms-2"></i></a>
        </div>
    </section>


    <!-- DAFTAR BUKU -->
    <section class="book-section" id="koleksi">
        <div class="section-header">
            <small>BOOK COLLECTION</small>
            <h4>
                <i class="bi bi-journal-bookmark-fill me-2"></i>
                Koleksi Buku
            </h4>
            <p>Temukan buku favoritmu dari koleksi perpustakaan kami.</p>
        </div>

        <div class="container-fluid">

            <div class="row g-4">

                <?php if (!empty($buku)): ?>

                    <?php $no = 1; ?>

                    <?php foreach ($buku as $r):

                        $idBuku = (int) $r['f_id'];

                        $stok = $db->rowCOUNT(
                            "SELECT * FROM t_detailbuku
                             WHERE f_status='tersedia'
                             AND f_idbuku=$idBuku"
                        );

                        $deskripsi = $r['f_deskripsi'] ?? '';
                        ?>

                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                            <div class="book-card">

                                <div class="book-cover">

                                    <span class="book-number">
                                        BOOK #<?= $no++ ?>
                                    </span>

                                    <i class="bi bi-book-half"></i>

                                </div>

                                <div class="book-content">

                                    <span class="book-category">
                                        <?= htmlspecialchars($r['f_kategori']) ?>
                                    </span>

                                    <h5>
                                        <?= htmlspecialchars($r['f_judul']) ?>
                                    </h5>

                                    <div class="book-info">
                                        <i class="bi bi-person-fill"></i>
                                        <?= htmlspecialchars($r['f_pengarang']) ?>
                                    </div>

                                    <div class="book-info">
                                        <i class="bi bi-building"></i>
                                        <?= htmlspecialchars($r['f_penerbit']) ?>
                                    </div>

                                    <p class="book-description">
                                        <?= htmlspecialchars(
                                            mb_strimwidth(strip_tags($deskripsi), 0, 100, '...')
                                        ) ?>
                                    </p>

                                    <div class="book-footer">

                                        <span class="stock-label">
                                            <i class="bi bi-box-seam me-1"></i>
                                            Stok tersedia
                                        </span>

                                        <span class="stock-number <?= $stok <= 0 ? 'empty' : '' ?>">
                                            <?= $stok ?> Buku
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="col-12">

                        <div class="empty-book">

                            <i class="bi bi-journal-x"></i>

                            <h4 class="mt-3">
                                Belum Ada Koleksi Buku
                            </h4>

                            <p>
                                Saat ini belum terdapat buku yang tersedia.
                            </p>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </section>


    <!-- FOOTER -->
    <footer>
        <p class="mb-1">
            <i class="bi bi-book-half me-2"></i>
            PERPUSNAS <span>By Lazuardi</span>
        </p>
        <p class="mt-2 mb-0">
            &copy; 2026
            <!-- <?= date('Y') ?>  -->
            Perpustakaan Digital. All Rights Reserved.
        </p>
    </footer>


    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>