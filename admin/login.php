<?php
session_start();
include '../db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $pass = md5($_POST['password']); // agar database me md5 stored hai

    $sql = "SELECT * FROM admin_users WHERE username='$user' AND password='$pass'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        $_SESSION['admin'] = $user;
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login 😎</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-card h2 {
            margin-bottom: 25px;
            color: #333;
        }
        .form-control {
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .btn-primary {
            background: #6c5ce7;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background: #341f97;
        }
        .alert {
            border-radius: 10px;
            margin-bottom: 15px;
        }
        a.register-link {
            display: block;
            margin-top: 10px;
            color: #6c5ce7;
            text-decoration: none;
            transition: 0.3s;
        }
        a.register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Admin Login 😎</h2>
    <?php if($message): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

</body>
</html>
