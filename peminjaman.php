<?php
include 'service/koneksi.php'; // Memasukkan file koneksi

session_start();

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan kembali ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil ID anggota pengguna yang sedang login
$username = $_SESSION['username'];
$query_anggota = "SELECT ID_ANGGOTA FROM anggota WHERE USERNAME = '$username'";
$result_anggota = $conn->query($query_anggota);
$row_anggota = $result_anggota->fetch_assoc();
$id_anggota = $row_anggota['ID_ANGGOTA'];

// Query menggunakan JOIN untuk mendapatkan informasi peminjaman dengan nama anggota dan judul buku
$query_peminjaman = "SELECT p.ID_PEMINJAMAN, p.ID_PETUGAS, p.ID_ANGGOTA, p.ID_BUKU, p.TGL_PEMINJAMAN, p.TGL_KEMBALI, a.NAMA_ANGGOTA, b.JUDUL_BUKU
                     FROM peminjaman p
                     INNER JOIN anggota a ON p.ID_ANGGOTA = a.ID_ANGGOTA
                     INNER JOIN buku b ON p.ID_BUKU = b.ID_BUKU
                     WHERE p.ID_ANGGOTA = '$id_anggota'";
$result_peminjaman = $conn->query($query_peminjaman);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <title>Daftar Peminjaman</title>
    <style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
</head>
<body>
<div class="header">
                    <ul class="menu_kiri">
                        <li><a href="IndexAnggota.php">Home</a></li>
                        <li><a href="Peminjaman.php">Peminjaman</a></li>
                        <li><a href="CariBukuAnggota.php">Cari Buku</a></li>
                        <li><a href="Logout.php">Logout</a></li>
                    </ul>
                </div>
    <h2>Daftar Peminjaman</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>ID Petugas</th>
                <th>ID Anggota</th>
                <th>Nama Anggota</th>
                <th>ID Buku</th>
                <th>Judul Buku</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Kembali</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_peminjaman->num_rows > 0) {
                while ($row_peminjaman = $result_peminjaman->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_peminjaman['ID_PEMINJAMAN'] . "</td>";
                    echo "<td>" . $row_peminjaman['ID_PETUGAS'] . "</td>";
                    echo "<td>" . $row_peminjaman['ID_ANGGOTA'] . "</td>";
                    echo "<td>" . $row_peminjaman['NAMA_ANGGOTA'] . "</td>";
                    echo "<td>" . $row_peminjaman['ID_BUKU'] . "</td>";
                    echo "<td>" . $row_peminjaman['JUDUL_BUKU'] . "</td>";
                    echo "<td>" . $row_peminjaman['TGL_PEMINJAMAN'] . "</td>";
                    echo "<td>" . $row_peminjaman['TGL_KEMBALI'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Tidak ada buku yang dipinjam.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include"layout/footer.html" ?>
</body>
</html>

<?php
$conn->close();
?>
