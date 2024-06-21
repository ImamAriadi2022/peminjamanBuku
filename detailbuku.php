<?php
include 'service/koneksi.php'; // Memasukkan file koneksi

// Mengambil ID buku dari URL dan memastikannya sebagai string untuk menghindari kesalahan SQL
$book_id = $_GET['id'] ?? '';

// Prepared statement to securely fetch book data
$query = $conn->prepare("SELECT JUDUL_BUKU, PENERBIT, TAHUN_TERBIT, JUML_HALAMAN, STATUS_BUKU, GAMBAR FROM BUKU WHERE ID_BUKU = ?");
$query->bind_param('s', $book_id);
$query->execute();
$result = $query->get_result();

if ($result && $result->num_rows > 0) {
    $book = $result->fetch_assoc();
} else {
    $book = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
<?php include "layout/header.html"; ?>
<div class="book-detail">
    <?php
    if ($book) {
        echo "<div style='display: flex;'>
        <div class='coverbuku' style='flex: 0 0 15%;'>
            <img src='" . htmlspecialchars($book["GAMBAR"]) . "' alt='Gambar Buku' style='width: 100%;'>
        </div>
        <div class='infobuku' style='flex: 1; margin-left: 20px;'>
            <h2>" . htmlspecialchars($book["JUDUL_BUKU"]) . "</h2>
            <p><strong>Penerbit:</strong> " . htmlspecialchars($book["PENERBIT"]) . "</p>
            <p><strong>Tahun Terbit:</strong> " . htmlspecialchars($book["TAHUN_TERBIT"]) . "</p>
            <p><strong>Jumlah Halaman:</strong> " . htmlspecialchars($book["JUML_HALAMAN"]) . "</p>
            <p><strong>Status Buku:</strong> " . htmlspecialchars($book["STATUS_BUKU"]) . "</p>
        </div>
      </div>";

        if ($book["STATUS_BUKU"] == 'Available') {
            echo '<form method="post" action="Login.php">'; // Redirect to login page
            echo '<button type="submit">Login untuk Meminjam Buku</button>';
            echo '</form>';
        } else {
            echo '<p>Buku tidak tersedia untuk dipinjam.</p>';
        }
    } else {
        echo "<p>Buku tidak ditemukan.</p>";
    }
    ?>
</div>
<?php include "layout/footer.html"; ?>
</body>
</html>

<?php
$conn->close();
?>
