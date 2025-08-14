<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT b.*, e.title, e.date FROM bookings b JOIN events e ON b.event_id=e.id WHERE b.user_id=? ORDER BY b.booked_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$bookings = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Bookings 🎟️</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg,#71b7e6,#9b59b6);
        padding: 30px 0;
    }
    h2 {
        text-align: center;
        color: #fff;
        margin-bottom: 30px;
    }
    .container-bookings {
        max-width: 900px;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        background: #6c5ce7;
        color: #fff;
        padding: 12px;
        text-align: left;
        border-radius: 8px 8px 0 0;
    }
    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    tr:hover {
        background: #f1f1f1;
    }
    .btn-back {
        margin-bottom: 15px;
        border-radius: 10px;
        font-weight: bold;
    }
  </style>
</head>
<body>
<h2>My Bookings</h2>
<div class="container-bookings">
<a href="index.php" class="btn btn-secondary btn-back">Back to Events</a>
<table class="table">
<tr>
<th>Event</th><th>Date</th><th>Seats</th><th>Booked At</th>
</tr>
<?php while($b = $bookings->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($b['title']) ?></td>
<td><?= $b['date'] ?></td>
<td><?= $b['seats_booked'] ?></td>
<td><?= $b['booked_at'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>
</body>
</html>
