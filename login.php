<?php
session_start();
// Include your conn.php file for database connection
include 'koneksi.php';

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Koneksi ke database
$servername = "localhost"; // Ganti dengan host database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "dapenarsip"; // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk melakukan login
function login($nik, $password, $conn) {
    // Lindungi dari SQL Injection
    $nik = mysqli_real_escape_string($conn, $nik);
    $password = mysqli_real_escape_string($conn, $password);

    // Query untuk mengambil data pengguna dari tabel users
    $sql = "SELECT * FROM users WHERE nik='$nik' AND password=MD5('$password')";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Jika berhasil login
        $row = $result->fetch_assoc();
        return $row;
    } else {
        // Jika gagal login
        return false;
    }
}

// Cek apakah form login telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nik = $_POST["nik"];
    $password = $_POST["password"];

    // Coba melakukan login
    $user = login($nik, $password, $conn);

    if ($user) {
        // Jika berhasil login, arahkan ke halaman berhasillogin.php
        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION["nik"] = $user["nik"];
        $_SESSION["nama"] = $user["nama"];
        $_SESSION["role"] = $user["role"]; // Simpan peran pengguna ke dalam sesi

        
        header("location: index");
    } else {
        // Jika login gagal, tampilkan pesan error
        $error = "NIK atau Password salah!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css\login.css">
<title>Login</title>
<style>

</style>
</head>
<body>
    <div class="login-container">
        <img src="asset\img\logodapen.png" alt="Logo" class="logo">
        <!-- Form login dengan field NIK dan Password -->
        <div class="form-container">
            <h2>Login</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                    <input type="text" id="nik" name="nik" placeholder="Masukkan NIK Anda" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
            </form>
            <?php
            // Tampilkan pesan kesalahan jika login gagal
            if (isset($error)) {
                echo "<div style='color: red;'>$error</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
<?php
// Tutup koneksi database
$conn->close();
?>
