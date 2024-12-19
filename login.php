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

$login_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username && $password) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $login_message = "Username atau password salah.";
            }
        } else {
            $login_message = "Username tidak ditemukan.";
        }
    } else {
        $login_message = "Username atau password tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pakar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Login ke Sistem Pakar</h1>
    </header>

    <div class="form-container">
        <h2>Login</h2>
        <?php if (!empty($login_message)) { echo "<p>$login_message</p>"; } ?>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit" name="login">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>

    <footer>
        <p>&copy; 2024 Sistem Pakar Penyakit Kucing</p>
    </footer>
</body>
</html>
