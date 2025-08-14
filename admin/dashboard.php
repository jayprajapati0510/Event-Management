<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

$events = $conn->query("SELECT * FROM events ORDER BY date ASC");
?>

<!DOCTYPE html>
<html>
<head>
 <title>Admin Dashboard</title>
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
    h3 {
        margin-top: 30px;
        color: #495057;
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
    nav a {
        margin-right: 10px;
        margin-bottom: 10px;
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
    <h2>Welcome Admin: <?= $_SESSION['admin'] ?></h2>
    <nav class="mb-3">
        <a href="add_event.php" class="btn btn-success btn-sm">+ Add Event</a>
        <a href="bookings.php" class="btn btn-info btn-sm">View Bookings</a>
        <a href="../logout.php" class="btn btn-secondary btn-sm">Logout</a>
    </nav>

    <h3>All Events</h3>
    <div class="table-container">
        <table class="table table-bordered">
        <tr>
            <th>ID</th><th>Title</th><th>Date</th><th>Seats</th><th>Action</th>
        </tr>
        <?php while($e = $events->fetch_assoc()): ?>
        <tr>
            <td><?= $e['id'] ?></td>
            <td><?= htmlspecialchars($e['title']) ?></td>
            <td><?= $e['date'] ?></td>
            <td><?= $e['seats'] ?></td>
            <td>
                <a href="edit_event.php?id=<?= $e['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_event.php?id=<?= $e['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this event?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>
