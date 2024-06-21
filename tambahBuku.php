<?php
session_start();
include 'service/koneksi.php';

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_buku = $_POST["id_buku"];
    $id_petugas = "P001"; // Example petugas ID, you may fetch this from session or other method
    $judul_buku = $_POST["judul_buku"];
    $penerbit = $_POST["penerbit"];
    $tahun_terbit = $_POST["tahun_terbit"];
    $juml_halaman = $_POST["juml_halaman"];
    $status_buku = $_POST["status_buku"];

    $sql = "INSERT INTO BUKU (ID_BUKU, ID_PETUGAS, JUDUL_BUKU, PENERBIT, TAHUN_TERBIT, JUML_HALAMAN, STATUS_BUKU) 
    VALUES ('$id_buku', '$id_petugas', '$judul_buku','$penerbit', '$tahun_terbit', '$juml_halaman', '$status_buku')";
    $stmt = $conn->prepare($sql);
    // $sql = "INSERT INTO BUKU (ID_BUKU, ID_PETUGAS, JUDUL_BUKU, PENERBIT, TAHUN_TERBIT, JUML_HALAMAN, STATUS_BUKU) VALUES (?, ?, ?, ?, ?, ?, ?)";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("sssssis", $id_buku, $id_petugas, $judul_buku, $penerbit, $tahun_terbit, $juml_halaman, $status_buku);

    if ($stmt->execute()) {
        echo "Buku berhasil ditambahkan.";
    } else {
        echo "Terjadi kesalahan dalam menambahkan buku.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
</head>
<body>
    <h2>Form Tambah Buku</h2>
    <form method="POST" action="">
        <label for="id_buku">ID Buku:</label>
        <input type="text" id="id_buku" name="id_buku" required>
        <br>
        <label for="judul_buku">Judul Buku:</label>
        <input type="text" id="judul_buku" name="judul_buku" required>
        <br>
        <label for="penerbit">Penerbit:</label>
        <input type="text" id="penerbit" name="penerbit" required>
        <br>
        <label for="tahun_terbit">Tahun Terbit:</label>
        <input type="number" id="tahun_terbit" name="tahun_terbit" required>
        <br>
        <label for="juml_halaman">Jumlah Halaman:</label>
        <input type="number" id="juml_halaman" name="juml_halaman" required>
        <br>
        <label for="status_buku">Status Buku:</label>
        <input type="text" id="status_buku" name="status_buku" required>
        <br>
        <label for="gambar">Gambar:</label>
        <input type="text" id="gambar" name="gambar" not required>
        <br>
        <input type="submit" value="Tambah Buku">
    </form>
</body>
</html>
