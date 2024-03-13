<?php
// Include file koneksi ke database
include 'koneksi.php';

// Ambil nilai-nilai yang dikirim dari formulir input
$kd_reporting = $_POST['kd_reporting'];
$nama_laporan = $_POST['nama_laporan'];
$kd_pengenalUnit = $_POST['kd_pengenalUnit'];
$tgl_unggah = $_POST['tgl_unggah'];
$tujuan = $_POST['tujuan'];
$perihal = $_POST['perihal'];
$ket = $_POST['ket'];
$jenis_laporan = $_POST['jenis_laporan'];

// File upload handling
$targetDir = "uploads/"; // Folder untuk menyimpan file upload
$fileName = basename($_FILES["file"]["name"]); // Nama file yang diupload
$targetFilePath = $targetDir . $fileName; // Path lengkap file yang akan disimpan
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); // Ekstensi file

// Cek apakah file sudah diupload atau belum
if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
    // Mengizinkan hanya beberapa jenis file tertentu (misalnya: PDF, docx, dll)
    $allowTypes = array('pdf', 'doc', 'docx');
    if (in_array($fileType, $allowTypes)) {
        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Insert data ke database setelah file berhasil diupload
            $query = "INSERT INTO input (kd_reporting, nama_laporan, kd_pengenalUnit, tgl_unggah, tujuan, perihal, ket, jenis_laporan, file) VALUES ('$kd_reporting', '$nama_laporan', '$kd_pengenalUnit', '$tgl_unggah', '$tujuan', '$perihal', '$ket', '$jenis_laporan', '$fileName')";
            $result = $koneksi->query($query);
            if ($result) {
                echo "<script>alert('Data berhasil disimpan.');</script>";
                echo "<script>window.location.href = 'index.php';</script>";
            } else {
                echo "Gagal menyimpan data.";
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload file.";
        }
    } else {
        echo "Maaf, hanya file PDF, DOC, dan DOCX yang diizinkan untuk diupload.";
    }
} else {
    echo "Mohon lengkapi semua kolom dan pilih file yang akan diupload.";
}
?>
