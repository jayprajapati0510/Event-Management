<?php
session_start();
include 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id,name,password FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(md5($password) == $user['password']){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.php");
            exit;
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "Email not registered!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login 🔑</title>
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
    <h2>User Login 🔑</h2>
    <?php if($message): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <a href="register.php" class="register-link">Don't have an account? Register</a>
</div>

</body>
</html>
