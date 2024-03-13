<?php
session_start();

// Unset semua variabel session
$_SESSION = array();

// Hapus session
session_destroy();

// Redirect ke halaman login
header("location: login");
exit;
?>
