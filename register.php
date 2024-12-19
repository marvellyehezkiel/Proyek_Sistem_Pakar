<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'sistem_pakar';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$register_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username && $password) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password_hashed')";
        
        if ($conn->query($sql) === TRUE) {
            $register_message = "Pendaftaran berhasil! Silakan login.";
        } else {
            $register_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $register_message = "Username atau password tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Pakar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Daftar Akun Baru</h1>
    </header>

    <div class="form-container">
        <h2>Daftar</h2>
        <?php if (!empty($register_message)) { echo "<p>$register_message</p>"; } ?>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit" name="register">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>

    <footer>
        <p>&copy; 2024 Sistem Pakar Penyakit Kucing</p>
    </footer>
</body>
</html>
