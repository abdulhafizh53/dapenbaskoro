<?php
// Include your conn.php file for database connection
include 'koneksi.php';
session_start();

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit;
}

// Periksa apakah pengguna memiliki role admin
if ($_SESSION["role"] !== "admin") {
    header("location: index.php"); // Ganti index.php dengan halaman yang sesuai untuk pengguna non-admin
    exit;
}

// Koneksi ke database
$servername = "localhost"; // Ganti dengan host database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "dapenbaru"; // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil informasi pengguna dari session
$nik = $_SESSION["nik"];
$nama = $_SESSION["nama"];
$role = $_SESSION["role"];

// Query untuk mengambil data dari database
$query = "SELECT nama_file, pemilik, ukuran FROM dokumen";
$result = $koneksi->query($query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\input.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css" rel="stylesheet">
    <title>Manajemen Dokumen</title>
</head>

<body>
    <div class="sidebar">
        <a href="index.php"><img src="asset/img/logo.png" alt="Logo" class="logo"></a>
        <!-- Laporan -->
        <div class="folder" onclick="toggleSubfolder('laporanSubfolders')">
            <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
            <p class="folder-text">Laporan</p>
        </div>
        <!-- Subfolders for Laporan -->
        <div class="subfolder" id="laporanSubfolders">
            <div class="folder">
                <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
                <p class="folder-text">Tahunan</p>
            </div>
            <div class="folder">
                <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
                <p class="folder-text">Semesteran</p>
            </div>
            <div class="folder">
                <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
                <p class="folder-text">Triwulan</p>
            </div>
            <div class="folder">
                <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
                <p class="folder-text">Bulanan</p>
            </div>
        </div>
        <div class="folder" onclick="toggleSubfolder('laporanSubfolders')">
            <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
            <p class="folder-text">Peraturan</p>
        </div>
        <div class="folder" onclick="toggleSubfolder('laporanSubfolders')">
            <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
            <p class="folder-text">Artikel/Jurnal</p>
        </div>
        <!-- Arsip -->
        <div class="folder" onclick="toggleSubfolder('laporanSubfolders')">
            <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
            <p class="folder-text">Laporan</p>
        </div>
        <!-- Subfolders for Arsip -->
        <div class="subfolder" id="arsipSubfolders">
            <div class="folder">
                <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
                <p class="folder-text">Arsip Peserta</p>
            </div>
            <div class="folder">
                <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
                <p class="folder-text">Arsip Dana Pensiun</p>
            </div>
        </div>
        <!-- Approval Request Button -->
        <div class="approve-button" onclick="goToApprovalPage()">
            <img src="asset/img/lonceng.png" alt="Lonceng" href="approval.php">
            <span>Approval Request</span>
        </div>
    </div>
    <h2 style="margin-left:150px;">Entri Data Laporan</h2>
    <form action="proses_input.php" method="POST" enctype="multipart/form-data" style="max-width: 800px; margin-left: 450px;">
        <label for="kd_reporting">Kode Reporting:</label><br>
        <input type="text" id="kd_reporting" name="kd_reporting" required><br><br>

        <label for="nama_laporan">Nama Laporan:</label><br>
        <input type="text" id="nama_laporan" name="nama_laporan" required><br><br>

        <label for="kd_pengenalUnit">Kode Pengenal Unit:</label><br>
        <input type="text" id="kd_pengenalUnit" name="kd_pengenalUnit" required><br><br>

        <label for="tgl_unggah">Tanggal Unggah:</label><br>
        <input type="date" id="tgl_unggah" name="tgl_unggah" required><br><br>

        <label for="tujuan">Tujuan:</label><br>
        <textarea id="tujuan" name="tujuan" required></textarea><br><br>

        <label for="perihal">Perihal:</label><br>
        <input type="text" id="perihal" name="perihal" required><br><br>

        <label for="ket">Keterangan:</label><br>
        <textarea id="ket" name="ket" required></textarea><br><br>

        <label for="jenis_laporan">Jenis Laporan:</label><br>
        <select id="jenis_laporan" name="jenis_laporan" required>
            <option value="Laporan Bulanan">Laporan Bulanan</option>
            <option value="Laporan Tahunan">Laporan Tahunan</option>
            <option value="Laporan Triwulan">Laporan Triwulan</option>
        </select><br><br>

        <label for="file">Pilih File:</label><br>
        <input type="file" id="file" name="file" required><br><br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <script>
        function toggleSubfolder(folderId) {
            var subfolder = document.getElementById(folderId);
            if (subfolder.style.display === 'block') {
                subfolder.style.display = 'none';
            } else {
                subfolder.style.display = 'block';
            }
        }

        function togglePopup() {
            var popup = document.getElementById('profilePopup');
            popup.classList.toggle('active');
        }

        function goToApprovalPage() {
            window.location.href = 'approval.php';
        }
    </script>

    <script>
        function toggleSubfolder(folderId) {
            var subfolder = document.getElementById(folderId);
            if (subfolder.style.display === 'block') {
                subfolder.style.display = 'none';
            } else {
                subfolder.style.display = 'block';
            }
        }

        function togglePopup() {
            var popup = document.getElementById('profilePopup');
            popup.classList.toggle('active');
        }
    </script>
</body>



</div>

</html>