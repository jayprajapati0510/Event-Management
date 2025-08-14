<?php
include 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->store_result();
    
    if($stmt->num_rows > 0){
        $message = "Email already registered!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
        $stmt->bind_param("sss",$name,$email,$password);
        if($stmt->execute()){
            $message = "Registration successful! <a href='login.php'>Login Here</a>";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration 📖</title>
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
        .register-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .register-card h2 {
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
        a.login-link {
            display: block;
            margin-top: 10px;
            color: #6c5ce7;
            text-decoration: none;
            transition: 0.3s;
        }
        a.login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-card">
    <h2>User Registration 📖</h2>
    <?php if($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="name" class="form-control" placeholder="Name" required>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    <a href="login.php" class="login-link">Already have an account? Login</a>
</div>

</body>
</html>
