<?php

require_once "../dbcontroller.php";

$db = new dbcontroller();

session_start();

// CEK LOGIN ANGGOTA
if (!isset($_SESSION['anggota'])) {
    header("location:index.php");
    exit;
}

// LOGOUT
if (isset($_GET['log'])) {
    session_destroy();
    header("location:../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <title>Perpustakaan - Anggota</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #fff8f2;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #6096B4;
            padding: 20px 15px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-brand {
            color: white;
            font-size: 22px;
            font-weight: 800;
            text-decoration: none;
            display: block;
            padding: 10px 15px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, .3);
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .sidebar-menu-wrapper {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            min-height: 0;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar-menu-wrapper::-webkit-scrollbar {
            display: none;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 7px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            transition: .2s;
            font-size: 14px;
        }

        .sidebar-menu a:hover {
            background-color: #487b99;
            color: white;
        }

        .sidebar-menu a.active {
            background-color: #ffffff;
            color: #385f78;
            font-weight: 700;
        }

        .sidebar-menu i {
            font-size: 18px;
        }

        .sidebar-title {
            color: rgba(255, 255, 255, .75);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 15px 15px 8px;
            text-transform: uppercase;
        }

        /* FOOTER SIDEBAR */
        .sidebar-footer {
            border-top: 1px solid rgba(255, 255, 255, .3);
            padding: 15px 10px 5px;
            margin-top: 15px;
            color: white;
            text-align: center;
            font-size: 12px;
            flex-shrink: 0;
        }

        .sidebar-footer p {
            margin-bottom: 5px;
        }

        .sidebar-footer small {
            color: rgba(255, 255, 255, .75);
        }

        /* TOPBAR */
        .topbar {
            height: 70px;
            position: fixed;
            top: 0;
            right: 0;
            left: 250px;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
            z-index: 999;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-user a {
            color: #334155;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .topbar-user a:hover {
            color: #2563eb;
        }

        /* CONTENT */
        .content {
            margin-left: 250px;
            padding: 100px 30px 30px;
            min-height: 100vh;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {

            .sidebar {
                width: 75px;
                padding: 20px 8px;
            }

            .sidebar-brand {
                font-size: 0;
                text-align: center;
                padding: 10px 0 25px;
            }

            .sidebar-brand::before {
                content: "P";
                font-size: 22px;
            }

            .sidebar-menu a {
                justify-content: center;
                padding: 13px 5px;
                font-size: 0;
            }

            .sidebar-menu i {
                font-size: 20px;
            }

            .sidebar-title {
                font-size: 0;
                padding: 8px 0;
            }

            .sidebar-footer {
                padding: 12px 0 5px;
                font-size: 0;
            }

            .sidebar-footer p {
                font-size: 0;
            }

            .sidebar-footer p i {
                font-size: 16px;
            }

            .sidebar-footer small {
                display: none;
            }

            .topbar {
                left: 75px;
                padding: 0 15px;
            }

            .content {
                margin-left: 75px;
                padding: 90px 15px 20px;
            }

            .topbar-user {
                gap: 12px;
            }

            .topbar-user a {
                font-size: 12px;
            }
        }
    </style>

</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <a href="index.php" class="sidebar-brand">
            <i class="bi bi-book-half me-2"></i> PERPUSNAS
        </a>

        <div class="sidebar-menu-wrapper">

            <div class="sidebar-title">Menu Anggota</div>

            <ul class="sidebar-menu">

                <li>
                    <a href="?f=peminjaman&m=select"
                        class="<?= (($_GET['f'] ?? '') == 'peminjaman' && ($_GET['m'] ?? '') == 'select') ? 'active' : ''; ?>">
                        <i class="bi bi-folder-plus"></i>
                        Peminjaman Buku
                    </a>
                </li>

                <li>
                    <a href="?f=peminjaman&m=insert"
                        class="<?= (($_GET['f'] ?? '') == 'peminjaman' && ($_GET['m'] ?? '') == 'insert') ? 'active' : ''; ?>">
                        <i class="bi bi-plus-circle"></i>
                        Pinjam Buku
                    </a>
                </li>
                <li>
                    <a href="?f=laporan&m=select">
                        <i class="bi bi-calendar-range"></i>
                        Laporan Peminjaman
                    </a>
                </li>

            </ul>

        </div>

        <!-- FOOTER -->
        <div class="sidebar-footer">

            <p class="fw-bold mb-1">
                <i class="bi bi-book-half me-1"></i>
                PERPUSNAS
            </p>

            <small>
                &copy; <?= date('Y'); ?> Sistem Informasi Perpustakaan
            </small>

        </div>

    </aside>

    <!-- TOPBAR -->
    <nav class="topbar">

        <div class="topbar-user">

            <a href="#" class="d-flex align-items-center">

                <i class="bi bi-person-circle fs-5 me-2"></i>

                <?= htmlspecialchars($_SESSION['f_nama'] ?? 'Anggota'); ?>

            </a>

            <a href="?log=logout">

                <i class="bi bi-box-arrow-right me-1"></i>
                Logout

            </a>

        </div>

    </nav>

    <!-- MAIN CONTENT -->
    <main class="content">

        <?php

        if (isset($_GET['f']) && isset($_GET['m'])) {

            $f = $_GET['f'];
            $m = $_GET['m'];

            $allowed = [
                'peminjaman' => ['select', 'insert'],
                'laporan' => ['select']
            ];

            if (isset($allowed[$f]) && in_array($m, $allowed[$f])) {

                if ($f == 'laporan') {
                    $file = 'laporan.php';
                } else {
                    $file = '../' . $f . '/' . $m . '.php';
                }

                if (file_exists($file)) {
                    include $file;
                } else {
                    echo '<div class="alert alert-danger text-center">
                    Halaman Tidak Ditemukan
                  </div>';
                }

            } else {
                echo '<div class="alert alert-danger text-center">
                Anda Tidak Memiliki Hak Akses Halaman Ini
              </div>';
            }

        } else {
            require_once "../peminjaman/select.php";
        }

        ?>

    </main>

</body>

</html>