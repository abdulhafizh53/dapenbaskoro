<?php
// Konfigurasi database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "dapenarsip";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Folder untuk menyimpan file yang diunggah
$uploadFolder = 'uploads/';

// Buat direktori uploads jika belum ada
if (!file_exists($uploadFolder)) {
    mkdir($uploadFolder, 0777, true);
}

if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Pastikan file yang diunggah adalah file PDF
    $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
    if ($fileType == 'pdf') {
        $fileName = $uploadFolder . uniqid() . '_' . $file['name'];

        // Pindahkan file yang diunggah ke folder uploads
        move_uploaded_file($file['tmp_name'], $fileName);

        // Ambil tanggal saat ini untuk tanggal_unggah
        $tanggalUnggah = date("Y-m-d");

        // Ambil pemilik dari sesi login
        session_start();
        $pemilik = $_SESSION['nik'] . " / " . $_SESSION['nama']; // Sesuaikan dengan nama variabel sesi login Anda

        // Ambil data dari form
        $kd_reporting = $_POST['kd_reporting'];
        $kd_pengenalUnit = $_POST['kd_pengenalUnit'];
        $tujuan = $_POST['tujuan'];
        $perihal = $_POST['perihal'];
        $ket = $_POST['ket'];

        // Ukuran file dalam bytes
        $ukuranFile = filesize($fileName);

        // Konversi ukuran file ke dalam kilobytes (KB) atau megabytes (MB)
        if ($ukuranFile >= 1048576) { // Jika ukuran file lebih besar dari atau sama dengan 1 MB
            $ukuranFile = round($ukuranFile / 1048576, 2); // Konversi ke MB dengan pembulatan 2 desimal
            $ukuranEnum = "MB";
        } else { // Jika ukuran file kurang dari 1 MB
            $ukuranFile = round($ukuranFile / 1024, 2); // Konversi ke KB dengan pembulatan 2 desimal
            $ukuranEnum = "KB";
        }

        // Simpan informasi file ke database menggunakan prepared statement
        $sql = "INSERT INTO dokumenn (file_name, file_path, kode_reporting, tanggal_unggah, tujuan_file, perihal, keterangan, pemilik, ukuran, ukuran_enum) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $file['name'], $fileName, $kd_reporting, $tanggalUnggah, $tujuan, $perihal, $ket, $pemilik, $ukuranFile, $ukuranEnum);
        if ($stmt->execute() === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Hanya file PDF yang diizinkan.";
    }
}

$conn->close();
header("Location: laporan.php");
exit();
?>
