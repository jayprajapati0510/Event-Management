<?php
session_start();
include 'db.php';

$events = $conn->query("SELECT * FROM events ORDER BY date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upcoming Events 🎉</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg,#71b7e6,#9b59b6);
            padding: 30px 0;
        }
        nav a {
            margin-right: 15px;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 30px;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .event-card {
            background: #fff;
            border-radius: 15px;
            width: 300px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            transition: transform 0.3s;
        }
        .event-card:hover {
            transform: translateY(-5px);
        }
        .event-card h5 {
            color: #333;
            margin-bottom: 10px;
        }
        .event-card p {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }
        .event-card .btn {
            border-radius: 10px;
            width: 100%;
            font-weight: bold;
        }
        .btn-book {
            background: #6c5ce7;
            color: #fff;
        }
        .btn-book:hover {
            background: #341f97;
        }
        .login-msg {
            color: #d63031;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<nav class="text-center mb-4">
<?php if(isset($_SESSION['user_id'])): ?>
    Welcome, <?= $_SESSION['user_name'] ?> |
    <a href="mybookings.php">My Bookings</a> |
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="register.php">Register</a> 
    <a href="login.php"> Login </a>
<?php endif; ?>
</nav>

<h2>Upcoming Events</h2>
<div class="card-container">
<?php while($e = $events->fetch_assoc()): ?>
    <div class="event-card">
        <h5><?= htmlspecialchars($e['title']) ?></h5>
        <p><?= htmlspecialchars($e['description']) ?></p>
        <p><strong>Date:</strong> <?= $e['date'] ?></p>
        <p><strong>Seats Available:</strong> <?= $e['seats'] ?></p>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="book.php?event_id=<?= $e['id'] ?>" class="btn btn-book">Book Now</a>
        <?php else: ?>
            <p class="login-msg">Login to Book</p>
        <?php endif; ?>
    </div>
<?php endwhile; ?>
</div>

</body>
</html>
