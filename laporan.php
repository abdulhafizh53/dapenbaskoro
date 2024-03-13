<?php
session_start();
// Include your conn.php file for database connection
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit;
}

// Ambil informasi pengguna dari session
$nik = $_SESSION["nik"];
$nama = $_SESSION["nama"];
$role = $_SESSION["role"];

// Query untuk mengambil data dari database
$query = "SELECT * FROM dokumenn";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\laporan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css" rel="stylesheet">
    <title>Manajemen Dokumen</title>
    <style>

    </style>
</head>

<body>
    <div class="header">
        <div class="search-bar">
            <div class="search-icon">
                <img src="asset\img\search.png" alt="Search Icon">
            </div>
            <input type="text" placeholder="Search..." />
        </div>
        <div class="profile" onclick="togglePopup()">
            <img src="asset\img\fotokosong.jpg" alt="Profile Image" />
            <!-- Popup -->
            <div id="profilePopup" class="popup">
                <img src="asset\img\fotokosong.jpg" alt="Profile Image" />
                <h3><?php echo $nama; ?></h3>
                <a href="logout"><button class="logout-button" onclick="logout()">Logout</button></a>
            </div>
        </div>
    </div>
    <div class="sidebar">
        <a href="index.php"><img src="asset/img/logo.png" alt="Logo" class="logo"></a>

        <?php
        // Periksa apakah pengguna adalah admin
        if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") : ?>
            <a href="input"><button class="new-button">+ Baru</button></a>
        <?php endif; ?>
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

    <div class="content">
        <table>
            <tr>
                <th>Nama File</th>
                <th>Pemilik</th>
                <th>Ukuran</th>
                <th>Aksi</th>

            </tr>
            <?php
            // Loop through the result set
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['file_name'] . "</td>";
                echo "<td>" . $row['pemilik'] . "</td>"; // Ganti "Pemilik" dengan data pemilik yang sesuai
                echo "<td>" . $row['ukuran'] . " " . $row['ukuran_enum'] . "</td>";
                // Ganti "Ukuran" dengan data ukuran yang sesuai
                echo "<td>";
                echo "<a href='view.php?file=" . urlencode($row['file_path']) . "'><i class='fas fa-eye gray' title='View PDF'></i></a>"; // Ikon untuk View PDF dengan warna abu-abu
                echo "<span style='margin: 0 5px;'>|</span>"; // Menambahkan jarak antara simbol
                echo " <a href='download.php?file=" . urlencode($row['file_path']) . "'><i class='fas fa-download text-gray' title='Download'></i></a>"; // Ikon untuk Download dengan warna abu-abu
                echo "<span style='margin: 0 5px;'>|</span>"; // Menambahkan jarak antara simbol
                echo "<a href='#' onclick='confirmAction(\"info\")'><i class='fas fa-info-circle text-gray' title='Info'></i></a>"; // Pemanggilan fungsi confirmAction() dengan argumen "info"                echo "</td>";
                echo "</td>";
                echo "</tr>";
            }
            ?>

        </table>
    </div>
    </div>
    <script src="js/script.js"></script>

</html>