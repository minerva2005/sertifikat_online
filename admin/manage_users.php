<!-- manage_users.php -->
<?php
session_start();
// Pastikan admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}
// Koneksi ke database
include_once("../includes/koneksi.php");
// Ambil daftar pengguna dari database
$query = "SELECT * FROM users";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <!-- Tautkan file CSS manage_users.css -->
    <link rel="stylesheet" href="../assets/css/manage_uses.css">
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
<nav>
        <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="create_event.php">Create Event</a></li>
        <li><a href="view_event.php">View Events</a></li>
        <li><a href="generate_certificates.php">Generate Certificates</a></li>
        <li><a href="manage_users.php">Manage Users</a></li> <!-- Tautan baru untuk mengelola pengguna -->
        <li><a href="view_certificates.php">View Certificates</a></li>
        <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>

<body>
    <!-- Tampilkan navigasi -->
    <div class="container">
        <h1>Manage Users</h1>
        <!-- Tampilkan daftar pengguna dalam tabel -->
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $row['user_id']; ?>">Edit</a>
                                <a href="delete_user.php?id=<?php echo $row['user_id']; ?>">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="add_user.php">Add New User</a>
    </div>
</body>
</html>
