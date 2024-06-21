<?php
include 'service/koneksi.php'; // Memasukkan file koneksi

// Query untuk mendapatkan data buku
$sql = "SELECT ID_BUKU, JUDUL_BUKU, PENERBIT, TAHUN_TERBIT, JUML_HALAMAN, STATUS_BUKU FROM BUKU";
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

            <div>
                <div class="konten">
                    <?php include "layout/header.html" ?>
                    <h2>Selamat Datang di Perpustakaan Senja</h2>
                    <br>
                    <h3>Cari buku</h3>

                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari judul buku..">

<table id="myTable">
  <tr class="headerTable">
        <th>Judul Buku</th>
        <th>Penerbit</th>
        <th>Tahun Terbit</th>
        <th>Jumlah Halaman</th>
        <th>Status Buku</th>
  </tr>
  <?php
    if ($result->num_rows > 0) {
        // Output data dari setiap baris
        while($row = $result->fetch_assoc()) {
            echo "<tr>
        <td><a href='detailbuku.php?id=" . htmlspecialchars($row["ID_BUKU"]) . "'>" . htmlspecialchars($row["JUDUL_BUKU"]) . "</a></td>
        <td>" . htmlspecialchars($row["PENERBIT"]) . "</td>
        <td>" . htmlspecialchars($row["TAHUN_TERBIT"]) . "</td>
        <td>" . htmlspecialchars($row["JUML_HALAMAN"]) . "</td>
        <td>" . htmlspecialchars($row["STATUS_BUKU"]) . "</td>
      </tr>";

        }
    } else {
        echo "<tr><td colspan='6'>Tidak ada buku ditemukan</td></tr>";
    }
    ?>
</table>           
        </div>
    <script src="assets/script.js"></script>
    <?php include "layout/footer.html" ?>
    </body>
</html>