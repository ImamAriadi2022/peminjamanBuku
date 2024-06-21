<?php

$hostname       = "localhost";
$username       = "root";
$password       = "";
$database_name  = "peminjaman_buku";

$conn            = mysqli_connect($hostname, $username, $password, $database_name);

if($conn->connect_error){
    echo "Gangguan Koneksi";
    die("Error!");
}
echo "Koneksi Terhubung"




?>