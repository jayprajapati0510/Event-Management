<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$query = "SELECT b.*, u.name as user_name, e.title as event_title, e.date as event_date 
          FROM bookings b 
          JOIN users u ON b.user_id=u.id 
          JOIN events e ON b.event_id=e.id 
          ORDER BY b.booked_at DESC";
$bookings = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Bookings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f0f2f5;
        padding: 40px 0;
    }
    h2 {
        text-align: center;
        color: #343a40;
        margin-bottom: 20px;
    }
    .btn {
        border-radius: 8px;
        font-weight: bold;
    }
    .btn:hover {
        opacity: 0.9;
    }
    .table-container {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        margin-top: 20px;
    }
    table th {
        background: #007bff;
        color: #fff;
    }
    table tr:hover {
        background: #f1f1f1;
    }
    @media (max-width:768px){
        table, th, td {
            font-size: 14px;
        }
    }
  </style>
</head>
<body>
<div class="container">
    <h2>All Bookings</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
    <div class="table-container">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Event</th>
                <th>Date</th>
                <th>Seats</th>
                <th>Booked At</th>
            </tr>
            <?php while($b=$bookings->fetch_assoc()): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= htmlspecialchars($b['user_name']) ?></td>
                <td><?= htmlspecialchars($b['event_title']) ?></td>
                <td><?= $b['event_date'] ?></td>
                <td><?= $b['seats_booked'] ?></td>
                <td><?= $b['booked_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>
