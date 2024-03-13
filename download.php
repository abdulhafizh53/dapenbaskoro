<?php
// Konfigurasi database
include 'koneksi.php';

if (isset($_GET['file'])) {
    // Ambil path file dari parameter URL
    $file = $_GET['file'];

    // Tentukan nama file yang akan digunakan saat diunduh
    $fileName = basename($file);

    // Tentukan header yang tepat untuk mengatur jenis konten
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    
    // Baca file dan kirimkan isinya ke output
    readfile($file);
    
    exit();
} else {
    echo "File tidak ditemukan.";
}
?>
