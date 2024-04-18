<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Koneksi ke database
    $servername = "localhost";
    $usernameDB = "root";
    $passwordDB = "";
    $dbname = "sertifikat_online";

    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari admin berdasarkan username
    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Jika berhasil, simpan sesi dan redirect ke dashboard admin
            $_SESSION['admin'] = $username;

            // Set cookie if "Remember Me" is checked
            if (!empty($_POST["remember"])) {
                setcookie("admin_username", $username, time() + (86400 * 30), "/"); // 30 days
            }

            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Jika password salah, tampilkan pesan error
            echo "<script>alert('Password salah. Silakan coba lagi.');</script>";
        }
    } else {
        // Jika username tidak ditemukan, tampilkan pesan error
        echo "<script>alert('Username tidak ditemukan. Silakan coba lagi.');</script>";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href=" style1.css">
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

nav {
    background-color: #333;
    color: #fff;
    padding: 10px 0;
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

.container {
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    width: 80%;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.container h2 {
    margin-bottom: 20px;
}

form {
    margin-top: 20px;
}

form label {
    display: block;
    margin-bottom: 10px;
}

form select,
form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

form textarea {
    resize: none;
    height: 100px;
}

form input[type="submit"] {
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
}
 </style>
<body>
    <div class="container">
        <h2>Login Admin</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>