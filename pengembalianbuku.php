<?php
include 'service/koneksi.php'; // Memasukkan file koneksi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_buku = $_POST["id_buku"];
    $id_petugas = "P001"; // Example petugas ID, you may fetch this from session or other method
    $id_anggota = "A001"; // Example anggota ID, you may fetch this from session or other method
    $tgl_pengembalian = date("Y-m-d"); // Current date
    $status_pengembalian = "Tepat Waktu"; // Example status

    // Update book status
    $sql_update = "UPDATE BUKU SET STATUS_BUKU = 'Available' WHERE ID_BUKU = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("s", $id_buku);
    $stmt_update->execute();

    // Insert into PENGEMBALIAN table
    $sql_insert = "INSERT INTO PENGEMBALIAN (ID_PENGEMBALIAN, ID_PETUGAS, ID_ANGGOTA, ID_BUKU, TGL_PENGEMBALIAN, STATUS_PENGEMBALIAN) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $id_pengembalian = uniqid("PG");
    $stmt_insert->bind_param("ssssss", $id_pengembalian, $id_petugas, $id_anggota, $id_buku, $tgl_pengembalian, $status_pengembalian);
    $stmt_insert->execute();

    //mengecek data buku yang sedang dipinjam
    $sql = "SELECT ID_BUKU, GAMBAR, JUDUL_BUKU, PENERBIT, TAHUN_TERBIT, JUML_HALAMAN, STATUS_BUKU 
        FROM BUKU 
        WHERE STATUS_BUKU = 'Dipinjam'";
    $result = $conn->query($sql);

    if ($stmt_update->affected_rows > 0 && $stmt_insert->affected_rows > 0) {
        echo "Buku berhasil dikembalikan.";
    } else {
        echo "Terjadi kesalahan dalam pengembalian buku.";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Buku yang Dipinjam</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <style>
        .book-card {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 16px;
            margin: 16px;
            text-align: center;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .book-card img {
            max-width: 100%;
            height: auto;
        }

        .book-card.clicked {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <h2>Buku yang Sedang Dipinjam</h2>
    <div class="book-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="book-card" onclick="toggleColor(this)">';
                echo '<img src="' . htmlspecialchars($row["GAMBAR"]) . '" alt="Gambar Buku">';
                echo '<div class="book-info">';
                echo '<h4><b>' . htmlspecialchars($row["JUDUL_BUKU"]) . '</b></h4>';
                echo '<p>' . htmlspecialchars($row["PENERBIT"]) . '</p>';
                echo '<p>' . htmlspecialchars($row["TAHUN_TERBIT"]) . '</p>';
                echo '<p>' . htmlspecialchars($row["JUML_HALAMAN"]) . '</p>';
                echo '<p>' . htmlspecialchars($row["STATUS_BUKU"]) . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p>No books currently borrowed.</p>";
        }
        ?>
    </div>

    <script>
        function toggleColor(element) {
            element.classList.toggle("clicked");
        }
    </script>
</body>
</html>