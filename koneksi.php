<?php

// Koneksi ke database (sesuaikan dengan informasi database Anda)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dapenarsip';

$koneksi = new mysqli($host, $username, $password, $database);
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
