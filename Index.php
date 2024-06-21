<?php
session_start();
include 'service/koneksi.php'; // Memasukkan file koneksi

// Query untuk mendapatkan data buku
$sql = "SELECT ID_BUKU, GAMBAR, JUDUL_BUKU, PENERBIT, TAHUN_TERBIT, JUML_HALAMAN, STATUS_BUKU FROM BUKU";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Senja</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <link rel="stylesheet" href="path/to/fontawesome.css">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .admin-panel {
            width: 200px;
            background-color: #f1f1f1;
            position: fixed;
            height: 100%;
            overflow: auto;
        }

        .admin-panel a {
            display: block;
            color: black;
            padding: 16px;
            text-decoration: none;
        }

        .admin-panel a:hover {
            background-color: #575757;
            color: white;
        }

        .main-content {
            margin-left: 210px;
            padding: 16px;
        }
    </style>
    <script src="path/to/jquery.js"></script>
    <script src="path/to/bootstrap.bundle.js"></script>
</head>
<body>
    
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <?php 
                        if ($_SESSION['level'] == 'Karyawan' || $_SESSION['level'] == 'karyawan'):
                    ?>
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        
                        <a class="nav-link" href="index.php?page=dashboard">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Dashboard
                        </a>
                        
                        <a class="nav-link" href="index.php?page=daftar-peminjaman">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-ol"></i></div>
                            Peminjaman
                        </a>
                        
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="false" aria-controls="collapseLaporan">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Laporan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="index.php?page=laporan-peminjaman"><i class="fas fa-book"></i>&nbsp; Peminjaman</a>
                                <a class="nav-link" href="index.php?page=laporan-pustaka"><i class="fas fa-grip-horizontal"></i>&nbsp; Pustaka</a>
                                <a class="nav-link" href="index.php?page=laporan-anggota"><i class="fas fa-user-tag"></i>&nbsp; Anggota</a>
                            </nav>
                        </div>
                        
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePustaka" aria-expanded="false" aria-controls="collapsePustaka">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Pustaka
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePustaka" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="index.php?page=pustaka"><i class="fas fa-book"></i>&nbsp; Pustaka</a>
                                <a class="nav-link" href="index.php?page=kategori"><i class="fas fa-grip-horizontal"></i>&nbsp; Kategori</a>
                                <a class="nav-link" href="index.php?page=penulis"><i class="fas fa-user-tag"></i>&nbsp; Penulis</a>
                                <a class="nav-link" href="index.php?page=penerbit"><i class="fas fa-building"></i>&nbsp; Penerbit</a>
                            </nav>
                        </div>
                        
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengguna" aria-expanded="false" aria-controls="collapsePengguna">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Pengguna
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePengguna" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="index.php?page=anggota"><i class="fas fa-user"></i>&nbsp; Anggota</a>
                                <a class="nav-link" href="index.php?page=karyawan"><i class="fas fa-user-tie"></i>&nbsp; Karyawan</a>
                            </nav>
                        </div>
                        
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengaturan" aria-expanded="false" aria-controls="collapsePengaturan">
                            <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                            Pengaturan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePengaturan" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="index.php?page=aplikasi"><i class="fas fa-desktop"></i>&nbsp; Aplikasi</a>
                            </nav>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                <div style="background-image: url('https://unair.ac.id/wp-content/uploads/2022/07/perpustakaan.jpg" height="100%" width="100%');">
                    <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        include($page . '.php');
                    } else {
                        include('dashboard.php');
                    }
                    ?>
                    <div class="konten">
                        <?php include "layout/header.html"; ?>
                        <!-- <div class="previewimg">
                            <img src="https://unair.ac.id/wp-content/uploads/2022/07/perpustakaan.jpg" height="100%" width="100%">
                        </div>
                        <br> -->
                        <div style="background-image: url('https://unair.ac.id/wp-content/uploads/2022/07/perpustakaan.jpg" height="100%" width="100%');">
                        <br> 
                        <h2 style="text-align:center; color:white">  </h2>
                        <h2 style="text-align:center; color:white">Selamat Datang di Perpustakaan Senja</h2>
                        <br>
                        <h2 style="text-align:center; color:white">Daftar Buku</h2>
                        <div class="daftarbuku">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="card">';
                                    echo '<a href="detailbuku.php?id=' . htmlspecialchars($row["ID_BUKU"]) . '">';
                                    echo '<img src="' . htmlspecialchars($row["GAMBAR"]) . '" alt="Gambar Buku">';
                                    echo '</a>';
                                    echo '<div class="card-container">';
                                    echo '<h4><b  style="color:white">' . htmlspecialchars($row["JUDUL_BUKU"]) . '</b></h4>';
                                    echo '<p style="color:white">' . htmlspecialchars($row["PENERBIT"]) . '</p>';
                                    echo '<p style="color:white">' . htmlspecialchars($row["TAHUN_TERBIT"]) . '</p>';
                                    echo '<p style="color:white">' . htmlspecialchars($row["JUML_HALAMAN"]) . '</p>';
                                    echo '<p style="color:white">' . htmlspecialchars($row["STATUS_BUKU"]) . '</p>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo "<p>No books found.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="assets/script.js"></script>
    <?php include "layout/footer.html"; ?>
</body>
</html>

<?php
$conn->close();
?>
