<?php
include 'service/koneksi.php'; // Memasukkan file koneksi

// Inisialisasi variabel
$id_anggota = $nama_anggota = $alamat = $no_telepon = $email = $username = $password = "";
$id_petugas = "P001";

// Jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_anggota = $_POST["id_anggota"];
    $nama_anggota = $_POST["nama_anggota"];
    $alamat = $_POST["alamat"];
    $no_telepon = $_POST["no_telepon"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menambahkan anggota baru ke database
    $sql = "INSERT INTO anggota (ID_ANGGOTA, ID_PETUGAS, NAMA_ANGGOTA, ALAMAT, NO_TELEPON, EMAIL, USERNAME, PASSWORD) 
            VALUES ('$id_anggota', 'P001', '$nama_anggota', '$alamat', '$no_telepon', '$email', '$username', '$hashed_password')";

    if ($conn->query($sql) == TRUE) {
        echo "Registrasi berhasil. Silakan login <a href='login.php'>di sini</a>.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
    <?php include "layout/header.html" ?>
    <div class="register">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Pendaftaran</h2>
        <label for="id_anggota">ID Anggota:</label><br>
        <input type="text" id="id_anggota" name="id_anggota" required><br>
        <label for="nama_anggota">Nama Anggota:</label><br>
        <input type="text" id="nama_anggota" name="nama_anggota" required><br>
        <label for="alamat">Alamat:</label><br>
        <input type="text" id="alamat" name="alamat" required><br>
        <label for="no_telepon">No. Telepon:</label><br>
        <input type="text" id="no_telepon" name="no_telepon" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>
    </div>
    <?php include "layout/footer.html" ?>
</body>
</html>

<?php
$conn->close();
?>
