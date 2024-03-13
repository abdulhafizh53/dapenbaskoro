<?php
session_start();

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit;
}

// Ambil informasi pengguna dari session
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #E7E7E7;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
        }

        .logo {
            max-width: 110px;
        }

        .search-bar {
            top: 20px;
            left: 230px;
            width: calc(150% - 250px);
            height: 40px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            padding: 0 15px;
            margin: 0 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .search-bar img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .search-bar input {
            flex: 1;
            height: 100%;
            border-radius: 20px;
            border: none;
            padding: 0;
            font-size: 16px;
            color: #0A1D39;
            background: none;
            outline: none;
        }

        .profile {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 5px;
            margin-left: 10px;
        }

        .profile span {
            font-size: 16px;
        }

        .content {
            padding: 10px;
        }

        .popup {
            display: none;
            position: absolute;
            bottom: -260px;
            left: 50%;
            transform: translateX(-110%);
            width: 220px;
            height: 200px;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            z-index: 1000;
            box-shadow: 0px 4px 10px rgba(90, 89, 89, 0.5);
            margin-left: -20px;
            cursor: default;
        }

        .popup-content {
            text-align: center;
        }

        .popup.active {
            display: block;
        }

        .popup img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
        }

        .popup button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            background-color: #e70404;
            color: white;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(90, 89, 89, 0.5);
        }

        .popup button:hover {
            background-color: #b30000;
            /* Warna merah saat hover */
        }

        .popup h3 {
            margin: 0;
            text-align: center;
            margin-bottom: 10px;
        }

        .new-button {
            background-color: #e70404;
            /* Warna merah */
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            margin-bottom: 30px;
            margin-top: -100px;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(90, 89, 89, 0.5);
            transition: background-color 0.3s;
        }

        .new-button:hover {
            background-color: #b30000;
        }

        .nav {
            background-color: white;
            margin: 0 48px;
        }

        .nav-item.nav-link {
            color: black;
            transition: color 0.3s;
            /* Efek transisi saat mengubah warna */
        }

        .nav-item.nav-link:hover {
            color: black;
            /* Warna merah saat hover */
        }

        .nav-item.nav-link.active {
            font-weight: bold;
            /* Teks menjadi tebal untuk tautan aktif */
        }
    </style>
</head>

<body>
    <div class="header">
        <a href="index.php"><img src="asset/img/logodapen.png" alt="Logo" class="logo"></a>
        <div class="search-bar">
            <div class="search-icon">
                <img src="asset/img/search.png" alt="Search Icon">
            </div>
            <input type="text" placeholder="Search..." />
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
    <div class="content">
        <nav class="nav nav-pills nav-fill">
            <a href="#" class="nav-item nav-link" style="color: black;">Hapus</a>
            <a href="#" class="nav-item nav-link active">Upload</a>
            <a href="#" class="nav-item nav-link" style="color: black;">Pembaruan</a>
        </nav>
        <div class="box-body" style="margin: 50px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td>dapen.pdf</td>
                        <td>Menunggu</td>
                        <td>16 Januari 2024</td>
                        <td>
                            <a href="#" onclick="confirmAction('approve')"><i class="fas fa-check-circle" title="Approve"></i></a>
                            <a href="#" onclick="confirmAction('decline')"><i class="fas fa-times-circle" title="Decline"></i></a>
                            <a href="#" onclick="confirmAction('info')"><i class="fas fa-info-circle" title="Info"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
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
    <script>
        function confirmAction(action) {
            var confirmationMessage = '';
            var title = '';
            var icon = '';

            // Menyesuaikan pesan, judul, dan ikon pop-up berdasarkan aksi
            switch (action) {
                case 'approve':
                    confirmationMessage = 'Apakah Anda yakin ingin melanjutkan?';
                    title = 'Approve File';
                    icon = 'question';
                    break;
                case 'decline':
                    confirmationMessage = 'Apakah Anda yakin ingin melanjutkan?';
                    title = 'Decline File';
                    icon = 'question';
                    break;
                case 'info':
                    // Menampilkan detail file
                    Swal.fire({
                        title: 'Detail File',
                        html: '<b>Nama:</b> dapen.pdf<br><b>Status:</b> Menunggu<br><b>Tanggal:</b> 16 Januari 2024',
                        icon: 'info'
                    });
                    return; // Menghindari pemanggilan Swal.fire() kedua di bawah
                default:
                    confirmationMessage = 'Apakah Anda yakin ingin melanjutkan?';
                    title = 'Konfirmasi';
                    icon = 'warning';
            }

            // Tampilkan pop-up konfirmasi untuk aksi approve atau decline
            Swal.fire({
                title: title,
                text: confirmationMessage,
                icon: icon,
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Lanjut",
                cancelButtonText: "Tidak"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        text: "Operasi berhasil dilakukan.",
                        icon: "success"
                    });
                }
            });
        }
    </script>


</body>

</html>