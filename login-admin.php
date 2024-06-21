<?php
include 'service/koneksi.php'; // Memasukkan file koneksi

// Inisialisasi variabel
$username = $password = $error = "";

// Jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $conn->real_escape_string($_POST["username"]);
        $password = $_POST["password"];

        // Query untuk memeriksa keberadaan user dengan username yang dimasukkan
        $query = "SELECT * FROM PETUGAS WHERE USERNAME='$username'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["PASSWORD"])) {
                // Password cocok, set session dan redirect ke halaman dashboard
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['id_petugas'] = $row["ID_PETUGAS"];
                header("Location: IndexAnggota.php");
                exit();
            } else {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['id_petugas'] = $row["ID_PETUGAS"];
                header("Location: IndexAnggota.php");
                exit();
            }
        } else {
            $error = "Username tidak ditemukan.";
        }
    } else {
        $error = "Harap masukkan username dan password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <title>Login</title>
</head>
<body>
<?php include "layout/header.html"; ?>
<div class="login-container">
    <div class="login-box">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Login Admin</h2>
            <?php if (!empty($error)) { echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>'; } ?>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Login</button>
        </form>
    </div>
</div>
<?php include "layout/footer.html"; ?>
</body>
</html>

<?php
$conn->close();
?>
