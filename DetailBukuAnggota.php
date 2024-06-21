<?php
session_start(); // Start the session
include 'service/koneksi.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['id_anggota'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get book ID from URL
$book_id = $conn->real_escape_string($_GET['id']);

// Get book data by ID
$query = "SELECT JUDUL_BUKU, PENERBIT, TAHUN_TERBIT, JUML_HALAMAN, STATUS_BUKU, GAMBAR FROM BUKU WHERE ID_BUKU = '$book_id'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $book = $result->fetch_assoc();
} else {
    $book = null;
}

// Process borrowing form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_anggota = $_SESSION['id_anggota'];
    $id_petugas = "P001"; // This should be the actual ID of the staff handling the loan, assuming 1 for simplicity
    $id_peminjaman = uniqid(); // Generate a unique ID for the loan

    // Start transaction
    $conn->begin_transaction();

    try {
        // Add entry to peminjaman table
        $query = "INSERT INTO peminjaman (ID_PEMINJAMAN, ID_PETUGAS, ID_ANGGOTA, ID_BUKU, TGL_PEMINJAMAN, TGL_KEMBALI) VALUES ('$id_peminjaman', 'P001', '$id_anggota', '$book_id', NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY))";
        if ($conn->query($query) === TRUE) {
            // Update book status to 'Dipinjam'
            $update_query = "UPDATE BUKU SET STATUS_BUKU = 'Dipinjam' WHERE ID_BUKU = '$book_id'";
            if ($conn->query($update_query) === TRUE) {
                $conn->commit();
                echo "Buku berhasil dipinjam.";
            } else {
                throw new Exception("Error updating book status: " . $conn->error);
            }
        } else {
            throw new Exception("Error inserting loan record: " . $conn->error);
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
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
<div class="header">
        <ul class="menu_kiri">
            <li><a href="IndexAnggota.php">Home</a></li>
            <li><a href="Peminjaman.php">Peminjaman</a></li>
            <li><a href="CariBukuAnggota.php">Cari Buku</a></li>
            <li><a href="Logout.php">Logout</a></li>
            </ul>
        </div>
<div class="book-detail">
    <?php
    if ($book) {
        echo '<img src="' . htmlspecialchars($book["GAMBAR"]) . '" alt="Gambar Buku" style="width: 15%;">';
        echo '<h2>' . htmlspecialchars($book["JUDUL_BUKU"]) . '</h2>';
        echo '<p><strong>Penerbit:</strong> ' . htmlspecialchars($book["PENERBIT"]) . '</p>';
        echo '<p><strong>Tahun Terbit:</strong> ' . htmlspecialchars($book["TAHUN_TERBIT"]) . '</p>';
        echo '<p><strong>Jumlah Halaman:</strong> ' . htmlspecialchars($book["JUML_HALAMAN"]) . '</p>';
        echo '<p><strong>Status Buku:</strong> ' . htmlspecialchars($book["STATUS_BUKU"]) . '</p>';
        
        if ($book["STATUS_BUKU"] == 'Available') {
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $book_id) . '">';
            echo '<button type="submit">Pinjam Buku</button>';
            echo '</form>';
        } else {
            echo '<p>Buku tidak tersedia untuk dipinjam.</p>';
        }
    } else {
        echo "Buku tidak ditemukan.";
    }
    ?>
</div>
<?php include "layout/footer.html"; ?>
</body>
</html>

<?php
$conn->close();
?>
