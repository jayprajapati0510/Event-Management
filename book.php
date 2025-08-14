<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$event_id = $_GET['event_id'];
$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

$message = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $seats_booked = $_POST['seats'];
    $stmt = $conn->prepare("INSERT INTO bookings (user_id,event_id,seats_booked) VALUES (?,?,?)");
    $stmt->bind_param("iii", $_SESSION['user_id'], $event_id, $seats_booked);
    if($stmt->execute()){
        $message = "Booking Successful! <a href='mybookings.php'>View My Bookings</a>";
    } else {
        $message = "Error: ".$conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Event 🎫</title>
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
    .card {
        background: #fff;
        padding: 40px 30px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }
    .card h2 {
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
    .btn-secondary {
        border-radius: 10px;
    }
    .alert {
        border-radius: 10px;
        margin-bottom: 15px;
    }
</style>
</head>
<body>

<div class="card">
    <h2>Book Event: <?= htmlspecialchars($event['title']) ?></h2>
    <?php if($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="number" name="seats" min="1" max="<?= $event['seats'] ?>" class="form-control" placeholder="Number of Seats" required>
        <button type="submit" class="btn btn-primary w-100">Book</button>
        <a href="index.php" class="btn btn-secondary w-100 mt-2">Back</a>
    </form>
</div>

</body>
</html>
