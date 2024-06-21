<?php
session_start(); // Start the session
include 'service/koneksi.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['id_anggota'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Query to get user data
$id_anggota = $_SESSION['id_anggota'];
$user_query = "SELECT NAMA_ANGGOTA FROM ANGGOTA WHERE ID_ANGGOTA = '$id_anggota'";
$user_result = $conn->query($user_query);

if ($user_result && $user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
    $user_name = htmlspecialchars($user['NAMA_ANGGOTA']);
} else {
    $user_name = 'Guest';
}

// Query to get book data
$sql = "SELECT ID_BUKU, GAMBAR, JUDUL_BUKU, PENERBIT, TAHUN_TERBIT, JUML_HALAMAN, STATUS_BUKU FROM BUKU";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Perpustakaan Senja</title>
        <link rel="stylesheet" type="text/css" href="assets/style.css">
    </head>
    <body>
        <div>
            <div class="previewimg">
                <img src="https://asset.kompas.com/crops/Yn331T3ABD2Twkqhp_sO-K0m6Go=/429x39:5529x3439/750x500/data/photo/2021/05/10/609931bb5334c.jpg" height="100%" width="100%">
            </div>

            <div>
                <div class="konten">
                <div class="header">
                    <ul class="menu_kiri">
                        <li><a href="IndexAnggota.php">Home</a></li>
                        <li><a href="Peminjaman.php">Peminjaman</a></li>
                        <li><a href="CariBukuAnggota.php">Cari Buku</a></li>
                        <li><a href="Logout.php">Logout</a></li>
                    </ul>
                </div>
                    <h2>Selamat Datang di Perpustakaan Senja, <?php echo $user_name; ?></h2>
                    <br>
                    <h2 style="text-align:center">Daftar buku</h2>
                    <div class="daftarbuku">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="card">';
                                echo '<a href="DetailBukuAnggota.php?id=' . htmlspecialchars($row["ID_BUKU"]) . '">';
                                echo '<img src="' . htmlspecialchars($row["GAMBAR"]) . '" alt="Gambar Buku">';
                                echo '</a>';
                                echo '<div class="card-container">';
                                echo '<h4><b>' . htmlspecialchars($row["JUDUL_BUKU"]) . '</b></h4>';
                                echo '<p>' . htmlspecialchars($row["PENERBIT"]) . '</p>';
                                echo '<p>' . htmlspecialchars($row["TAHUN_TERBIT"]) . '</p>';
                                echo '<p>' . htmlspecialchars($row["JUML_HALAMAN"]) . '</p>';
                                echo '<p>' . htmlspecialchars($row["STATUS_BUKU"]) . '</p>';
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
        </div>
        <script src="assets/script.js"></script>
        <?php include "layout/footer.html"; ?>
    </body>
</html>

<?php
$conn->close();
?>
