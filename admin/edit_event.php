<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $date = $_POST['date'];
    $seats = $_POST['seats'];

    $stmt = $conn->prepare("UPDATE events SET title=?, description=?, date=?, seats=? WHERE id=?");
    $stmt->bind_param("sssii",$title,$desc,$date,$seats,$id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Event ✏️</title>
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
        margin-bottom: 30px;
    }
    .form-container {
        max-width: 600px;
        margin: auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .form-control {
        border-radius: 8px;
    }
    textarea.form-control {
        height: 120px;
    }
    button, .btn-secondary {
        border-radius: 8px;
        font-weight: bold;
    }
    button:hover {
        opacity: 0.9;
    }
    .btn-back {
        margin-left: 10px;
    }
  </style>
</head>
<body>
<div class="form-container">
<h2>Edit Event</h2>
<form method="POST">
<div class="mb-3">
<input type="text" name="title" class="form-control" value="<?= htmlspecialchars($event['title']) ?>" placeholder="Event Title" required>
</div>
<div class="mb-3">
<textarea name="description" class="form-control" placeholder="Event Description" required><?= htmlspecialchars($event['description']) ?></textarea>
</div>
<div class="mb-3">
<input type="date" name="date" class="form-control" value="<?= $event['date'] ?>" required>
</div>
<div class="mb-3">
<input type="number" name="seats" class="form-control" value="<?= $event['seats'] ?>" placeholder="Number of Seats" required>
</div>
<button type="submit" class="btn btn-primary">Update Event</button>
<a href="dashboard.php" class="btn btn-secondary btn-back">Back</a>
</form>
</div>
</body>
</html>
