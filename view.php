<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Pastikan file yang akan ditampilkan adalah file PDF
    $fileType = pathinfo($file, PATHINFO_EXTENSION);
    if ($fileType == 'pdf') {
        // Tampilkan file PDF dalam iframe
        echo "<iframe src='$file' width='100%' height='1000px'></iframe>";
    } else {
        echo "File yang diminta bukan file PDF.";
    }
} else {
    echo "File tidak ditemukan.";
}
?>
