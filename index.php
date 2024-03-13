<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit;
}

$nik = $_SESSION["nik"];
$nama = $_SESSION["nama"];
$role = $_SESSION["role"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Dokumen</title>
    <link rel="icon" href="asset/img/bg.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css\index.css">
</head>

<body>
    <div class="header">
        <div class="search-bar">
            <div class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.832 10.34a6.5 6.5 0 1 0-1.492 1.492l3.784 3.784a1 1 0 0 0 1.415-1.414l-3.784-3.784zM6.5 12A5.5 5.5 0 1 1 12 6.5 5.506 5.506 0 0 1 6.5 12z" />
                </svg>
            </div>
            <input id="searchInput" type="text" placeholder="Search..." oninput="searchDocuments()" style="margin-left: 5px;">
        </div>

        <div class="profile" onclick="togglePopup()">
            <img src="asset/img/fotokosong.jpg" alt="Profile Image" />
            <!-- Popup -->
            <div id="profilePopup" class="popup">
                <img src="asset/img/fotokosong.jpg" alt="Profile Image" />
                <h3><?php echo $nama; ?></h3>
                <a href="logout"><button class="logout-button" onclick="logout()">Logout</button></a>
            </div>
        </div>
    </div>

    <div class="sidebar">
        <a href="index.php"><img src="asset/img/logo.png" alt="Logo" class="logo"></a>

        <!-- Laporan -->
        <div class="folder" onclick="toggleSubfolder('laporanSubfolders')">
            <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
            <p class="folder-text">Laporan</p>
        </div>
        <!-- Subfolders Laporan -->
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
        <div class="folder" onclick="toggleSubfolder('peraturanSubfolders')">
            <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
            <p class="folder-text">Peraturan</p>
        </div>
        <div class="folder">
            <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
            <p class="folder-text">Artikel / Jurnal</p>
        </div>
        <!-- Arsip -->
        <div class="folder" onclick="toggleSubfolder('arsipSubfolders')">
            <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
            <p class="folder-text">Arsip</p>
        </div>
        <!-- Subfolders Arsip -->
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
        <!-- Tombol Approval Request -->
        <div class="approve-button" onclick="goToApprovalPage()">
            <img src="asset/img/lonceng.png" alt="Lonceng" href="approval.php">
            <span>Approval Request</span>
        </div>
    </div>


    <div class="additional-content">
        <a href="kategori.php" style="text-decoration: none; color: inherit;">
            <!-- <a href="laporan.php" style="text-decoration: none; color: inherit;"> -->
            <ul style="list-style-type: none; padding: 0;">
                <li>
                    <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
                    <span style="margin-right: 10px;">Laporan</span>
                </li>
        </a>
        </ul>
    </div>

    <div class="additional-content">
        <ul style="list-style-type: none; padding: 0;">
            <li>
                <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
                <span style="margin-right: 10px;">Peraturan</span>
            </li>
        </ul>
    </div>

    <div class="additional-content">
        <ul style="list-style-type: none; padding: 0;">
            <li>
                <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
                <span style="margin-right: 10px;">Artikel/Jurnal</span>
            </li>
        </ul>
    </div>

    <div class="additional-content">
        <ul style="list-style-type: none; padding: 0;">
            <li>
                <i class="fas fa-folder folder-icon" style="color: gray; margin-right: 10px;"></i>
                <span style="margin-right: 10px;">Arsip</span>
            </li>
        </ul>
    </div>
    <script src="js/script.js"></script>
    </div>
</body>

</html>